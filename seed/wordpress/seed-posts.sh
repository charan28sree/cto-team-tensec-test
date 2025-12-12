#!/usr/bin/env bash
set -euo pipefail

WP_PATH="${WP_PATH:-.}"
SCRIPT_DIR="$(cd -- "$(dirname -- "${BASH_SOURCE[0]}")" >/dev/null 2>&1 && pwd)"

wp_cmd() {
  wp --path="$WP_PATH" "$@"
}

if ! command -v wp >/dev/null 2>&1; then
  echo "wp (WP-CLI) is required. Install it first: https://wp-cli.org/" >&2
  exit 1
fi

if ! wp_cmd core is-installed >/dev/null 2>&1; then
  echo "No WordPress install detected at WP_PATH='$WP_PATH'. Run this from your WordPress root or set WP_PATH." >&2
  exit 1
fi

ensure_term_id() {
  local taxonomy="$1"
  local name="$2"
  local slug="$3"
  local existing

  existing="$(wp_cmd term list "$taxonomy" --slug="$slug" --field=term_id --format=ids || true)"
  if [[ -n "$existing" ]]; then
    echo "$existing"
    return 0
  fi

  wp_cmd term create "$taxonomy" "$name" --slug="$slug" --porcelain
}

ensure_seed_attachment() {
  local seed_key="$1"
  local file_path="$2"
  local title="$3"
  local alt_text="$4"

  local existing
  existing="$(wp_cmd post list --post_type=attachment --meta_key=cto_seed_asset --meta_value="$seed_key" --field=ID --format=ids || true)"
  if [[ -n "$existing" ]]; then
    echo "$existing"
    return 0
  fi

  local attachment_id
  attachment_id="$(wp_cmd media import "$file_path" --title="$title" --alt="$alt_text" --porcelain)"
  wp_cmd post meta update "$attachment_id" cto_seed_asset "$seed_key" >/dev/null

  echo "$attachment_id"
}

upsert_post() {
  local slug="$1"
  local title="$2"
  local content_file="$3"
  local featured_attachment_id="$4"
  shift 4
  local tags=("$@")

  local existing_post_id
  existing_post_id="$(wp_cmd post list --post_type=post --name="$slug" --field=ID --format=ids || true)"

  local content
  content="$(cat "$content_file")"

  local post_id
  if [[ -n "$existing_post_id" ]]; then
    post_id="$existing_post_id"
    wp_cmd post update "$post_id" --post_title="$title" --post_status=publish --post_content="$content" >/dev/null
  else
    post_id="$(wp_cmd post create --post_type=post --post_title="$title" --post_name="$slug" --post_status=publish --post_content="$content" --porcelain)"
  fi

  wp_cmd post meta update "$post_id" _thumbnail_id "$featured_attachment_id" >/dev/null
  wp_cmd post meta update "$post_id" cto_seed_post "$slug" >/dev/null

  echo "$post_id"

  if ((${#tags[@]} > 0)); then
    wp_cmd post term set "$post_id" post_tag "${tags[@]}" >/dev/null
  fi
}

CYBERSEC_CAT_ID="$(ensure_term_id category "Cybersecurity" "cybersecurity")"
MEMBERS_ONLY_CAT_ID="$(ensure_term_id category "Members Only" "members-only")"

WELCOME_IMAGE_ID="$(ensure_seed_attachment \
  "featured-welcome-matrix" \
  "$SCRIPT_DIR/media/featured-welcome-matrix.svg" \
  "Welcome to the Matrix" \
  "Matrix-style green code rain with welcome headline" \
)"

TIPS_IMAGE_ID="$(ensure_seed_attachment \
  "featured-security-tips" \
  "$SCRIPT_DIR/media/featured-security-tips.svg" \
  "5 Security Quick Wins" \
  "Matrix-style security checklist with shield icon" \
)"

WELCOME_POST_ID="$(upsert_post \
  "welcome-to-the-matrix" \
  "Welcome to the Matrix: Member-Only Cybersecurity Notes" \
  "$SCRIPT_DIR/posts/welcome.html" \
  "$WELCOME_IMAGE_ID" \
  "member-only" "cybersecurity" "welcome" "matrix" \
)"

TIPS_POST_ID="$(upsert_post \
  "5-security-quick-wins" \
  "5 Quick Wins: Cybersecurity Hygiene You Can Do Today" \
  "$SCRIPT_DIR/posts/security-tips.html" \
  "$TIPS_IMAGE_ID" \
  "member-only" "cybersecurity" "security-tips" "mfa" "password-manager" "phishing" \
)"

wp_cmd post term set "$WELCOME_POST_ID" category "$CYBERSEC_CAT_ID" "$MEMBERS_ONLY_CAT_ID" >/dev/null
wp_cmd post term set "$TIPS_POST_ID" category "$CYBERSEC_CAT_ID" "$MEMBERS_ONLY_CAT_ID" >/dev/null

echo "Seeded posts:"
echo "- $WELCOME_POST_ID (welcome-to-the-matrix)"
echo "- $TIPS_POST_ID (5-security-quick-wins)"
