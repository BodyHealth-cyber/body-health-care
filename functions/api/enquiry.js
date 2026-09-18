/**
 * Приём заявок с сайта. Cloudflare Pages Function, адрес /api/enquiry.
 *
 * Раньше форма отправляла заявку из браузера прямо на hook.eu1.make.com.
 * Из этого следовали две вещи. Первая: адрес вебхука лежал открытым текстом
 * в коде каждой страницы, и слать туда мусор мог кто угодно — каждая пустышка
 * стоит кредитов Make и кладёт строку в таблицу заявок. Вторая: отправка шла
 * мимо Cloudflare, поэтому ни ограничение частоты, ни правила WAF к ней не
 * применялись — защищать было нечего.
 *
 * Теперь заявка идёт на собственный адрес сайта. Здесь проверяется ответ
 * Turnstile, и только после этого заявка уходит в Make. Мусор без пройденной
 * проверки до Make не доходит вовсе и не стоит ни одного кредита.
 *
 * Значения приходят из переменных окружения проекта Pages:
 *   TURNSTILE_SECRET_KEY — секретный ключ виджета, в коде его нет;
 *   MAKE_WEBHOOK_URL     — адрес вебхука, из кода страниц он убран;
 *   TELEGRAM_BOT_TOKEN   — необязательно: уведомление администратору;
 *   TELEGRAM_CHAT_ID     — необязательно: куда слать уведомление.
 *
 * Уведомление в Telegram отправляется отсюда, а не из Make, по трём причинам.
 * Оно приходит на секунду раньше письма, не тратит кредитов Make (их 1000 в
 * месяц, а каждая заявка уже стоит около четырёх) и не добавляет ещё одного
 * места, где сценарий может встать. Если Telegram не ответил — заявка всё
 * равно засчитана: уведомление уходит в фоне и ничего не ломает.
 */

const SITEVERIFY = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

// Заявка — это несколько строк текста. Всё, что заметно больше, прислано не
// человеком, и разбирать это незачем.
const MAX_BODY_BYTES = 20 * 1024;

function json(status, body) {
    return new Response(JSON.stringify(body), {
        status: status,
        headers: {
            'Content-Type': 'application/json; charset=utf-8',
            'Cache-Control': 'no-store',
        },
    });
}

export async function onRequestPost(context) {
    const { request, env } = context;

    if (!env.TURNSTILE_SECRET_KEY || !env.MAKE_WEBHOOK_URL) {
        // Настройка не завершена. Молчать нельзя: на сайте есть запасной путь
        // (телефон, Telegram, WhatsApp), он включается именно по ошибке.
        console.error('enquiry: не заданы TURNSTILE_SECRET_KEY или MAKE_WEBHOOK_URL');
        return json(500, { ok: false, error: 'not_configured' });
    }

    const raw = await request.text();
    if (raw.length > MAX_BODY_BYTES) {
        return json(413, { ok: false, error: 'too_large' });
    }

    let payload;
    try {
        payload = JSON.parse(raw);
    } catch (e) {
        return json(400, { ok: false, error: 'bad_json' });
    }

    const token = payload && payload.turnstile_token;
    if (!token || typeof token !== 'string') {
        return json(400, { ok: false, error: 'turnstile_missing' });
    }

    const form = new FormData();
    form.append('secret', env.TURNSTILE_SECRET_KEY);
    form.append('response', token);
    const ip = request.headers.get('CF-Connecting-IP');
    if (ip) form.append('remoteip', ip);

    let verdict;
    try {
        const res = await fetch(SITEVERIFY, { method: 'POST', body: form });
        verdict = await res.json();
    } catch (e) {
        // Проверка недоступна. Заявку не теряем: человек увидит ошибку и
        // получит прямые способы связи.
        console.error('enquiry: siteverify недоступен', e);
        return json(502, { ok: false, error: 'verify_unavailable' });
    }

    if (!verdict || verdict.success !== true) {
        return json(400, {
            ok: false,
            error: 'turnstile_failed',
            codes: (verdict && verdict['error-codes']) || [],
        });
    }

    // Дальше в Make уходит всё, кроме самого ответа Turnstile: он одноразовый
    // и в заявке не нужен.
    delete payload.turnstile_token;
    payload.verified_by = 'turnstile';

    let upstream;
    try {
        upstream = await fetch(env.MAKE_WEBHOOK_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });
    } catch (e) {
        console.error('enquiry: вебхук недоступен', e);
        return json(502, { ok: false, error: 'upstream_unavailable' });
    }

    if (!upstream.ok) {
        console.error('enquiry: вебхук ответил', upstream.status);
        return json(502, { ok: false, error: 'upstream_error', status: upstream.status });
    }

    // Уведомление администратору. Осознанно без данных о здоровье: баллы
    // индекса лежат в поле message и в Telegram не уходят — там контакт и
    // повод позвонить, остальное в почте и таблице.
    if (context.waitUntil) context.waitUntil(notifyTelegram(env, payload));
    else await notifyTelegram(env, payload);

    return json(200, { ok: true });
}

