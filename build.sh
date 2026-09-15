#!/usr/bin/env bash
set -e
rm -rf dist && mkdir dist
# Copy HTML views (exclude blade.php files)
rsync -a --exclude="*.php" --exclude="legal/" --exclude="partials/" resources/views/ dist/
# Copy public assets
rsync -a --exclude="index.php" public/ dist/
# Generate sitemap from the pages that were actually built
python3 generate-sitemap.py
echo "Build complete: $(find dist -name "*.html" | wc -l) HTML files"
