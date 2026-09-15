/**
 * Build guard for the i18n catalogs in i18n/<lang>.json.
 *
 * Locales are pre-rendered into dist/<lang>/ by build-locales.py; a string with
 * no catalog entry silently falls back to Ukrainian. That is the right runtime
 * behaviour but a bad failure mode to leave unmeasured, so this reports coverage
 * per locale and fails only on a catalog that cannot be parsed or is empty.
 */
const fs = require('fs');
const path = require('path');

const LOCALES = ['en', 'ru'];
let failed = false;

for (const lang of LOCALES) {
    const file = path.join('i18n', `${lang}.json`);
    if (!fs.existsSync(file)) {
        console.error(`  ${lang}: ${file} is missing`);
        failed = true;
        continue;
    }
    let cat;
    try {
        cat = JSON.parse(fs.readFileSync(file, 'utf8'));
    } catch (e) {
        console.error(`  ${lang}: ${file} is not valid JSON — ${e.message}`);
        failed = true;
        continue;
    }
    const entries = Object.keys(cat);
    const empty = entries.filter(k => !cat[k] || !String(cat[k]).trim());
    if (!entries.length) {
        console.error(`  ${lang}: catalog is empty`);
        failed = true;
        continue;
    }
    if (empty.length) {
        console.error(`  ${lang}: ${empty.length} entries have no translation — ${empty.slice(0, 5).join(' | ')}`);
        failed = true;
        continue;
    }
    console.log(`i18n/${lang}.json: ${entries.length} entries`);
}

process.exit(failed ? 1 : 0);
