#!/usr/bin/env bash
set -e
rm -rf dist && mkdir dist
# Copy HTML views (exclude blade.php files)
rsync -a --exclude="*.php" --exclude="legal/" --exclude="partials/" resources/views/ dist/
# Copy public assets
rsync -a --exclude="index.php" public/ dist/
# Fail the build on broken JS rather than shipping a dead language switcher
for f in dist/js/*.js; do
  node --check "$f" || { echo "SYNTAX ERROR in $f"; exit 1; }
done
node check-translations.js

# Generate sitemap from the pages that were actually built
python3 generate-sitemap.py
echo "Build complete: $(find dist -name "*.html" | wc -l) HTML files"
