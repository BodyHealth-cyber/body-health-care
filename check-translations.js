/**
 * Build guard for dist/js/translations.js.
 *
 * A stray double comma once broke this file's syntax. Because the language
 * switcher fails silently when window.BH_TRANSLATIONS is undefined, the switcher
 * was dead site-wide and nothing in the build complained. This check makes that
 * class of error fail the build instead.
 */
global.window = {};
require('./dist/js/translations.js');

const T = window.BH_TRANSLATIONS;
if (!T) {
    console.error('translations.js did not define window.BH_TRANSLATIONS');
    process.exit(1);
}

const REFERENCE = 'uk';
const base = Object.keys(T[REFERENCE] || {});
if (!base.length) {
    console.error(`translations.js has no keys under "${REFERENCE}"`);
    process.exit(1);
}

let failed = false;
for (const lang of Object.keys(T)) {
    const missing = base.filter(k => !(k in T[lang]));
    const extra = Object.keys(T[lang]).filter(k => !base.includes(k));
    if (missing.length || extra.length) {
        failed = true;
        if (missing.length) console.error(`  ${lang}: missing ${missing.length} — ${missing.slice(0, 8).join(', ')}`);
        if (extra.length) console.error(`  ${lang}: extra ${extra.length} — ${extra.slice(0, 8).join(', ')}`);
    }
}

if (failed) {
    console.error(`translations.js: locales are out of sync with "${REFERENCE}"`);
    process.exit(1);
}

console.log(`translations.js: ${Object.keys(T).length} locales x ${base.length} keys, in sync`);
