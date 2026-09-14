#!/usr/bin/env bash
set -e
rm -rf dist && mkdir dist
# Copy HTML views (exclude blade.php files)
rsync -a --exclude="*.php" --exclude="legal/" --exclude="partials/" resources/views/ dist/
# Copy public assets
rsync -a --exclude="index.php" public/ dist/
echo "Build complete: $(find dist -name "*.html" | wc -l) HTML files"
