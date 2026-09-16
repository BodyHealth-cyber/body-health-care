#!/usr/bin/env python3
"""
Warn when a form in the build output has no real endpoint.

Both forms post to a Make.com webhook carried in data-endpoint. Until that
holds a real URL the attribute keeps the literal MAKE_WEBHOOK_URL placeholder,
which the browser resolves as a relative path against the current page — so a
submission 404s and the enquiry is lost. The pages now fall back to offering
direct contact, but that is a safety net, not the intended path, and nothing in
the build said the endpoint was missing.

This does not fail the build: the site is deployable and the fallback works. It
prints a warning loud enough that nobody has to discover it from a missing lead.
"""
import os, re, sys

PLACEHOLDER = 'ENDPOINT'

def main():
    unconfigured, configured = set(), set()
    for root, _, fns in os.walk('dist'):
        for fn in sorted(fns):
            if not fn.endswith('.html'):
                continue
            p = os.path.join(root, fn)
            s = open(p, encoding='utf-8').read()
            for m in re.finditer(r'<form[^>]*\bid="([^"]+)"[^>]*\bdata-endpoint="([^"]*)"', s):
                form, url = m.group(1), m.group(2)
                (configured if re.match(r'(https?://|/)', url) else unconfigured).add(form)

    if configured:
        print(f"forms: {len(configured)} with a live endpoint ({', '.join(sorted(configured))})")
    if unconfigured:
        print()
        print("  ┌─ WARNING " + "─" * 58)
        print("  │ These forms have no webhook — submissions cannot be delivered:")
        for f in sorted(unconfigured):
            print(f"  │   #{f}   data-endpoint=\"{PLACEHOLDER}\"")
        print("  │")
        print("  │ Visitors are offered WhatsApp, Telegram and the phone number")
        print("  │ instead, with what they typed carried over, so nothing is lost.")
        print("  │ To deliver them properly, put /api/enquiry in the")
        print("  │ form's data-endpoint attribute.")
        print("  └" + "─" * 68)
        print()
    return 0

if __name__ == '__main__':
    sys.exit(main())
