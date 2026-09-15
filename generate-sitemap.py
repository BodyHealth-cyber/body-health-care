#!/usr/bin/env python3
"""Generate dist/sitemap.xml from the built pages. Run after build.sh."""
import os, re, datetime

SITE = 'https://body-health.care'
PRIORITY = {'': '1.0', 'for-companies.html': '0.9', 'blog.html': '0.8'}
SKIP = {'404.html', 'login.html'}

def main():
    urls = []
    for root, _, fns in sorted(os.walk('dist')):
        for fn in sorted(fns):
            if not fn.endswith('.html'):
                continue
            rel = os.path.relpath(os.path.join(root, fn), 'dist').replace(os.sep, '/')
            # SKIP names a page, not a path — /en/login.html is the same page as
            # /login.html and must be left out of the sitemap just the same
            if rel.split('/')[-1] in SKIP:
                continue
            s = open(os.path.join(root, fn), encoding='utf-8').read()
            if re.search(r'<meta name="robots"[^>]*noindex', s):
                continue
            loc = SITE + '/' + ('' if rel == 'index.html' else rel)
            parts = rel.split('/')
            base = '/'.join(parts[1:]) if parts[0] in ('en', 'ru') else rel
            if base.startswith('services/'):
                prio = '0.9'
            elif base.startswith('blog/'):
                prio = '0.7'
            else:
                prio = PRIORITY.get('' if base == 'index.html' else base, '0.5')
            urls.append((loc, prio))

    today = datetime.date.today().isoformat()
    out = ['<?xml version="1.0" encoding="UTF-8"?>',
           '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">']
    for loc, prio in urls:
        out += ['  <url>', f'    <loc>{loc}</loc>', f'    <lastmod>{today}</lastmod>',
                f'    <priority>{prio}</priority>', '  </url>']
    out.append('</urlset>')
    open('dist/sitemap.xml', 'w', encoding='utf-8').write('\n'.join(out) + '\n')
    print(f"sitemap.xml: {len(urls)} urls")

if __name__ == '__main__':
    main()
