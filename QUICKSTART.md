# Quick Start Guide

Get the OAuth login working in 5 minutes!

## Step 1: Install Dependencies (2 minutes)

```bash
# Activate the theme
wp theme activate b30sc-matrix

# Install Nextend Social Login plugin
wp plugin install nextend-social-login --activate
```

## Step 2: Get OAuth Credentials (2 minutes)

### Google OAuth
1. Go to https://console.cloud.google.com/
2. Create project → Enable Google+ API
3. Create OAuth credentials
4. Add redirect URI: `https://yourdomain.com/wp-login.php?loginSocial=google`
5. Copy Client ID and Client Secret

### GitHub OAuth
1. Go to https://github.com/settings/developers
2. New OAuth App
3. Set callback URL: `https://yourdomain.com/wp-login.php?loginSocial=github`
4. Copy Client ID and Client Secret

## Step 3: Configure Credentials (1 minute)

Edit `wp-config.php` and add before "That's all, stop editing!":

```php
// Google OAuth
define('B30SC_GOOGLE_CLIENT_ID', 'your-client-id.apps.googleusercontent.com');
define('B30SC_GOOGLE_CLIENT_SECRET', 'your-client-secret');

// GitHub OAuth
define('B30SC_GITHUB_CLIENT_ID', 'your-github-client-id');
define('B30SC_GITHUB_CLIENT_SECRET', 'your-github-client-secret');
```

## Step 4: Configure Nextend Social Login (30 seconds)

1. Go to WordPress Admin → Settings → Nextend Social Login
2. Click **Google** tab → Enable → Save
3. Click **GitHub** tab → Enable → Save

## Step 5: Test It! (30 seconds)

1. Log out of WordPress
2. Navigate to `/login/`
3. Click "Continue with Google" or "Continue with GitHub"
4. You should be logged in!

## Done! 🎉

Your OAuth login is now working!

## Need Help?

- **Full setup guide**: [OAUTH_SETUP.md](OAUTH_SETUP.md)
- **Testing guide**: [TESTING.md](TESTING.md)
- **Technical docs**: [wp-content/mu-plugins/README.md](wp-content/mu-plugins/README.md)

## Troubleshooting

### OAuth buttons not showing?
- Check Nextend Social Login is activated: `wp plugin list`
- Verify credentials in wp-config.php
- Clear browser cache

### "redirect_uri_mismatch" error?
- Check callback URLs match exactly in OAuth apps
- Must use HTTPS in production
- Add all callback URL variations

### Styling looks wrong?
- Hard refresh: Ctrl+F5 (Windows) or Cmd+Shift+R (Mac)
- Verify B30SC Matrix theme is active: `wp theme list`

## Callback URLs Reference

Add these to your OAuth apps:

**Google** (Authorized redirect URIs):
```
https://yourdomain.com/wp-login.php?loginSocial=google
https://yourdomain.com/?loginSocial=google
https://yourdomain.com/login/?loginSocial=google
```

**GitHub** (Authorization callback URL):
```
https://yourdomain.com/wp-login.php?loginSocial=github
```

**Local Development** (add these too):
```
http://localhost/wp-login.php?loginSocial=google
http://localhost/wp-login.php?loginSocial=github
```

## Local Development with HTTPS

OAuth requires HTTPS. Use ngrok for local testing:

```bash
# Install ngrok from https://ngrok.com/download

# Start tunnel
ngrok http 80

# Use the HTTPS URL provided (e.g., https://abc123.ngrok.io)
# Update callback URLs in Google/GitHub with ngrok URL
# Update WordPress URLs:
wp option update home 'https://abc123.ngrok.io'
wp option update siteurl 'https://abc123.ngrok.io'
```

## What You Get

✅ Custom Matrix-themed login page at `/login/`  
✅ Google OAuth login  
✅ GitHub OAuth login  
✅ Traditional WordPress login (fallback)  
✅ Auto-redirect from wp-login.php  
✅ Neon green cybersecurity aesthetic  
✅ Responsive mobile design  
✅ Secure credential management  

---

**Ready for production?** See [OAUTH_SETUP.md](OAUTH_SETUP.md) for advanced configuration and security best practices.
