# Must-Use Plugins (mu-plugins)

This directory contains must-use plugins that are automatically loaded by WordPress without requiring activation.

## B30SC OAuth Login Plugin

### Overview

The `b30sc-oauth-login.php` plugin provides custom OAuth login functionality for the B30SC Matrix theme, including:

- Custom login page with Matrix theme styling
- Google OAuth integration
- GitHub OAuth integration
- Automatic redirect from default wp-login.php
- Secure credential management via wp-config.php constants
- Custom login form shortcode
- Enhanced user experience with Matrix cybersecurity aesthetic

### Features

#### 1. Custom Login Page

The plugin automatically creates a custom login page at `/login/` with:
- Matrix theme black/green cybersecurity styling
- Neon glow effects and animations
- OAuth provider buttons (Google, GitHub)
- Traditional WordPress login form fallback
- Responsive design for mobile devices

#### 2. OAuth Provider Support

Currently supported OAuth providers:
- **Google**: Via Google OAuth 2.0
- **GitHub**: Via GitHub OAuth Apps

Additional providers can be added by extending the plugin or configuring Nextend Social Login.

#### 3. Security Features

- Credentials stored securely via wp-config.php constants (never in database)
- Support for environment variables
- SSL/HTTPS required for OAuth
- Automatic redirect for logged-in users
- Role-based redirect after login

#### 4. Matrix Theme Integration

