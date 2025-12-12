# B30SC Matrix WordPress Theme with OAuth Login

A custom WordPress block theme with a black/green cybersecurity aesthetic inspired by The Matrix, featuring integrated OAuth login with Google and GitHub.

## Features

### Theme Features
- **Matrix Aesthetic**: Black background (#000000) with neon green (#00FF00) accents
- **Cybersecurity Design**: Monospace fonts (Courier New, OCR A), scanline effects, terminal-style elements
- **Block Theme**: Full Site Editing (FSE) support with custom block patterns
- **Responsive**: Mobile-first design that works on all devices
- **Accessibility**: WCAG compliant with semantic HTML

### OAuth Login Features
- **Google OAuth**: Login with Google accounts
- **GitHub OAuth**: Login with GitHub accounts
- **Custom Login Page**: Matrix-themed login interface at `/login/`
- **Automatic Redirect**: wp-login.php redirects to custom login page
- **Secure Configuration**: Credentials stored via wp-config.php constants or environment variables
- **Fallback Support**: Traditional WordPress login still available

## Quick Start

### Installation

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd <project-directory>
   ```

2. **Set up WordPress**:
   - Install WordPress core in the root directory
   - Or use this as a wp-content replacement

3. **Activate the theme**:
   ```bash
   wp theme activate b30sc-matrix
   ```

4. **Install required plugin**:
   ```bash
   wp plugin install nextend-social-login --activate
   ```

### OAuth Configuration

1. **Configure OAuth providers** (detailed instructions in [OAUTH_SETUP.md](OAUTH_SETUP.md)):
   - Set up Google OAuth in [Google Cloud Console](https://console.cloud.google.com/)
   - Set up GitHub OAuth in [GitHub Developer Settings](https://github.com/settings/developers)

2. **Add credentials to wp-config.php**:
   ```php
   // Google OAuth
   define('B30SC_GOOGLE_CLIENT_ID', 'your-client-id.apps.googleusercontent.com');
   define('B30SC_GOOGLE_CLIENT_SECRET', 'your-client-secret');
   
   // GitHub OAuth
   define('B30SC_GITHUB_CLIENT_ID', 'your-github-client-id');
   define('B30SC_GITHUB_CLIENT_SECRET', 'your-github-client-secret');
   ```

3. **Configure callback URLs** in your OAuth applications:
   - Google: `https://yourdomain.com/wp-login.php?loginSocial=google`
   - GitHub: `https://yourdomain.com/wp-login.php?loginSocial=github`

4. **Test the login**:
   - Navigate to `https://yourdomain.com/login/`
   - Try logging in with Google or GitHub

## Documentation

- **[OAUTH_SETUP.md](OAUTH_SETUP.md)**: Complete OAuth setup guide with step-by-step instructions
- **[wp-content/mu-plugins/README.md](wp-content/mu-plugins/README.md)**: Technical documentation for the OAuth plugin
- **[wp-config-oauth-example.php](wp-config-oauth-example.php)**: Example wp-config.php configuration
- **[.env.example](.env.example)**: Example environment variable configuration
- **[THEME_DELIVERABLES.md](THEME_DELIVERABLES.md)**: Theme documentation and features

## Project Structure

```
.
├── wp-content/
│   ├── themes/
│   │   └── b30sc-matrix/          # Main theme directory
│   │       ├── style.css          # Theme styles
│   │       ├── functions.php      # Theme functions
│   │       ├── theme.json         # Theme configuration
│   │       ├── template-login.php # Custom login template
│   │       ├── templates/         # Block templates
│   │       ├── parts/             # Template parts
│   │       └── patterns/          # Block patterns
│   └── mu-plugins/                # Must-use plugins
│       ├── b30sc-oauth-login.php  # OAuth login plugin
│       ├── nextend-social-login-config.json
│       └── README.md
├── .env.example                   # Environment variables template
├── .gitignore                     # Git ignore rules
├── OAUTH_SETUP.md                 # OAuth setup guide
├── wp-config-oauth-example.php    # wp-config example
└── README.md                      # This file
```

## OAuth Implementation

### Architecture

The OAuth login system consists of three main components:

1. **Must-Use Plugin** (`wp-content/mu-plugins/b30sc-oauth-login.php`):
   - Handles login page creation and redirect logic
   - Applies Matrix theme styling to login page
   - Manages OAuth credential configuration
   - Provides shortcode for login form

2. **Custom Template** (`wp-content/themes/b30sc-matrix/template-login.php`):
   - Matrix-themed login page layout
   - Responsive design
   - OAuth buttons + traditional login form
   - Logged-in user messaging

3. **Configuration Files**:
   - `wp-config.php`: Stores OAuth credentials (not in repo)
   - `.env`: Alternative credential storage (not in repo)
   - `nextend-social-login-config.json`: Configuration reference

### How It Works

1. **User Access**: When a user visits `/login/` or tries to access wp-admin while logged out
2. **Page Display**: Custom login page loads with Matrix theme styling
3. **OAuth Options**: User can choose Google, GitHub, or traditional login
4. **Authentication**: OAuth provider handles authentication
5. **Callback**: Provider redirects back with auth token
6. **User Creation/Login**: WordPress creates user or logs in existing user
7. **Redirect**: User redirected to dashboard (admin) or home page (user)

### Callback URLs

Make sure to configure these callback URLs in your OAuth applications:

#### Google Cloud Console (Authorized redirect URIs):
```
https://yourdomain.com/wp-login.php?loginSocial=google
https://yourdomain.com/?loginSocial=google
https://yourdomain.com/login/?loginSocial=google
```

#### GitHub OAuth App (Authorization callback URL):
```
https://yourdomain.com/wp-login.php?loginSocial=github
```

## Configuration Methods

### Method 1: wp-config.php (Recommended)

Add to `wp-config.php` before "That's all, stop editing!":

```php
// OAuth Configuration
define('B30SC_GOOGLE_CLIENT_ID', 'your-google-client-id.apps.googleusercontent.com');
define('B30SC_GOOGLE_CLIENT_SECRET', 'your-google-client-secret');
define('B30SC_GITHUB_CLIENT_ID', 'your-github-client-id');
define('B30SC_GITHUB_CLIENT_SECRET', 'your-github-client-secret');
```

### Method 2: Environment Variables

Set environment variables and load in `wp-config.php`:

```php
// Load OAuth credentials from environment
if (getenv('B30SC_GOOGLE_CLIENT_ID')) {
    define('B30SC_GOOGLE_CLIENT_ID', getenv('B30SC_GOOGLE_CLIENT_ID'));
}
if (getenv('B30SC_GOOGLE_CLIENT_SECRET')) {
    define('B30SC_GOOGLE_CLIENT_SECRET', getenv('B30SC_GOOGLE_CLIENT_SECRET'));
}
if (getenv('B30SC_GITHUB_CLIENT_ID')) {
    define('B30SC_GITHUB_CLIENT_ID', getenv('B30SC_GITHUB_CLIENT_ID'));
}
if (getenv('B30SC_GITHUB_CLIENT_SECRET')) {
    define('B30SC_GITHUB_CLIENT_SECRET', getenv('B30SC_GITHUB_CLIENT_SECRET'));
}
```

### Method 3: .env File

1. Copy `.env.example` to `.env`
2. Fill in your credentials
3. Use a dotenv library or plugin to load

## Testing

### Local Development

For local testing with OAuth:

1. **Use HTTPS**: OAuth requires SSL
   - Use Local by Flywheel, XAMPP with SSL, or ngrok
   
2. **Configure Callback URLs**: Add localhost URLs to OAuth apps:
   ```
   http://localhost/wp-login.php?loginSocial=google
   http://localhost/wp-login.php?loginSocial=github
   ```

3. **Test Each Provider**:
   - Click "Continue with Google"
   - Click "Continue with GitHub"
   - Try traditional username/password

### Production Testing Checklist

- [ ] SSL certificate installed (HTTPS)
- [ ] OAuth credentials configured in wp-config.php
- [ ] Nextend Social Login plugin installed and activated
- [ ] Callback URLs registered with OAuth providers
- [ ] Custom login page accessible at `/login/`
- [ ] wp-login.php redirects to custom page
- [ ] Google OAuth login works
- [ ] GitHub OAuth login works
- [ ] Traditional WordPress login works
- [ ] User creation works for new OAuth users
- [ ] Redirect after login works correctly
- [ ] Matrix theme styling applied correctly
- [ ] Mobile responsive design works
- [ ] No JavaScript console errors
- [ ] No PHP errors in logs

## Security

### Best Practices

1. **Never commit credentials**:
   - wp-config.php is in .gitignore
   - .env files are in .gitignore
   - Never commit OAuth secrets

2. **Use HTTPS**:
   - OAuth requires SSL in production
   - Get free SSL from Let's Encrypt
   - Redirect HTTP to HTTPS

3. **Rotate credentials**:
   - Change OAuth secrets every 90 days
   - Revoke old secrets after rotation
   - Document rotations

4. **Limit OAuth scopes**:
   - Only request necessary permissions
   - Review scopes regularly

5. **Monitor usage**:
   - Check OAuth dashboards
   - Review user creation logs
   - Set up alerts for anomalies

### What NOT to Do

❌ Don't commit wp-config.php with credentials  
❌ Don't commit .env file  
❌ Don't share credentials via email or chat  
❌ Don't use HTTP in production  
❌ Don't use the same credentials across environments  
❌ Don't skip callback URL configuration  

## Troubleshooting

### OAuth buttons not showing

1. Check Nextend Social Login is installed and activated
2. Verify providers enabled in plugin settings
3. Confirm credentials set in wp-config.php
4. Clear browser cache

### "redirect_uri_mismatch" error

1. Check callback URLs match exactly in OAuth app settings
2. Ensure HTTPS in production
3. Add all callback URL variations
4. Wait a few minutes after updating

### Matrix styling not applied

1. Hard refresh (Ctrl+F5 or Cmd+Shift+R)
2. Clear WordPress cache
3. Check theme is activated
4. Verify no conflicting plugins

### Login redirect not working

1. Check redirect_after_login function
2. Verify user roles
3. Test with different user types
4. Check for conflicting redirect plugins

For more troubleshooting, see [OAUTH_SETUP.md](OAUTH_SETUP.md).

## Requirements

- WordPress 6.0 or higher
- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB 10.2+)
- HTTPS/SSL certificate (required for OAuth)
- Nextend Social Login plugin

