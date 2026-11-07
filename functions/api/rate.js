/**
 * Офіційний курс гривні до долара. Адреса /api/rate.
 *
 * Навіщо. Ціна пакетів встановлюється у гривні — так само, як відбувається
 * списання. Англомовному відвідувачу гривня нічого не каже, тому на /en/
 * сторінках сума показується в доларах. Щоб цей перерахунок не застарівав,
 * курс береться з відкритого довідника Національного банку України, а не
 * зашивається в сторінку: інакше кожна зміна курсу вимагала б пересборки
 * сайту, а між пересборками цифра брехала б.
 *
 * Чому саме НБУ. Це офіційний курс, на який посилається п. 6.1 Публічної
 * оферти. Він не збігається з комерційним курсом платіжної системи, і саме
 * тому поруч із доларом на сторінці стоїть підпис, що це приблизний
 * перерахунок, а не ціна списання.
 *
 * Кешування. Курс НБУ змінюється раз на добу, тож відповідь кешується на
 * 12 годин на краю Cloudflare і стільки ж у браузері. Ліміт звернень до
 * bank.gov.ua таким чином не чіпається навіть за великого трафіку.
 *
 * Якщо НБУ не відповів, функція повертає 503 без тіла. Сторінка в такому
 * разі лишає цифру, вшиту під час збірки, і відвідувач не бачить ні
 * порожнього місця, ні нуля.
 *
 * Ключів і змінних оточення не потребує: довідник НБУ відкритий.
 */

const NBU = 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?valcode=USD&json';
const TTL = 12 * 60 * 60;

export async function onRequestGet() {
    let rate = null, day = null;
    try {
        const r = await fetch(NBU, {
            cf: { cacheTtl: TTL, cacheEverything: true },
            headers: { 'Accept': 'application/json' },
        });
        if (r.ok) {
            const rows = await r.json();
            const row = Array.isArray(rows) ? rows[0] : null;
            if (row && typeof row.rate === 'number' && row.rate > 0) {
                rate = row.rate;
                day = typeof row.exchangedate === 'string' ? row.exchangedate : null;
            }
        }
    } catch (e) {
        rate = null;
    }

    if (!rate) {
        return new Response(null, {
            status: 503,
            headers: { 'Cache-Control': 'no-store' },
        });
    }

    return new Response(JSON.stringify({ usd: rate, date: day, source: 'NBU' }), {
        headers: {
            'Content-Type': 'application/json; charset=utf-8',
            'Cache-Control': `public, max-age=${TTL}, s-maxage=${TTL}`,
        },
    });
}