function esc(v) {
    return String(v === undefined || v === null ? '' : v)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

const TITLES = {
    client: '🩺 Нова заявка з сайту',
    b2b: '🏢 Заявка від компанії',
    newsletter: '✉️ Підписка на розсилку',
};

// Откуда пришла заявка — администратору это первое, что нужно знать.
const SOURCES = {
    '/health-check': 'Індекс здоров\'я',
    '/for-companies': 'Сторінка для компаній',
    '/blog': 'Блог',
    '/services': 'Послуги',
    '/': 'Головна',
};

function sourceLabel(url) {
    if (!url) return '';
    let path = '';
    try { path = new URL(url).pathname.replace(/\.html$/, '').replace(/\/+$/, '') || '/'; }
    catch (e) { return ''; }
    return SOURCES[path] || path;
}

function kyivTime(iso) {
    const d = iso ? new Date(iso) : new Date();
    if (isNaN(d.getTime())) return '';
    try {
        return new Intl.DateTimeFormat('uk-UA', {
            timeZone: 'Europe/Kyiv', day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit',
        }).format(d);
    } catch (e) { return d.toISOString(); }
}

async function notifyTelegram(env, payload) {
    if (!env.TELEGRAM_BOT_TOKEN || !env.TELEGRAM_CHAT_ID) return;

    const type = payload.form_type || 'client';

    const name = [payload.first_name, payload.last_name]
        .filter((v) => v && v !== '—').join(' ').trim();

    const where = sourceLabel(payload.source_page);
    const when = payload.submitted_at || kyivTime(payload.timestamp);

    const lines = [];
    lines.push('<b>' + esc(TITLES[type] || TITLES.client) + '</b>');
    if (payload.service_label) lines.push(esc(payload.service_label));
    lines.push('');
    if (name) lines.push("Ім'я: <b>" + esc(name) + '</b>');
    if (payload.company) lines.push('Компанія: ' + esc(payload.company));
    if (payload.phone && payload.phone !== '—') lines.push('Телефон: <b>' + esc(payload.phone) + '</b>');
    if (payload.email) lines.push('Пошта: ' + esc(payload.email));
    if (where) lines.push('Звідки: ' + esc(where));
    if (when) lines.push('Час: ' + esc(when));
    lines.push('');
    lines.push(type === 'newsletter'
        ? 'Це підписка на розсилку, не заявка на консультацію.'
        : 'Деталі — у пошті info@body-health.care та в таблиці заявок.');

    try {
        const res = await fetch(
            'https://api.telegram.org/bot' + env.TELEGRAM_BOT_TOKEN + '/sendMessage',
            {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    chat_id: env.TELEGRAM_CHAT_ID,
                    text: lines.join('\n'),
                    parse_mode: 'HTML',
                    disable_web_page_preview: true,
                }),
            }
        );
        if (!res.ok) {
            // Молча терять уведомления нельзя: журнал — единственное место,
            // где видно, что бот отвалился, пока никто не жалуется.
            console.error('telegram: ответ', res.status, (await res.text()).slice(0, 200));
        }
    } catch (e) {
        console.error('telegram: не отправлено', e);
    }
}

// На GET и прочее отвечаем коротко: этот адрес только для отправки заявки.
export async function onRequest(context) {
    if (context.request.method === 'POST') return onRequestPost(context);
    if (context.request.method === 'OPTIONS') {
        return new Response(null, { status: 204, headers: { Allow: 'POST' } });
    }
    return json(405, { ok: false, error: 'method_not_allowed' });
}
