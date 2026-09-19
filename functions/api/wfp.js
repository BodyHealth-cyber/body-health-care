/**
 * Приём уведомлений WayForPay про оплату. Адрес /api/wfp — його вписано
 * в кабінеті як Service URL.
 *
 * Навіщо. У WayForPay сповіщення про оплату можна надіслати лише тим, хто
 * має доступ до кабінету, тож група «BodyHealth · Requests» там недоступна.
 * Тут ми беремо те саме сповіщення собі й кладемо картку в ту саму групу,
 * де вже лежать заявки: адміністратор бачить заявку й оплату поруч.
 *
 * Підпис. WayForPay підписує HMAC-MD5 по полях
 *   merchantAccount;orderReference;amount;currency;authCode;cardPan;
 *   transactionStatus;reasonCode
 * Відповідь треба підписати так само по orderReference;status;time.
 * MD5 у Workers немає у Web Crypto, тому він тут свій — перевірений
 * векторами RFC 1321 і RFC 2202.
 *
 * Змінні оточення:
 *   WFP_MERCHANT_SECRET — секретний ключ магазину з кабінету WayForPay;
 *   TELEGRAM_BOT_TOKEN, TELEGRAM_CHAT_ID — ті самі, що для заявок.
 */

/* ---------- MD5 ---------- */
function md5(bytes) {
    const S = [7,12,17,22,7,12,17,22,7,12,17,22,7,12,17,22,
               5,9,14,20,5,9,14,20,5,9,14,20,5,9,14,20,
               4,11,16,23,4,11,16,23,4,11,16,23,4,11,16,23,
               6,10,15,21,6,10,15,21,6,10,15,21,6,10,15,21];
    const K = new Int32Array(64);
    for (let i = 0; i < 64; i++) K[i] = (Math.floor(Math.abs(Math.sin(i + 1)) * 4294967296)) | 0;

    const len = bytes.length;
    const withPad = new Uint8Array((((len + 8) >> 6) + 1) << 6);
    withPad.set(bytes);
    withPad[len] = 0x80;
    const bitLen = len * 8;
    const dv = new DataView(withPad.buffer);
    dv.setUint32(withPad.length - 8, bitLen >>> 0, true);
    dv.setUint32(withPad.length - 4, Math.floor(bitLen / 4294967296), true);

    let a0 = 0x67452301 | 0, b0 = 0xefcdab89 | 0, c0 = 0x98badcfe | 0, d0 = 0x10325476 | 0;
    const M = new Int32Array(16);

    for (let off = 0; off < withPad.length; off += 64) {
        for (let i = 0; i < 16; i++) M[i] = dv.getInt32(off + i * 4, true);
        let A = a0, B = b0, C = c0, D = d0;
        for (let i = 0; i < 64; i++) {
            let F, g;
            if (i < 16)      { F = (B & C) | (~B & D);          g = i; }
            else if (i < 32) { F = (D & B) | (~D & C);          g = (5 * i + 1) & 15; }
            else if (i < 48) { F = B ^ C ^ D;                   g = (3 * i + 5) & 15; }
            else             { F = C ^ (B | ~D);                g = (7 * i) & 15; }
            F = (F + A + K[i] + M[g]) | 0;
            A = D; D = C; C = B;
            B = (B + ((F << S[i]) | (F >>> (32 - S[i])))) | 0;
        }
        a0 = (a0 + A) | 0; b0 = (b0 + B) | 0; c0 = (c0 + C) | 0; d0 = (d0 + D) | 0;
    }
    const out = new Uint8Array(16);
    const odv = new DataView(out.buffer);
    odv.setInt32(0, a0, true); odv.setInt32(4, b0, true);
    odv.setInt32(8, c0, true); odv.setInt32(12, d0, true);
    return out;
}

function hmacMd5Hex(keyStr, msgStr) {
    const enc = new TextEncoder();
    let key = enc.encode(keyStr);
    if (key.length > 64) key = md5(key);
    const ipad = new Uint8Array(64), opad = new Uint8Array(64);
    for (let i = 0; i < 64; i++) {
        const k = i < key.length ? key[i] : 0;
        ipad[i] = k ^ 0x36;
        opad[i] = k ^ 0x5c;
    }
    const msg = enc.encode(msgStr);
    const inner = new Uint8Array(64 + msg.length);
    inner.set(ipad); inner.set(msg, 64);
    const innerHash = md5(inner);
    const outer = new Uint8Array(64 + 16);
    outer.set(opad); outer.set(innerHash, 64);
    const h = md5(outer);
    let hex = '';
    for (let i = 0; i < h.length; i++) hex += h[i].toString(16).padStart(2, '0');
    return hex;
}

