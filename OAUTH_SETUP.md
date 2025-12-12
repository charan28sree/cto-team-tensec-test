# OAuth Login Setup Guide

This guide explains how to set up OAuth login with Google and GitHub for the B30SC Matrix WordPress site using Nextend Social Login plugin.

## Table of Contents

1. [Overview](#overview)
2. [Prerequisites](#prerequisites)
3. [Installing Nextend Social Login](#installing-nextend-social-login)
4. [Google OAuth Setup](#google-oauth-setup)
5. [GitHub OAuth Setup](#github-oauth-setup)
6. [Configuration Methods](#configuration-methods)
7. [Callback URLs](#callback-urls)
8. [Testing the Integration](#testing-the-integration)
9. [Troubleshooting](#troubleshooting)

## Overview

The B30SC Matrix theme includes a custom OAuth login implementation that:
- Provides a custom login page styled with the Matrix theme aesthetic
- Supports Google and GitHub OAuth authentication
- Redirects from the default `wp-login.php` to the custom login page
- Stores OAuth credentials securely via wp-config.php constants or environment variables

## Prerequisites

- WordPress 6.0 or higher
- PHP 7.4 or higher
- Active B30SC Matrix theme
- SSL certificate (HTTPS is required for OAuth)
- Access to your server's wp-config.php or environment variables

## Installing Nextend Social Login

### Option 1: Via WordPress Admin (Recommended for Production)

1. Log into your WordPress admin dashboard
2. Navigate to **Plugins > Add New**
3. Search for "Nextend Social Login"
4. Click **Install Now** on "Nextend Social Login" by Nextendweb
5. Click **Activate**

### Option 2: Manual Installation

```bash
cd wp-content/plugins
wget https://downloads.wordpress.org/plugin/nextend-social-login.latest.zip
unzip nextend-social-login.latest.zip
rm nextend-social-login.latest.zip
```

Then activate via WordPress admin or WP-CLI:

```bash
wp plugin activate nextend-social-login
```

## Google OAuth Setup

### Step 1: Create a Google Cloud Project

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Click **Select a project** → **New Project**
3. Enter project name (e.g., "B30SC Matrix Login")
4. Click **Create**

### Step 2: Enable Google+ API

1. In your project, navigate to **APIs & Services > Library**
2. Search for "Google+ API"
3. Click on it and click **Enable**

### Step 3: Configure OAuth Consent Screen

1. Navigate to **APIs & Services > OAuth consent screen**
2. Select **External** (or Internal if using Google Workspace)
3. Click **Create**
4. Fill in required information:
   - App name: "B30SC Matrix"
   - User support email: your email
   - Developer contact email: your email
5. Click **Save and Continue**
6. Skip Scopes section (click **Save and Continue**)
7. Add test users if needed (for development)
8. Click **Save and Continue**

### Step 4: Create OAuth 2.0 Credentials

1. Navigate to **APIs & Services > Credentials**
2. Click **Create Credentials** → **OAuth client ID**
3. Select **Web application**
4. Name: "B30SC Matrix WordPress"
5. Add **Authorized redirect URIs**:
   ```
   https://yourdomain.com/wp-login.php?loginSocial=google
   https://yourdomain.com/?loginSocial=google
   ```
6. Click **Create**
7. **Save your Client ID and Client Secret** - you'll need these!

### Step 5: Configure in WordPress

Add to your `wp-config.php` (before "That's all, stop editing!"):

```php
// Google OAuth Configuration
define('B30SC_GOOGLE_CLIENT_ID', 'your-google-client-id.apps.googleusercontent.com');
define('B30SC_GOOGLE_CLIENT_SECRET', 'your-google-client-secret');
```

Or set environment variables:

```bash
export B30SC_GOOGLE_CLIENT_ID="your-google-client-id.apps.googleusercontent.com"
export B30SC_GOOGLE_CLIENT_SECRET="your-google-client-secret"
```

## GitHub OAuth Setup

### Step 1: Create a GitHub OAuth App

1. Go to [GitHub Settings](https://github.com/settings/developers)
2. Click **OAuth Apps** in the left sidebar
3. Click **New OAuth App**

### Step 2: Configure OAuth App

Fill in the application details:

- **Application name**: B30SC Matrix
- **Homepage URL**: `https://yourdomain.com`
- **Application description**: OAuth login for B30SC Matrix site
- **Authorization callback URL**: 
  ```
  https://yourdomain.com/wp-login.php?loginSocial=github
  ```

### Step 3: Generate Client Secret

1. Click **Register application**
2. On the next page, click **Generate a new client secret**
3. **Save your Client ID and Client Secret** - you'll need these!

### Step 4: Configure in WordPress

Add to your `wp-config.php` (before "That's all, stop editing!"):

```php
// GitHub OAuth Configuration
define('B30SC_GITHUB_CLIENT_ID', 'your-github-client-id');
define('B30SC_GITHUB_CLIENT_SECRET', 'your-github-client-secret');
```

Or set environment variables:

```bash
export B30SC_GITHUB_CLIENT_ID="your-github-client-id"
export B30SC_GITHUB_CLIENT_SECRET="your-github-client-secret"
```

## Configuration Methods

### Method 1: wp-config.php (Recommended)

Edit your `wp-config.php` file and add all OAuth constants:

```php
// OAuth Configuration for B30SC Matrix
define('B30SC_GOOGLE_CLIENT_ID', 'your-google-client-id.apps.googleusercontent.com');
define('B30SC_GOOGLE_CLIENT_SECRET', 'your-google-client-secret');
define('B30SC_GITHUB_CLIENT_ID', 'your-github-client-id');
define('B30SC_GITHUB_CLIENT_SECRET', 'your-github-client-secret');
```

### Method 2: Environment Variables

If using environment variables (e.g., with Docker or hosting platforms), load them in `wp-config.php`:

```php
// Load OAuth credentials from environment variables
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

### Method 3: .env File (with plugin like WP-CFM)

Create a `.env` file in your WordPress root:

```env
B30SC_GOOGLE_CLIENT_ID=your-google-client-id.apps.googleusercontent.com
B30SC_GOOGLE_CLIENT_SECRET=your-google-client-secret
B30SC_GITHUB_CLIENT_ID=your-github-client-id
B30SC_GITHUB_CLIENT_SECRET=your-github-client-secret
```

## Callback URLs

### Important: Callback URL Configuration

OAuth providers require specific callback URLs. Make sure to add ALL of these URLs to your OAuth app configurations:

### For Google:
```
https://yourdomain.com/wp-login.php?loginSocial=google
https://yourdomain.com/?loginSocial=google
https://yourdomain.com/login/?loginSocial=google
```

### For GitHub:
```
https://yourdomain.com/wp-login.php?loginSocial=github
https://yourdomain.com/?loginSocial=github
https://yourdomain.com/login/?loginSocial=github
```

### Development/Local URLs:
For local development, also add:
```
http://localhost/wp-login.php?loginSocial=google
http://localhost/wp-login.php?loginSocial=github
http://localhost:8080/wp-login.php?loginSocial=google
http://localhost:8080/wp-login.php?loginSocial=github
```

## Nextend Social Login Configuration

After installing the plugin and setting up OAuth credentials:

1. Navigate to **Settings > Nextend Social Login** in WordPress admin
2. Click on **Google** tab
3. Enable Google Login
4. Your credentials should be auto-populated from wp-config.php constants
5. Configure button settings:
   - Button style: Custom (will use Matrix theme styling)
   - Display on: Login form, Registration form
   - Button text: "Continue with Google"
6. Click **Save Changes**

Repeat for GitHub:
1. Click on **GitHub** tab
2. Enable GitHub Login
3. Credentials auto-populated
4. Configure similar button settings
5. Click **Save Changes**

## Testing the Integration

### Local Development Testing

1. **Access the Custom Login Page**:
   - Navigate to `https://yourdomain.com/login/`
   - Or access any page while logged out

2. **Verify Page Elements**:
   - ✅ Matrix theme styling (black background, green accents)
   - ✅ "Access Terminal" heading with neon glow
   - ✅ Google OAuth button visible
   - ✅ GitHub OAuth button visible
   - ✅ Traditional login form below OAuth buttons
   - ✅ "or" divider between OAuth and traditional login

3. **Test Google OAuth**:
   - Click "Continue with Google" button
   - Should redirect to Google login
   - After authentication, should redirect back to your site
   - Should create a new user or log in existing user
   - Should redirect to dashboard (admin) or home page (user)

4. **Test GitHub OAuth**:
   - Click "Continue with GitHub" button
   - Should redirect to GitHub authorization
   - After authorization, should redirect back to your site
   - Should create a new user or log in existing user
   - Should redirect appropriately

5. **Test Traditional Login**:
   - Enter username/email and password
   - Should login successfully
   - Should redirect appropriately

6. **Test Redirect from wp-login.php**:
   - Navigate directly to `https://yourdomain.com/wp-login.php`
   - Should automatically redirect to custom login page
   - Matrix theme styling should be applied

### Production Testing Checklist

- [ ] SSL certificate is active (HTTPS)
- [ ] All callback URLs are registered with OAuth providers
- [ ] OAuth credentials are set in wp-config.php
- [ ] Nextend Social Login plugin is activated
- [ ] Custom login page is accessible at `/login/`
- [ ] Google OAuth login works
- [ ] GitHub OAuth login works
- [ ] Traditional WordPress login works
- [ ] Users can logout and login again
- [ ] New users are created with correct roles
- [ ] Redirects work correctly after login
- [ ] Mobile responsive design works
- [ ] No JavaScript console errors
- [ ] No PHP errors in logs

## Troubleshooting

### Issue: OAuth buttons don't appear

**Solution**:
1. Verify Nextend Social Login is installed and activated
2. Check that providers are enabled in Settings > Nextend Social Login
3. Verify credentials are set in wp-config.php
4. Clear WordPress cache and browser cache

### Issue: "redirect_uri_mismatch" error

**Solution**:
1. Check callback URLs in Google Cloud Console / GitHub OAuth app
2. Ensure exact match including protocol (https://)
3. Add all variations of callback URLs
4. Wait a few minutes after updating callback URLs

### Issue: Login redirect not working

**Solution**:
1. Check the `redirect_after_login` function in mu-plugin
2. Verify user roles are set correctly
3. Check for conflicting redirect plugins
4. Test with different user roles

### Issue: Matrix theme styling not applied

**Solution**:
1. Clear browser cache
2. Check theme is activated
3. Verify CSS is being enqueued
4. Check browser console for CSS errors
5. Hard refresh (Ctrl+F5 or Cmd+Shift+R)

### Issue: "Client ID not set" error

**Solution**:
1. Verify constants are defined in wp-config.php
2. Check spelling of constant names exactly:
   - `B30SC_GOOGLE_CLIENT_ID`
   - `B30SC_GOOGLE_CLIENT_SECRET`
   - `B30SC_GITHUB_CLIENT_ID`
   - `B30SC_GITHUB_CLIENT_SECRET`
3. Ensure constants are before "That's all, stop editing!"
4. Try clearing WordPress object cache

### Issue: Users can't access wp-admin after OAuth login

**Solution**:
1. Check user role assignment in Nextend Social Login settings
2. Go to Settings > Nextend Social Login > [Provider] > User management
3. Set "Default role" to appropriate role (e.g., "subscriber")
4. Verify existing OAuth users have correct roles in Users panel

### Debugging Tips

1. **Enable WordPress Debug Mode**:
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   define('WP_DEBUG_DISPLAY', false);
   ```

2. **Check Error Logs**:
   ```bash
   tail -f wp-content/debug.log
   ```

3. **Browser Console**: Check for JavaScript errors

4. **Network Tab**: Monitor OAuth redirect flow

5. **Test with Different Browsers**: Rule out cache issues

## Security Best Practices

1. **Never commit credentials to git**:
   - Add `wp-config.php` to `.gitignore`
   - Use environment variables for production
   - Rotate credentials if accidentally exposed

2. **Use Strong Secrets**:
   - Keep client secrets secure
   - Don't share in documentation or comments
   - Store in secure password manager

3. **Restrict OAuth App Access**:
   - In Google Console, review scopes regularly
   - In GitHub, limit to basic user info
   - Monitor OAuth app usage

4. **Regular Updates**:
   - Keep Nextend Social Login plugin updated
   - Monitor plugin changelog for security fixes
   - Test updates in staging environment first

5. **User Role Management**:
   - Set appropriate default role for new OAuth users
   - Review user permissions regularly
   - Consider limiting who can create accounts

## Support and Resources

- **Nextend Social Login Documentation**: https://nextendweb.com/nextend-social-login-docs/
- **Google OAuth Documentation**: https://developers.google.com/identity/protocols/oauth2
- **GitHub OAuth Documentation**: https://docs.github.com/en/developers/apps/building-oauth-apps
- **WordPress Login Customization**: https://developer.wordpress.org/reference/functions/wp_login_form/

## Changelog

### Version 1.0.0
- Initial implementation
- Google and GitHub OAuth support
- Custom Matrix-themed login page
- wp-login.php redirect functionality
- Comprehensive documentation

---

For additional support, please contact the B30SC development team.
