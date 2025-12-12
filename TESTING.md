# OAuth Login Testing Guide

This guide provides step-by-step instructions for testing the OAuth login functionality locally and in production.

## Table of Contents

1. [Prerequisites](#prerequisites)
2. [Local Testing Setup](#local-testing-setup)
3. [Testing Checklist](#testing-checklist)
4. [Test Scenarios](#test-scenarios)
5. [Validation Criteria](#validation-criteria)
6. [Common Issues](#common-issues)

## Prerequisites

Before testing, ensure:

- [ ] WordPress is installed and running
- [ ] B30SC Matrix theme is activated
- [ ] Nextend Social Login plugin is installed and activated
- [ ] OAuth credentials are configured in wp-config.php
- [ ] SSL/HTTPS is available (required for OAuth)
- [ ] Callback URLs are registered with OAuth providers

## Local Testing Setup

### Option 1: Using ngrok (Recommended)

ngrok provides HTTPS tunneling for local development:

```bash
# Install ngrok
# Download from https://ngrok.com/download

# Start ngrok tunnel
ngrok http 80

# Note the HTTPS URL provided (e.g., https://abc123.ngrok.io)
# Use this URL in your OAuth callback configuration
```

Update callback URLs in Google and GitHub:
- Google: `https://abc123.ngrok.io/wp-login.php?loginSocial=google`
- GitHub: `https://abc123.ngrok.io/wp-login.php?loginSocial=github`

Update WordPress site URL:
```bash
wp option update home 'https://abc123.ngrok.io'
wp option update siteurl 'https://abc123.ngrok.io'
```

### Option 2: Local SSL Setup

#### Using Local by Flywheel
- Already provides SSL
- Access via: `https://yoursite.local`

#### Using MAMP/XAMPP
- Enable SSL in configuration
- Access via: `https://localhost:8890`

#### Using WP-CLI Server with SSL
```bash
wp server --host=0.0.0.0 --port=8080 --docroot=.
# Note: This doesn't provide SSL, use with ngrok
```

## Testing Checklist

### Pre-Test Verification

- [ ] Theme activated: `wp theme list`
- [ ] Plugin activated: `wp plugin list`
- [ ] Constants defined: Check wp-config.php
- [ ] Custom login page exists: Visit `/login/`
- [ ] HTTPS enabled
- [ ] No PHP errors in debug.log

### Visual Testing

Visit `/login/` and verify:

- [ ] **Page loads** without errors
- [ ] **Matrix theme styling** applied (black background, green text)
- [ ] **Logo/heading** displays "ACCESS TERMINAL"
- [ ] **Subtitle** shows "Authenticate to proceed"
- [ ] **Google button** visible and styled correctly
- [ ] **GitHub button** visible and styled correctly
- [ ] **"or" divider** displays between OAuth and traditional login
- [ ] **Traditional login form** shows below OAuth buttons
- [ ] **Lost password link** visible
- [ ] **Responsive design** works on mobile (test with DevTools)
- [ ] **Neon glow effects** on headings
- [ ] **Scanline animation** in background
- [ ] **Hover effects** work on buttons

### Functional Testing

#### Test 1: Google OAuth Login

1. **Start test**:
   - Click "Continue with Google" button
   
2. **Expected behavior**:
   - ✅ Redirects to Google login page
   - ✅ Shows correct app name ("B30SC Matrix" or your configured name)
   - ✅ Asks for Google account selection
   
3. **Complete login**:
   - Select Google account
   - Grant permissions if prompted
   
4. **Expected result**:
   - ✅ Redirects back to WordPress site
   - ✅ User is logged in
   - ✅ Redirects to appropriate page (dashboard for admin, home for user)
   - ✅ User account created in WordPress (if new user)
   - ✅ No error messages

#### Test 2: GitHub OAuth Login

1. **Start test**:
   - Click "Continue with GitHub" button
   
2. **Expected behavior**:
   - ✅ Redirects to GitHub authorization page
   - ✅ Shows correct app name
   - ✅ Shows requested permissions
   
3. **Complete authorization**:
   - Click "Authorize" button
   
4. **Expected result**:
   - ✅ Redirects back to WordPress site
   - ✅ User is logged in
   - ✅ Redirects to appropriate page
   - ✅ User account created in WordPress (if new user)
   - ✅ No error messages

#### Test 3: Traditional WordPress Login

1. **Start test**:
   - Enter username/email in login form
   - Enter password
   - Click "Log In" button
   
2. **Expected result**:
   - ✅ User is logged in
   - ✅ Redirects to appropriate page
   - ✅ No error messages

#### Test 4: wp-login.php Redirect

1. **Start test**:
   - Navigate directly to `/wp-login.php`
   
2. **Expected result**:
   - ✅ Automatically redirects to `/login/` (custom page)
   - ✅ Matrix theme styling applied
   - ✅ OAuth buttons visible

#### Test 5: Already Logged In

1. **Start test**:
   - Log in to WordPress
   - Navigate to `/login/`
   
2. **Expected result**:
   - ✅ Shows "Welcome, [username]" message
   - ✅ Shows "You are already logged in"
   - ✅ Shows "Go to Dashboard" button
   - ✅ Shows "Logout" button
   - ✅ Buttons work correctly

#### Test 6: Logout and Re-login

1. **Start test**:
   - Log out from WordPress
   - Navigate to `/login/`
   - Log in again with different provider
   
2. **Expected result**:
   - ✅ Logout works correctly
   - ✅ Can log in with different method
   - ✅ Session is properly established

## Test Scenarios

### Scenario 1: New User Registration

**Goal**: Test that new users can create accounts via OAuth

**Steps**:
1. Use a Google/GitHub account that has never logged in before
2. Click OAuth button
3. Complete authentication

**Expected Outcome**:
- New WordPress user created
- User assigned correct role (default: subscriber)
- User profile populated with OAuth data (name, email)
- User logged in successfully
- Welcome email sent (if configured)

**Validation**:
```bash
# Check user was created
wp user list --field=user_email | grep test@example.com

# Check user role
wp user get test@example.com --field=roles
```

### Scenario 2: Existing User Login

**Goal**: Test that existing users can log in via OAuth

**Steps**:
1. Use a Google/GitHub account that has logged in before
2. Click OAuth button
3. Complete authentication

**Expected Outcome**:
- User recognized by email
- User logged in to existing account
- No duplicate user created
- User redirected correctly

**Validation**:
```bash
# Check no duplicate users
wp user list --field=user_email | sort | uniq -d
```

### Scenario 3: Role-Based Redirect

**Goal**: Test that users redirect based on role after login

**Steps**:
1. Log in as administrator
2. Verify redirects to /wp-admin/
3. Log out
4. Log in as subscriber
5. Verify redirects to home page

**Expected Outcome**:
- Admins → /wp-admin/
- Subscribers → Home page
- Custom roles → Configured destination

### Scenario 4: Failed Authentication

**Goal**: Test error handling for failed OAuth

**Steps**:
1. Click OAuth button
2. Cancel on OAuth provider page
3. Or deny permissions

**Expected Outcome**:
- Redirects back to login page
- Shows appropriate error message
- User can try again
- No PHP errors logged

### Scenario 5: Callback URL Mismatch

**Goal**: Test error handling for misconfigured URLs

**Steps**:
1. Use incorrect callback URL in OAuth app
2. Attempt to log in

**Expected Outcome**:
- OAuth provider shows error
- User redirected back with error
- Error message is user-friendly
- Instructions for fixing provided

## Validation Criteria

### Acceptance Criteria (From Ticket)

✅ **Both providers visible**: Google and GitHub OAuth buttons display on login page  
✅ **Callback URLs documented**: All callback URLs listed in OAUTH_SETUP.md  
✅ **Local login tested**: Login works in local development environment  
✅ **Matrix theme styling**: Login page matches Matrix theme aesthetic  
✅ **wp-login.php redirects**: Default login redirects to custom page  
✅ **Configuration documented**: Setup instructions in multiple files  
✅ **Secure credential storage**: Uses wp-config.php constants or env vars  

### Additional Success Criteria

- [ ] No JavaScript console errors
- [ ] No PHP errors in debug.log
- [ ] No CSS rendering issues
- [ ] Mobile responsive design works
- [ ] Fast page load (< 2 seconds)
- [ ] Accessibility requirements met
- [ ] Cross-browser compatibility
- [ ] No security vulnerabilities

## Common Issues

### Issue: OAuth Buttons Not Visible

**Symptoms**: Login page loads but no OAuth buttons appear

**Debug Steps**:
```bash
# Check if Nextend Social Login is active
wp plugin list --status=active | grep nextend

# Check if shortcode is rendering
wp post get <login-page-id> --field=post_content

# Enable debug mode
wp config set WP_DEBUG true --raw
wp config set WP_DEBUG_LOG true --raw

# Check debug log
tail -f wp-content/debug.log
```

**Solutions**:
1. Activate Nextend Social Login plugin
2. Verify credentials in wp-config.php
3. Enable providers in plugin settings
4. Clear WordPress cache

### Issue: Redirect URI Mismatch

**Symptoms**: OAuth provider shows "redirect_uri_mismatch" error

**Debug Steps**:
1. Check current site URL:
   ```bash
   wp option get home
   wp option get siteurl
   ```
2. Check configured callback URLs in OAuth apps
3. Verify exact match including protocol (http vs https)

**Solutions**:
1. Update callback URLs in Google Cloud Console / GitHub
2. Ensure HTTPS in production
3. Add all callback URL variations
4. Wait 5-10 minutes after updating

### Issue: Styling Not Applied

**Symptoms**: Login page shows but no Matrix theme styling

**Debug Steps**:
```bash
# Check active theme
wp theme list --status=active

# Check template file exists
ls -la wp-content/themes/b30sc-matrix/template-login.php

# Check mu-plugin loaded
ls -la wp-content/mu-plugins/b30sc-oauth-login.php
```

**Solutions**:
1. Clear browser cache (Ctrl+F5)
2. Clear WordPress cache
3. Verify theme is activated
4. Check CSS is being enqueued

### Issue: User Not Created

**Symptoms**: OAuth succeeds but user not in WordPress

**Debug Steps**:
```bash
# Check if user exists
wp user list --search=user@example.com

# Check Nextend Social Login settings
wp option get nsl_settings

# Check PHP errors
tail -f wp-content/debug.log
```

**Solutions**:
1. Verify user role settings in Nextend Social Login
2. Check "Enable Registration" is on
3. Verify email is provided by OAuth provider
4. Check for conflicting user creation plugins

## Performance Testing

### Load Time Testing

Test login page performance:

```bash
# Using curl
curl -w "@curl-format.txt" -o /dev/null -s https://yourdomain.com/login/

# curl-format.txt:
time_namelookup:  %{time_namelookup}\n
time_connect:  %{time_connect}\n
time_starttransfer:  %{time_starttransfer}\n
time_total:  %{time_total}\n
```

**Expected Results**:
- Total page load: < 2 seconds
- Time to interactive: < 1 second
- No render-blocking resources

### OAuth Flow Testing

Time the complete OAuth flow:

1. Click OAuth button: < 100ms
2. Redirect to provider: < 500ms
3. Provider page load: < 2 seconds
4. Callback to WordPress: < 500ms
5. User creation/login: < 1 second
6. Final redirect: < 200ms

**Total Time**: Should be under 5 seconds

## Automated Testing

### WP-CLI Test Commands

```bash
# Test login page exists
wp post list --post_type=page --name=login --format=count
# Expected: 1

# Test theme is active
wp theme list --status=active --field=name | grep b30sc-matrix
# Expected: b30sc-matrix

# Test plugin is active
wp plugin list --status=active --field=name | grep nextend-social-login
# Expected: nextend-social-login

# Test mu-plugin exists
ls wp-content/mu-plugins/b30sc-oauth-login.php
# Expected: file exists

# Test constants are defined
wp eval 'echo defined("B30SC_GOOGLE_CLIENT_ID") ? "YES" : "NO";'
# Expected: YES
```

### Browser Automation Testing

Example using Playwright:

```javascript
// test-oauth-login.js
const { test, expect } = require('@playwright/test');

test('OAuth login page loads correctly', async ({ page }) => {
  await page.goto('https://yourdomain.com/login/');
  
  // Check page loaded
  await expect(page).toHaveTitle(/Login|Access Terminal/);
  
  // Check Matrix styling
  await expect(page.locator('body')).toHaveCSS('background-color', 'rgb(0, 0, 0)');
  
  // Check OAuth buttons present
  await expect(page.locator('text=Continue with Google')).toBeVisible();
  await expect(page.locator('text=Continue with GitHub')).toBeVisible();
  
  // Check traditional login form
  await expect(page.locator('input[name="log"]')).toBeVisible();
  await expect(page.locator('input[name="pwd"]')).toBeVisible();
});
```

## Reporting Issues

When reporting issues, include:

1. **Environment**:
   - WordPress version
   - PHP version
   - Theme version
   - Plugin versions
   - Browser and version

2. **Steps to reproduce**:
   - Exact steps taken
   - URLs accessed
   - Actions performed

3. **Expected vs Actual**:
   - What should happen
   - What actually happened

4. **Screenshots**:
   - Browser console (F12)
   - Network tab
   - Visual errors

5. **Logs**:
   - PHP debug.log
   - Server error logs
   - Browser console errors

## Success Confirmation

After completing all tests, you should be able to confirm:

✅ Google OAuth login works  
✅ GitHub OAuth login works  
✅ Traditional login works  
✅ New users can register via OAuth  
✅ Existing users can log in via OAuth  
✅ Login page styling matches Matrix theme  
✅ wp-login.php redirects to custom page  
✅ Role-based redirects work  
✅ Mobile responsive design works  
✅ No errors in console or logs  
✅ Performance is acceptable  
✅ Security best practices followed  

---

If all tests pass, the OAuth login implementation is ready for production deployment!
