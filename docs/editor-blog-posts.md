# Editor guide: creating member-only blog posts

This site’s blog content is intended for logged-in members.

## Required settings (per post)

When creating/editing a post in WordPress:

1. **Status:** Published
2. **Visibility:** Public
3. **Category:** Members Only
   - Optional additional category: Cybersecurity
4. **Tag:** `member-only`
5. **Featured image:** required (Matrix-style preferred)

## Verification checklist

- Logged out: the blog index and posts should not be accessible.
- Logged in: the post should appear in the blog listing and open normally.

## Featured image guidelines

- Use a 1200×630 image for consistent previews/sharing.
- Keep text short and high-contrast.
- Avoid including secrets, internal hostnames, or customer identifiers.

## Adding posts via WP-CLI (optional)

If developers are seeding content via CLI, use the existing script as the reference implementation:

- `seed/wordpress/seed-posts.sh`

It demonstrates the categories/tags to apply and how featured images are attached.