All login elements styled to match the Matrix theme:
- Black (#000000) background
- Neon green (#00FF00) primary color
- Matrix green (#00CC00) secondary color
- Courier/OCR A monospace fonts
- Animated scanline effects
- Glow effects on interactive elements

### Configuration

#### Step 1: Install Nextend Social Login Plugin

This mu-plugin works in conjunction with the Nextend Social Login plugin:

```bash
# Via WP-CLI
wp plugin install nextend-social-login --activate

# Or download from WordPress.org
```

#### Step 2: Set OAuth Credentials

Add OAuth credentials to your `wp-config.php` file:

```php
// Google OAuth Configuration
define('B30SC_GOOGLE_CLIENT_ID', 'your-client-id.apps.googleusercontent.com');
define('B30SC_GOOGLE_CLIENT_SECRET', 'your-client-secret');

// GitHub OAuth Configuration
define('B30SC_GITHUB_CLIENT_ID', 'your-github-client-id');
define('B30SC_GITHUB_CLIENT_SECRET', 'your-github-client-secret');
```

#### Step 3: Configure OAuth Providers

Follow the detailed setup instructions in `/OAUTH_SETUP.md` to:
1. Create OAuth applications with Google and GitHub
2. Configure callback URLs
3. Enable providers in Nextend Social Login settings

### How It Works

#### Plugin Architecture

```
b30sc-oauth-login.php
│
├── B30SC_OAuth_Login (Main Class)
│   ├── init() - Initialize plugin hooks
│   ├── configure_oauth_providers() - Set up OAuth credentials
│   ├── custom_login_styles() - Inject Matrix theme CSS
│   ├── custom_login_head() - Add custom JavaScript
│   ├── redirect_to_custom_login() - Redirect wp-login.php
│   ├── redirect_after_login() - Handle post-login redirects
│   ├── create_login_page() - Auto-create login page
│   └── custom_login_page_template() - Load custom template
│
└── b30sc_oauth_login_shortcode() - Render login form
```

#### Hooks Used

- `init` - Initialize plugin and check dependencies
- `login_enqueue_scripts` - Enqueue Matrix theme styles
- `login_redirect` - Handle redirects after login
- `login_head` - Add custom JavaScript to login page
- `login_init` - Redirect wp-login.php to custom page
- `page_template` - Load custom login template
- `admin_init` - Create login page if it doesn't exist

#### Shortcode

```
[b30sc_oauth_login]
```

This shortcode renders the complete login interface including:
- OAuth provider buttons
- Divider with "or" text
- Traditional WordPress login form
- Lost password link
- Logged-in user message (if already authenticated)

### File Structure

```
wp-content/mu-plugins/
├── b30sc-oauth-login.php              # Main plugin file
├── nextend-social-login-config.json   # Configuration scaffolding
└── README.md                          # This file

wp-content/themes/b30sc-matrix/
└── template-login.php                 # Custom login page template
```

### Usage

#### For End Users

1. Navigate to `/login/` or try to access wp-admin while logged out
2. Choose login method:
   - Click "Continue with Google" for Google OAuth
   - Click "Continue with GitHub" for GitHub OAuth
   - Or use traditional username/password form
3. After successful authentication, redirected to appropriate page

#### For Developers

##### Customize Login Redirect

```php
// Filter the redirect URL after login
add_filter('login_redirect', 'custom_login_redirect', 20, 3);
function custom_login_redirect($redirect_to, $request, $user) {
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('administrator', $user->roles)) {
            return admin_url();
        } elseif (in_array('subscriber', $user->roles)) {
            return home_url('/dashboard/');
        }
    }
    return $redirect_to;
}
```

##### Add Custom OAuth Provider

The plugin is designed to work with Nextend Social Login. To add additional providers:

1. Configure the provider in Nextend Social Login settings
2. Add credential constants to wp-config.php if needed
3. The Matrix theme styling will automatically apply

##### Customize Login Page Content

Edit the shortcode content by filtering:

```php
add_filter('b30sc_oauth_login_content', 'customize_login_content');
function customize_login_content($content) {
    // Modify $content as needed
    return $content;
}
```

### Customization

#### CSS Customization

Matrix theme styles are injected via the `custom_login_styles()` method. To override:

```php
// In your child theme or custom plugin
add_action('login_enqueue_scripts', 'custom_override_login_styles', 20);
function custom_override_login_styles() {
    ?>
    <style>
        /* Your custom styles here */
        body.login {
            background-color: #custom-color;
        }
    </style>
    <?php
}
```

#### JavaScript Customization

Add custom JavaScript to the login page:

```php
add_action('login_head', 'custom_login_js', 20);
function custom_login_js() {
    ?>
    <script>
        // Your custom JavaScript
    </script>
    <?php
}
```

### Troubleshooting

#### Login Page Not Redirecting

If wp-login.php is not redirecting to the custom page:

1. Check that the custom login page was created
2. Verify the page ID is stored in `b30sc_custom_login_page_id` option
3. Clear WordPress object cache
4. Check for conflicting plugins

#### OAuth Buttons Not Showing

If OAuth provider buttons are not visible:

1. Verify Nextend Social Login is installed and activated
2. Check that providers are enabled in plugin settings
3. Confirm credentials are set in wp-config.php
4. Clear browser cache

#### Styling Issues

If Matrix theme styling is not applied:

1. Hard refresh the page (Ctrl+F5 or Cmd+Shift+R)
2. Check browser console for CSS errors
3. Verify theme is activated
4. Check for conflicting styles from other plugins

### Security Considerations

1. **Never commit credentials**: OAuth secrets should never be in version control
2. **Use HTTPS**: OAuth requires SSL for production
3. **Rotate secrets**: If credentials are exposed, regenerate immediately
4. **Limit scope**: Only request necessary OAuth scopes
5. **Review users**: Regularly audit OAuth-created users

### Testing

#### Local Development

For local testing:

1. Use ngrok or similar for HTTPS: `ngrok http 80`
2. Update callback URLs with ngrok URL
3. Test both OAuth and traditional login
4. Verify redirects work correctly

#### Production Testing Checklist

- [ ] SSL certificate active
- [ ] Callback URLs registered with OAuth providers
- [ ] Credentials set in wp-config.php
- [ ] Login page accessible
- [ ] Google OAuth works
- [ ] GitHub OAuth works
- [ ] Traditional login works
- [ ] Redirects correct
- [ ] Mobile responsive
- [ ] No console errors

### Configuration File

The `nextend-social-login-config.json` file provides:

- Configuration scaffolding for Nextend Social Login
- Recommended settings for Matrix theme integration
- Callback URL examples
- Security settings
- Setup instructions

This is a reference file - actual configuration is done through:
1. wp-config.php constants (for credentials)
2. WordPress admin interface (for plugin settings)

### Compatibility

- **WordPress**: 6.0+
- **PHP**: 7.4+
- **Nextend Social Login**: 3.0+
- **Theme**: B30SC Matrix 1.0+

### Support

For issues or questions:

1. Check `/OAUTH_SETUP.md` for detailed setup instructions
2. Review Nextend Social Login documentation
3. Check WordPress debug logs
4. Contact B30SC development team

### Changelog

#### Version 1.0.0 (2024-12-12)
- Initial release
- Google OAuth support
- GitHub OAuth support
- Custom Matrix-themed login page
- wp-login.php redirect functionality
- Comprehensive documentation

### License

This plugin is part of the B30SC Matrix theme and follows the same GPL v2 or later license.

---

**Note**: This is a must-use plugin and cannot be deactivated through the WordPress admin interface. To disable it, rename or remove the file from the mu-plugins directory.
