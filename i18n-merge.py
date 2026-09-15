#!/usr/bin/env python3
"""Merge a JSON map from stdin into i18n/<lang>.json, keeping existing entries."""
import json, sys
lang = sys.argv[1]
add = json.load(sys.stdin)
path = f'i18n/{lang}.json'
cat = json.load(open(path, encoding='utf-8'))
new = overw = 0
for k, v in add.items():
    if k in cat:
        if cat[k] != v: overw += 1
    else:
        new += 1
    cat[k] = v
json.dump(dict(sorted(cat.items())), open(path, 'w', encoding='utf-8'), ensure_ascii=False, indent=2)
print(f"{lang}: +{new} new, {overw} updated, {len(cat)} total")
