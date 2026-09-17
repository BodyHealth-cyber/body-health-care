#!/usr/bin/env python3
"""Штамп версии на style.css и main.js во всех собранных страницах.

Штамп был вписан в исходники руками и с тех пор не менялся: браузер видел ту
же ссылку /js/main.js?v=20260916102112 и продолжал брать скрипт из своего кэша.
На сервере лежала новая версия, у человека работала старая — именно так
исправление формы заявки не доехало до посетителей. Теперь штамп ставится
здесь, на каждой сборке, и берётся от времени последнего изменения самого
файла: не менялся файл — не меняется ссылка, и кэш работает как должен.
"""
import hashlib
import os
import re
import sys

DIST = 'dist'
ASSETS = ['css/style.css', 'js/main.js', 'js/quiz.js']


def fingerprint(path):
    with open(path, 'rb') as fh:
        return hashlib.sha256(fh.read()).hexdigest()[:12]


def main():
    stamps = {}
    for rel in ASSETS:
        full = os.path.join(DIST, rel)
        if not os.path.exists(full):
            print('stamp: нет файла %s' % full, file=sys.stderr)
            return 1
        stamps[rel] = fingerprint(full)

    changed = 0
    for root, _dirs, files in os.walk(DIST):
        for name in files:
            if not name.endswith('.html'):
                continue
            path = os.path.join(root, name)
            with open(path, encoding='utf-8') as fh:
                text = fh.read()
            before = text
            for rel, stamp in stamps.items():
                text = re.sub(
                    r'(/' + re.escape(rel) + r')(\?v=[^"\']*)?',
                    r'\1?v=' + stamp,
                    text,
                )
            if text != before:
                with open(path, 'w', encoding='utf-8') as fh:
                    fh.write(text)
                changed += 1

    print('assets: %s, страниц обновлено: %d'
          % (', '.join('%s -> ?v=%s' % (rel, stamps[rel]) for rel in ASSETS), changed))
    return 0


if __name__ == '__main__':
    sys.exit(main())
