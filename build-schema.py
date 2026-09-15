#!/usr/bin/env python3
"""
Add schema.org structured data to the built pages.

Search engines otherwise have to infer from prose that this is a medical service
with a phone number, three priced plans and bylined clinical articles. The markup
states it: MedicalBusiness on the home page, Service on each plan, Article with
author and dates on each post, FAQPage where a page has a real Q&A block, and
BreadcrumbList where the page shows a breadcrumb.

Injected at build time rather than written into the sources, so the same facts
are not maintained twice — prices, titles and dates are read back out of the
markup that was actually built.
"""
import json, os, re, sys

SITE = 'https://body-health.care'
PHONE = '+380981501498'
EMAIL = 'bodyhealthmediclinic@gmail.com'
SAME_AS = ['https://www.linkedin.com/company/bodyhealthcare',
           'https://www.instagram.com/bodyhealth.care',
           'https://www.facebook.com/bodyhealthcare']

PLAN_PRICE = {'healthcare': '250', 'ambulance': '500', 'checkup': '100'}


def text(node):
    return re.sub(r'\s+', ' ', re.sub(r'<[^>]+>', ' ', node)).strip()


def organization(lang):
    return {
        '@type': 'MedicalBusiness',
        '@id': f'{SITE}/#organization',
        'name': 'BodyHealth',
        'url': SITE + ('' if lang == 'uk' else f'/{lang}/'),
        'logo': f'{SITE}/img/logo_no_bg.png',
        'image': f'{SITE}/img/og-card-{lang}.png',
        'telephone': PHONE,
        'email': EMAIL,
        'sameAs': SAME_AS,
        'medicalSpecialty': ['PrimaryCare', 'Cardiovascular', 'Endocrine',
                             'Neurologic', 'PreventiveMedicine'],
        'availableService': {'@type': 'MedicalTherapy', 'name': 'Telemedicine'},
    }


def for_page(rel, html, lang):
    """Return the JSON-LD graph for one built page, or None."""
    nodes = []
    base = '/'.join(rel.split('/')[1:]) if rel.split('/')[0] in ('en', 'ru') else rel
    url = f'{SITE}/' + ('' if rel == 'index.html' else rel)

    def find(pat, flags=re.DOTALL):
        m = re.search(pat, html, flags)
        return text(m.group(1)) if m else None

    title = find(r'<title>(.*?)</title>') or ''
    desc = (re.search(r'<meta name="description" content="([^"]*)"', html) or [None, ''])[1] \
        if re.search(r'<meta name="description" content="([^"]*)"', html) else ''

    if base == 'index.html':
        org = organization(lang)
        org['description'] = desc
        nodes.append(org)
        nodes.append({
            '@type': 'WebSite', '@id': f'{url}#website', 'url': url,
            'name': 'BodyHealth', 'inLanguage': lang,
            'publisher': {'@id': f'{SITE}/#organization'},
        })

    elif base.startswith('services/'):
        plan = base.split('/')[-1].replace('.html', '')
        h1 = find(r'<h1>(.*?)</h1>') or title
        node = {
            '@type': 'Service', '@id': f'{url}#service', 'name': h1,
            'description': desc, 'url': url, 'serviceType': 'Telemedicine',
            'provider': {'@id': f'{SITE}/#organization'},
            'areaServed': {'@type': 'Country', 'name': 'Ukraine'},
        }
        if plan in PLAN_PRICE:
            node['offers'] = {
                '@type': 'Offer', 'price': PLAN_PRICE[plan], 'priceCurrency': 'USD',
                'url': url, 'availability': 'https://schema.org/InStock',
            }
        nodes.append(node)

    elif base.startswith('blog/'):
        h1 = find(r'<h1>(.*?)</h1>') or title
        author = find(r'class="author-name">(.*?)<') or find(r'article:author" content="([^"]*)"')
        published = (re.search(r'article:published_time" content="([^"]*)"', html) or [None, None])[1] \
            if re.search(r'article:published_time" content="([^"]*)"', html) else None
        node = {
            '@type': 'Article', '@id': f'{url}#article', 'headline': h1,
            'description': desc, 'url': url, 'inLanguage': lang,
            'image': f'{SITE}/img/og-card-{lang}.png',
            'publisher': {'@id': f'{SITE}/#organization'},
            'mainEntityOfPage': {'@type': 'WebPage', '@id': url},
        }
        if author:
            node['author'] = {'@type': 'Person', 'name': author}
        if published:
            node['datePublished'] = published
        nodes.append(node)

    # FAQ, where the page actually has one
    qa = re.findall(r'<div[^>]*class="[^"]*faq-question[^"]*"[^>]*>\s*<h3>(.*?)</h3>.*?'
                    r'<div[^>]*class="[^"]*faq-answer[^"]*"[^>]*>(.*?)</div>', html, re.DOTALL)
    if len(qa) >= 2:
        nodes.append({
            '@type': 'FAQPage',
            'mainEntity': [{'@type': 'Question', 'name': text(q),
                            'acceptedAnswer': {'@type': 'Answer', 'text': text(a)}}
                           for q, a in qa],
        })

    # breadcrumb, where the page shows one
    crumbs = re.findall(r'<a href="([^"]*)">([^<]*)</a>',
                        (re.search(r'<div class="breadcrumb">(.*?)</div>', html, re.DOTALL) or
                         type('', (), {'group': lambda *_: ''})()).group(1) or '')
    if crumbs:
        items = [{'@type': 'ListItem', 'position': i + 1, 'name': text(n),
                  'item': h if h.startswith('http') else SITE + h}
                 for i, (h, n) in enumerate(crumbs)]
        h1 = find(r'<h1>(.*?)</h1>')
        if h1:
            items.append({'@type': 'ListItem', 'position': len(items) + 1, 'name': h1, 'item': url})
        nodes.append({'@type': 'BreadcrumbList', 'itemListElement': items})

    if not nodes:
        return None
    return {'@context': 'https://schema.org', '@graph': nodes}


def main():
    n = 0
    for root, _, fns in os.walk('dist'):
        for fn in sorted(fns):
            if not fn.endswith('.html'):
                continue
            p = os.path.join(root, fn)
            rel = os.path.relpath(p, 'dist').replace(os.sep, '/')
            if rel.startswith('404'):
                continue
            html = open(p, encoding='utf-8').read()
            if 'application/ld+json' in html:
                continue
            m = re.search(r'<html[^>]*lang="([^"]*)"', html)
            lang = m.group(1) if m else 'uk'
            graph = for_page(rel, html, lang)
            if not graph:
                continue
            tag = ('    <script type="application/ld+json">\n'
                   + json.dumps(graph, ensure_ascii=False, indent=2)
                   + '\n    </script>\n')
            html = html.replace('</head>', tag + '</head>', 1)
            open(p, 'w', encoding='utf-8').write(html)
            n += 1
    print(f"schema: {n} pages marked up")
    return 0


if __name__ == '__main__':
    sys.exit(main())
