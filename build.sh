#!/usr/bin/env bash

set -e

# === НАСТРОЙКИ ===
THEME_NAME="pt-claude"
THEME_DIR="$(pwd)"
THEMES_ROOT="$(dirname "$THEME_DIR")"
ARCHIVE_NAME="$THEME_NAME.zip"

# === АРХИВАЦИЯ ===
zip -r "$THEMES_ROOT/$ARCHIVE_NAME" . \
  -x "*.git*" \
  -x "node_modules/*" \
  -x "*.log" \
  -x "*.map" \
  -x ".env" \
  -x ".DS_Store" \
  -x "composer.lock" \
  -x "package-lock.json" \
  -x "yarn.lock" \
  -x "webpack.mix.js" \
  -x "vite.config.*" \
  -x "tests/*" \
  -x ".idea/*" \
  -x ".vscode/*"

echo "✅ Архив создан: $THEMES_ROOT/$ARCHIVE_NAME"
