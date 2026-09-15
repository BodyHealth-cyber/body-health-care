#!/usr/bin/env python3
"""
Generate the en/ and ru/ versions of the site from the Ukrainian pages in dist/.

English is the priority audience, so the other languages have to be real pages
with their own URLs that a crawler can read — not a client-side swap that leaves
the markup Ukrainian.

Catalogs in i18n/<lang>.json map the exact Ukrainian string to its translation.
A page is only published in a locale once it clears COVERAGE; below that it is
skipped entirely, and no hreflang or sitemap entry claims it exists. A page that
is 60% translated reads as broken in a way that no page at all does, so partial
work stays unpublished until it is finished.
"""
import json, os, re, sys

SITE = 'https://body-health.care'
LOCALES = ['en', 'ru']
DEFAULT = 'uk'
COVERAGE = 0.98
HREFLANG = {'en': 'en', 'ru': 'ru'}
OG_LOCALE = {'en': 'en_US', 'ru': 'ru_RU', 'uk': 'uk_UA'}
ATTRS = ('content', 'placeholder', 'alt', 'aria-label', 'title')
ASSET = re.compile(r'/(css|js|img|favicon|robots|sitemap)')


def translatable(t):
    return len(t.strip()) >= 2 and bool(re.search(r'[А-Яа-яІЇЄҐіїєґ]', t))


def render(html, cat, lang, rel):
    """Return (html, hits, misses) for one page in one locale."""
    hits, misses = [], []

    def text_node(m):
        lead, body, tail = m.group(1), m.group(2), m.group(3)
        key = body.strip()
        if not translatable(key):
            return m.group(0)
        if key in cat:
            hits.append(key)
            return lead + body.replace(key, cat[key]) + tail
        misses.append(key)
        return m.group(0)

    html = re.sub(r'(>)([^<>]+)(<)', text_node, html)

    def attr(m):
        name, val = m.group(1), m.group(2)
        if not translatable(val):
            return m.group(0)
        if val in cat:
            hits.append(val)
            return f'{name}="{cat[val]}"'
        misses.append(val)
        return m.group(0)

    html = re.sub(r'\b(' + '|'.join(ATTRS) + r')="([^"]*)"', attr, html)
    html = re.sub(r'(<html[^>]*\blang=")[^"]*(")', lambda m: m.group(1) + lang + m.group(2), html, count=1)

    def link(m):
        name, url = m.group(1), m.group(2)
        if url.startswith('/') and not url.startswith('//') and not ASSET.match(url):
            return f'{name}="/{lang}{url}"'
        return m.group(0)

    html = re.sub(r'\b(href)="([^"]*)"', link, html)

    page = '' if rel == 'index.html' else rel
    html = re.sub(r'<link rel="canonical" href="[^"]*">',
                  f'<link rel="canonical" href="{SITE}/{lang}/{page}">', html, count=1)
    html = re.sub(r'(<meta property="og:url" content=")[^"]*(")',
                  lambda m: m.group(1) + f'{SITE}/{lang}/{page}' + m.group(2), html, count=1)
    html = re.sub(r'(<meta property="og:locale" content=")[^"]*(")',
                  lambda m: m.group(1) + OG_LOCALE[lang] + m.group(2), html, count=1)
    return html, hits, misses


def hreflang(rel, langs):
    page = '' if rel == 'index.html' else rel
    out = [f'<link rel="alternate" hreflang="uk" href="{SITE}/{page}">']
    out += [f'<link rel="alternate" hreflang="{HREFLANG[l]}" href="{SITE}/{l}/{page}">' for l in langs]
    out.append(f'<link rel="alternate" hreflang="x-default" href="{SITE}/{page}">')
    return '\n    '.join(out)


def main():
    pages = []
    for root, _, fns in os.walk('dist'):
        if any(p in LOCALES for p in root.split(os.sep)):
            continue
        for fn in sorted(fns):
            if fn.endswith('.html'):
                pages.append(os.path.relpath(os.path.join(root, fn), 'dist').replace(os.sep, '/'))
    pages.sort()

    sources = {rel: open(os.path.join('dist', rel), encoding='utf-8').read() for rel in pages}

    built = {rel: [] for rel in pages}   # which locales each page cleared
    rendered = {}
    misses = {l: {} for l in LOCALES}

    for lang in LOCALES:
        cat = json.load(open(f'i18n/{lang}.json', encoding='utf-8'))
        done = 0
        for rel in pages:
            html, hits, miss = render(sources[rel], cat, lang, rel)
            total = len(hits) + len(miss)
            cov = 1.0 if total == 0 else len(hits) / total
            for m in miss:
                misses[lang].setdefault(rel, [])
                if m not in misses[lang][rel]:
                    misses[lang][rel].append(m)
            if cov >= COVERAGE:
                rendered[(lang, rel)] = html
                built[rel].append(lang)
                done += 1
        pending = sum(len(v) for v in misses[lang].values())
        print(f"  {lang}: {done}/{len(pages)} pages published, {pending} strings still untranslated")

    # write pages, with hreflang reflecting what actually exists
    for rel in pages:
        langs = built[rel]
        block = hreflang(rel, langs) if (langs and rel != '404.html') else None
        if block:
            s = sources[rel]
            s = re.sub(r'\s*<link rel="alternate" hreflang="[^"]*" href="[^"]*">', '', s)
            s = s.replace('<link rel="canonical"', block + '\n    <link rel="canonical"', 1)
            open(os.path.join('dist', rel), 'w', encoding='utf-8').write(s)
        for lang in langs:
            html = rendered[(lang, rel)]
            if block:
                html = re.sub(r'\s*<link rel="alternate" hreflang="[^"]*" href="[^"]*">', '', html)
                html = html.replace('<link rel="canonical"', block + '\n    <link rel="canonical"', 1)
            dst = os.path.join('dist', lang, rel)
            os.makedirs(os.path.dirname(dst), exist_ok=True)
            open(dst, 'w', encoding='utf-8').write(html)

    os.makedirs('i18n/_missing', exist_ok=True)
    for lang in LOCALES:
        flat = {}
        for rel in sorted(misses[lang]):
            for m in misses[lang][rel]:
                flat.setdefault(m, '')
        json.dump(flat, open(f'i18n/_missing/{lang}.json', 'w', encoding='utf-8'),
                  ensure_ascii=False, indent=2)
        json.dump(misses[lang], open(f'i18n/_missing/{lang}.by-page.json', 'w', encoding='utf-8'),
                  ensure_ascii=False, indent=1)
    return 0


if __name__ == '__main__':
    sys.exit(main())
