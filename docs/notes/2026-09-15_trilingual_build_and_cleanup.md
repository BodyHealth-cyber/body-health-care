# body-health.care — trilingual build and site cleanup, 15.09.2026

The site now exists in Ukrainian, English and Russian: 18 pages per locale, 54 in
total, with no string falling back to another language. This note records how the
locales are produced, because the mechanism is not obvious from the repo, and the
defects found along the way, because several had been live for a while.

## How locales are produced

`build.sh` → `build-locales.py` → `generate-sitemap.py`.

The Ukrainian pages in `resources/views/` are the source. `build-locales.py`
generates `dist/en/` and `dist/ru/` from them using catalogs in
`i18n/en.json` and `i18n/ru.json`, which map the exact Ukrainian string to its
translation. This is deliberately **not** client-side translation: the
linguistic strategy names English as the priority audience, and a JavaScript
switcher makes that audience's language invisible to crawlers, unshareable as a
URL, and prone to a flash of the wrong language.

Each generated page gets its own `<html lang>`, canonical, `og:url`, `og:locale`
and a full hreflang set; internal links are rewritten to stay inside the locale
while `/css`, `/js` and `/img` keep pointing at the shared root.

**The coverage gate matters.** A page is published in a locale only once 98% of
its strings are translated. Below that it is skipped entirely and nothing —
hreflang, sitemap, language menu — claims it exists. A two-thirds translated page
reads as broken in a way an absent one does not. This also means partial
translation work can be committed and pushed safely: it changes nothing live
until a page crosses the threshold.

Two content blocks are lifted out before translation and restored verbatim:
`<p class="lang">` in privacy.html (the clauses are intentionally stated in all
three languages) and every `<script>`/`<style>` body (code, not copy).

Language menu links and their active state are written at build time, so they
work without JavaScript and list only the locales a given page was published in.
`main.js` now only opens and closes the menu.

## Guards added to the build

- `node --check` over every file in `dist/js`.
- `check-translations.js` fails the build on an unparseable or empty catalog.
- `build-locales.py` prints per-locale coverage and writes the untranslated
  strings to `i18n/_missing/` (gitignored) so gaps are visible, not silent.

## Defects found and fixed

**The language switcher had been dead site-wide.** `translations.js` contained a
double comma in both the `en` and `ru` blocks, so the file never parsed,
`window.BH_TRANSLATIONS` was undefined, and `applyTranslations` returned early on
every page. The switcher was visible and inert, and nothing in the build noticed.

**Outline buttons were invisible on every light hero.** A `[class*="hero"]`
selector painted them white for a dark background, but only `.b2b-hero` is dark;
`.hero` is white and `.service-hero`/`.blog-hero` are `#f8f9fa`. "Порівняти
тарифи" on all three service pages was white on near-white.

**Any unknown URL returned the homepage with a 200.** No 404 page existed in the
build output, so every mistyped or stale link looked like a real page to visitors
and crawlers alike — unbounded duplicate content. Added `404.html` plus canonical
URLs on every page.

**Asset paths.** Seven blog articles and terms-and-conditions referenced an
unrendered Blade expression (`{ asset('css/style.css') }`) and loaded with no
styling at all. Dead `/pricing.html` and `/contacts.html` links pointed at pages
that do not exist and failed silently because of the 200 fallback.

**Blog index drift.** Cards showed December 2024 dates for articles dated
July–September 2026, three titles no longer matched the articles, and six of the
seven author names were spelled in Russian against the articles' Ukrainian. Cards
are now generated from each article's own `h1`, date, read time and excerpt, so
they cannot drift again without someone editing both.

**Form messages.** Both the contact form and the B2B webhook handler read
`window.BH_TRANSLATIONS` and `localStorage['bh_lang']`, removed when locales
became pre-rendered pages. They now key off `<html lang>`.

## Where translations came from

The six blog articles were written in English and the refund policy and
hypertension article in Russian, all translated to Ukrainian earlier the same
day. Rather than translating back, those catalog entries are recovered from the
commit before each translation, paired by tag and position and checked for
alignment. Deliberate corrections made during translation — the stale
"Healthcare"/"Ambulance" package names in refund clause 4.1, the 2024→2026 year
in the article — are excluded so they do not come back.

## Verified

All 54 built pages, at 1280px and 400px: no locale leakage, no unbalanced markup,
canonical present and matching each page's own hreflang entry, no interactive
element below 2:1 contrast, no horizontal overflow. Clicking UK→EN→RU→UK on a
service page lands on the same page each time.

## Open

- `/` is Ukrainian and `x-default` points there. If English is the priority
  audience, whether the root should be English is a product decision, not a
  technical one.
- 26 `.blade.php` files remain in `resources/views/` from the Laravel original.
  `build.sh` excludes them, but they are dead weight and confuse a reader looking
  for the source of a page.
