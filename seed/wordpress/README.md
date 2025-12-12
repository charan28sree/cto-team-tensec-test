# WordPress blog seeding (member-only)

This folder contains two starter cybersecurity posts plus Matrix-style featured images.

## What gets created

Running the seed script will:

- Create categories:
  - **Cybersecurity** (`cybersecurity`)
  - **Members Only** (`members-only`)
- Upload featured images (SVG) and mark them as seed assets
- Create (or update) two published posts:
  - `welcome-to-the-matrix`
  - `5-security-quick-wins`
- Assign categories + tags (including the `member-only` tag)
- Set each post’s featured image

## Run it (WP-CLI)

Prerequisites:

- A working WordPress install
- [WP-CLI](https://wp-cli.org/) available as `wp`
- Your install allows SVG uploads (if not, convert the SVGs to PNGs and update the script paths)

From your WordPress root directory:

```bash
# from WP root
bash path/to/your/repo/seed/wordpress/seed-posts.sh

# or, if your WordPress is not the current directory
WP_PATH=/var/www/html bash /path/to/repo/seed/wordpress/seed-posts.sh
```

## Editor workflow for future member-only posts

In the WordPress admin UI:

1. Go to **Posts → Add New**.
2. Write the post and set **Visibility: Public** and **Status: Published**.
3. In the right sidebar:
   - Set **Category** to **Members Only** (and optionally **Cybersecurity**).
   - Add the **tag** `member-only`.
   - Set a **Featured image**.
4. Preview while logged out to confirm the blog is not accessible.
5. Log in as a member and confirm the post appears in the blog listing.

If your site enforces access control based on taxonomy (common pattern), consistently applying **Members Only** + the `member-only` tag makes the restriction unambiguous and easy to query.
