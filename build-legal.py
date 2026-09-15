#!/usr/bin/env python3
"""
Build the public offer into static pages, one per language.

The offer is the contract a customer accepts by paying. It exists in the repo as
resources/views/legal/content/terms-{uk,en,ru}.blade.php — pure HTML bodies left
behind by the Laravel original — but build.sh excludes legal/ and every .php, so
all three links on /terms-and-conditions.html answered 404 on the live site.

These documents are versioned by LANGUAGE, not by site locale: a visitor reading
the Ukrainian site may need the English offer. They therefore live at one shared
path, /terms-and-conditions/<lang>.html, are not passed through the locale
generator, and their links are not rewritten per locale.
"""
import os, re, sys

LANGS = ['uk', 'en', 'ru']
LANG_LABEL = {'uk': 'Українська', 'en': 'English', 'ru': 'Русский'}
SITE = 'https://body-health.care'


def php_section(path, doc):
    """Pull one document's metadata out of lang/<l>/legal.php."""
    src = open(path, encoding='utf-8').read()
    m = re.search(r"'" + doc + r"'\s*=>\s*\[(.*?)\n\s*\],", src, re.DOTALL)
    if not m:
        return {}
    out = {}
    for k, v in re.findall(r"'(\w+)'\s*=>\s*'((?:[^'\\]|\\.)*)'", m.group(1)):
        out[k] = v.replace("\\'", "'").replace('\\\\', '\\')
    return out


def shell(lang):
    """Header, footer and float-contacts already rendered in this language.

    Taken from the built home page of the matching locale, so the English offer
    carries an English nav rather than the Ukrainian source's.
    """
    path = 'dist/index.html' if lang == 'uk' else f'dist/{lang}/index.html'
    if not os.path.exists(path):
        path = 'dist/index.html'
    s = open(path, encoding='utf-8').read()
    return (
        re.search(r'<header class="header">.*?</header>', s, re.DOTALL).group(0),
        re.search(r'<footer class="footer">.*?</footer>', s, re.DOTALL).group(0),
        re.search(r'<div class="float-contacts">.*?\n    </div>', s, re.DOTALL).group(0),
    )


def absolutize(block):
    for rel in ['services/healthcare.html', 'services/ambulance.html', 'services/checkup.html',
                'for-companies.html', 'blog.html', 'privacy.html', 'login.html',
                'refund-policy.html', 'terms-and-conditions.html', 'index.html']:
        block = block.replace(f'href="{rel}"', f'href="/{rel}"')
    return block.replace('href="#contact-form"', 'href="/#contact-form"')


def build(doc):
    made = []
    for lang in LANGS:
        header, footer, float_block = shell(lang)
        header, footer = absolutize(header), absolutize(footer)
        # the offer belongs to no site locale, so the header's locale switcher goes
        header = re.sub(r'\s*<div class="language-switcher">.*?</ul>\s*</div>', '', header,
                        count=1, flags=re.DOTALL)
        body_path = f'resources/views/legal/content/{doc}-{lang}.blade.php'
        if not os.path.exists(body_path):
            print(f"  {doc}-{lang}: no source, skipped")
            continue
        body = open(body_path, encoding='utf-8').read().strip()
        meta = php_section(f'lang/{lang}/legal.php', doc)
        common = {}
        src = open(f'lang/{lang}/legal.php', encoding='utf-8').read()
        cm = re.search(r"'common'\s*=>\s*\[(.*?)\n\s*\],", src, re.DOTALL)
        if cm:
            for k, v in re.findall(r"'(\w+)'\s*=>\s*'((?:[^'\\]|\\.)*)'", cm.group(1)):
                common[k] = v.replace("\\'", "'")

        url = f'{SITE}/terms-and-conditions/{lang}.html'
        switcher = '\n'.join(
            f'                            <a href="/terms-and-conditions/{l}.html" '
            f'class="btn {"btn-primary" if l == lang else "btn-outline"}">{LANG_LABEL[l]}</a>'
            for l in LANGS if os.path.exists(f'resources/views/legal/content/{doc}-{l}.blade.php'))

        page = f'''<!DOCTYPE html>
<html lang="{lang}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="{url}">
    <title>{meta.get('meta_title', '')}</title>
    <meta name="description" content="{meta.get('meta_description', '')}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{url}">
    <meta property="og:title" content="{meta.get('meta_title', '')}">
    <meta property="og:description" content="{meta.get('meta_description', '')}">
    <meta property="og:site_name" content="BodyHealth">
    <link rel="stylesheet" href="/css/style.css?v=20260915">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
</head>
<body>
{header}

    <main class="legal-page">
        <section class="legal-page-section">
            <div class="container">
                <div class="legal-card">
                    <div class="legal-card-header">
                        <div>
                            <p class="legal-eyebrow">{common.get('category', '')}</p>
                            <h1>{meta.get('title', '')}</h1>
                            <p class="legal-summary">{meta.get('summary', '')}</p>
                        </div>

                        <div class="legal-meta-panel">
                            <div class="legal-meta-block">
                                <span class="legal-meta-label">{common.get('revision_date', '')}</span>
                                <span class="legal-meta-value">{meta.get('revision_date', '')}</span>
                            </div>
                            <div class="legal-meta-block">
                                <span class="legal-meta-label">{common.get('document_language', '')}</span>
                                <span class="legal-meta-value">{LANG_LABEL[lang]}</span>
                            </div>
                        </div>
                    </div>

                    <div class="legal-language-switcher" aria-label="{php_section(f'lang/{lang}/legal.php', 'terms_index').get('version_links_label', '')}">
{switcher}
                    </div>

{body}
                </div>
            </div>
        </section>
    </main>

{footer}

{float_block}
    <script src="/js/main.js?v=20260915"></script>
</body>
</html>
'''
        out = f'dist/terms-and-conditions/{lang}.html'
        os.makedirs(os.path.dirname(out), exist_ok=True)
        open(out, 'w', encoding='utf-8').write(page)
        made.append(out)
    return made


def main():
    made = build('terms')
    print(f"legal: {len(made)} document pages -> {', '.join(os.path.basename(m) for m in made)}")
    return 0


if __name__ == '__main__':
    sys.exit(main())