## Browser Support

- Chrome/Edge (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Contributing

When contributing to this project:

1. Never commit OAuth credentials
2. Test all OAuth providers before submitting
3. Ensure Matrix theme styling is maintained
4. Update documentation for new features
5. Test on multiple browsers and devices
6. Follow WordPress coding standards

## License

This theme and OAuth implementation are licensed under GPL v2 or later.

## Support

For issues, questions, or feature requests:

1. Check [OAUTH_SETUP.md](OAUTH_SETUP.md) for detailed setup help
2. Review [wp-content/mu-plugins/README.md](wp-content/mu-plugins/README.md) for technical details
3. Check WordPress debug logs
4. Contact B30SC development team

## Credits

- **Theme**: B30SC Matrix by B30SC
- **OAuth Plugin**: Nextend Social Login by Nextendweb
- **Inspiration**: The Matrix film series
- **Design**: Cybersecurity aesthetic with terminal styling

## Changelog

### Version 1.0.0 (2024-12-12)
- Initial release
- B30SC Matrix theme
- Google OAuth integration
- GitHub OAuth integration
- Custom Matrix-themed login page
- wp-login.php redirect functionality
- Comprehensive documentation
- Security best practices
- Local testing support

---

**Note**: This project requires proper OAuth configuration to function. Please follow the setup instructions in [OAUTH_SETUP.md](OAUTH_SETUP.md) carefully.
