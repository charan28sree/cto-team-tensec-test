# Blog Membership Protection

This project sets up access control for the blog section of the website.

## Approach

We use a combination of the [Members](https://wordpress.org/plugins/members/) plugin for role management and content restriction capabilities, and a custom code snippet (plugin) to handle the specific requirement of redirecting unauthenticated users to an OAuth login page when attempting to access the blog.

## Components

1.  **Dependencies**: Managed via Composer (`composer.json`), including the `members` plugin.
2.  **Custom Logic**: A custom plugin `wp-content/plugins/blog-auth-gate` that:
    *   Intercepts access to the blog archive and single posts.
    *   Redirects unauthenticated users to the OAuth login page.
    *   Adjusts menu items based on authentication state.

## Role Management

To manage roles for future members:

1.  Log in to the WordPress Dashboard.
2.  Navigate to **Members > Roles**.
3.  You can create new roles or edit existing ones.
4.  Assign the `read_private_posts` or custom capabilities if you wish to further restrict specific content, although the current implementation creates a blanket gate for the blog section for non-logged-in users.
5.  To assign a role to a user, go to **Users**, click on a user, and check the desired role under "Roles".

## Configuration

The OAuth Login URL is defined in the `blog-auth-gate` plugin. Update `BLOG_AUTH_OAUTH_LOGIN_URL` constant if the URL changes.
