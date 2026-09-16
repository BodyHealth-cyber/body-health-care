#!/usr/bin/env bash
set -e
rm -rf dist && mkdir dist
# Copy HTML views (exclude blade.php files)
rsync -a --exclude="*.php" --exclude="legal/" --exclude="partials/" resources/views/ dist/
# Приём заявок. Cloudflare Pages читает функции из каталога functions/ внутри
# опубликованной папки, поэтому копируем их рядом со страницами.
if [ -d functions ]; then
  rsync -a functions/ dist/functions/
fi

# Copy public assets
# translations.js is no longer loaded in the browser — locales are pre-rendered.
# It stays in the repo as the origin of the i18n catalogs, but is not shipped.
rsync -a --exclude="index.php" --exclude="js/translations.js" public/ dist/
# Fail the build on broken JS rather than shipping a dead language switcher
for f in dist/js/*.js; do
  node --check "$f" || { echo "SYNTAX ERROR in $f"; exit 1; }
done
node check-translations.js

# Generate the en/ and ru/ pages before the sitemap, so it lists them
python3 build-locales.py

# The public offer is one page per language, shared across site locales. Built
# after the locales so each document can take the header and footer already
# translated into its own language.
python3 build-legal.py

# Structured data, read back out of the pages that were actually built
python3 build-schema.py

# Say plainly whether the forms can actually deliver a submission
python3 check-forms.py

# Generate sitemap from the pages that were actually built
python3 generate-sitemap.py

# Штамп версии на style.css и main.js. Без него браузер продолжает брать
# скрипт из кэша по той же ссылке, и правки не доезжают до посетителей.
python3 stamp-assets.py
echo "Build complete: $(find dist -name "*.html" | wc -l) HTML files"