/* ---------- сповіщення ---------- */
function esc(v) {
    return String(v === undefined || v === null ? '' : v)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

function kyiv(ts) {
    const d = new Date(Number(ts) * 1000);
    if (isNaN(d.getTime())) return '';
    try {
        return new Intl.DateTimeFormat('uk-UA', {
            timeZone: 'Europe/Kyiv', day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit',
        }).format(d);
    } catch (e) { return ''; }
}

const TITLES = {
    Approved: '💳 Оплата пройшла',
    Declined: '⚠️ Оплату відхилено',
    Refunded: '↩️ Повернення коштів',
    Voided: '↩️ Платіж скасовано',
    Expired: '⌛ Термін оплати минув',
    Pending: '⏳ Платіж в обробці',
    InProcessing: '⏳ Платіж в обробці',
    RefundInProcessing: '↩️ Повернення в обробці',
};

async function notify(env, p) {
    if (!env.TELEGRAM_BOT_TOKEN || !env.TELEGRAM_CHAT_ID) return;
    const st = String(p.transactionStatus || '');
    const lines = [];
    lines.push('<b>' + esc(TITLES[st] || ('Платіж: ' + st)) + '</b>');
    if (p.amount) lines.push('Сума: <b>' + esc(p.amount) + ' ' + esc(p.currency || '') + '</b>');
    if (p.email) lines.push('Пошта: ' + esc(p.email));
    if (p.phone) lines.push('Телефон: ' + esc(p.phone));
    if (p.products && p.products.length) lines.push('Товар: ' + esc([].concat(p.products).join(', ')));
    if (p.orderReference) lines.push('Замовлення: <code>' + esc(p.orderReference) + '</code>');
    const when = kyiv(p.processingDate || p.createdDate);
    if (when) lines.push('Час: ' + esc(when));
    if (st !== 'Approved' && p.reason) lines.push('Причина: ' + esc(p.reason));
    lines.push('');
    lines.push('Деталі — у пошті billing@body-health.care та в кабінеті WayForPay.');

    try {
        const res = await fetch(
            'https://api.telegram.org/bot' + env.TELEGRAM_BOT_TOKEN + '/sendMessage',
            { method: 'POST', headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify({ chat_id: env.TELEGRAM_CHAT_ID, text: lines.join('\n'),
                                     parse_mode: 'HTML', disable_web_page_preview: true }) });
        if (!res.ok) console.error('wfp telegram:', res.status, (await res.text()).slice(0, 200));
    } catch (e) { console.error('wfp telegram: не відправлено', e); }
}

/* ---------- ручка ---------- */
export async function onRequestPost(context) {
    const { request, env } = context;

    let raw = '';
    try { raw = await request.text(); } catch (e) { raw = ''; }

    // WayForPay шле або чистий JSON, або form-encoded, де все тіло — один ключ.
    let p = null;
    try { p = JSON.parse(raw); } catch (e) {
        try {
            const params = new URLSearchParams(raw);
            for (const [k, v] of params) { if (!v && k) { p = JSON.parse(k); break; } }
            if (!p) { const s = params.get('data'); if (s) p = JSON.parse(s); }
        } catch (e2) { p = null; }
    }
    if (!p || !p.orderReference) {
        console.error('wfp: тіло не розібрано');
        return new Response('bad request', { status: 400 });
    }

    const secret = env.WFP_MERCHANT_SECRET;
    if (!secret) {
        // Без ключа підпис не перевірити, а вірити неперевіреному не можна:
        // приймаємо, щоб WayForPay не повторював, але в групу не пишемо.
        console.error('wfp: не задано WFP_MERCHANT_SECRET, сповіщення пропущено');
        return respond(p.orderReference, null);
    }

    const base = [p.merchantAccount, p.orderReference, p.amount, p.currency,
                  p.authCode, p.cardPan, p.transactionStatus, p.reasonCode]
                 .map((v) => (v === undefined || v === null ? '' : String(v))).join(';');
    const expect = hmacMd5Hex(secret, base);
    if (String(p.merchantSignature || '').toLowerCase() !== expect) {
        console.error('wfp: підпис не збігся для', p.orderReference);
        return new Response('bad signature', { status: 400 });
    }

    if (context.waitUntil) context.waitUntil(notify(env, p));
    else await notify(env, p);

    return respond(p.orderReference, secret);
}

function respond(orderReference, secret) {
    const time = Math.floor(Date.now() / 1000);
    const body = { orderReference: orderReference, status: 'accept', time: time };
    body.signature = secret ? hmacMd5Hex(secret, [orderReference, 'accept', time].join(';')) : '';
    return new Response(JSON.stringify(body), {
        status: 200,
        headers: { 'Content-Type': 'application/json; charset=utf-8', 'Cache-Control': 'no-store' },
    });
}

export async function onRequest(context) {
    if (context.request.method === 'POST') return onRequestPost(context);
    return new Response(JSON.stringify({ ok: false, error: 'method_not_allowed' }), {
        status: 405, headers: { 'Content-Type': 'application/json; charset=utf-8', Allow: 'POST' } });
}
