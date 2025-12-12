<?php
/**
 * OAuth Configuration for B30SC Matrix Theme
 * 
 * This file contains example configuration for OAuth login with Google and GitHub.
 * Copy these lines to your wp-config.php file (before "That's all, stop editing!").
 * 
 * IMPORTANT: Replace the placeholder values with your actual OAuth credentials.
 * 
 * DO NOT commit this file with real credentials to version control!
 */

// ====================================================================
// Google OAuth Configuration
// ====================================================================
// 
// To get these credentials:
// 1. Go to https://console.cloud.google.com/
// 2. Create a new project or select existing
// 3. Enable Google+ API
// 4. Create OAuth 2.0 credentials
// 5. Add authorized redirect URIs:
//    - https://yourdomain.com/wp-login.php?loginSocial=google
//    - https://yourdomain.com/?loginSocial=google
// 
// Client ID format: xxxxxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.apps.googleusercontent.com
define('B30SC_GOOGLE_CLIENT_ID', 'your-google-client-id.apps.googleusercontent.com');

// Client Secret: 24-character alphanumeric string
define('B30SC_GOOGLE_CLIENT_SECRET', 'your-google-client-secret');

// ====================================================================
// GitHub OAuth Configuration
// ====================================================================
// 
// To get these credentials:
// 1. Go to https://github.com/settings/developers
// 2. Click "OAuth Apps" > "New OAuth App"
// 3. Fill in application details
// 4. Set Authorization callback URL:
//    - https://yourdomain.com/wp-login.php?loginSocial=github
// 5. Generate a client secret
// 
// Client ID: 20-character alphanumeric string
define('B30SC_GITHUB_CLIENT_ID', 'your-github-client-id');

// Client Secret: 40-character alphanumeric string
define('B30SC_GITHUB_CLIENT_SECRET', 'your-github-client-secret');

// ====================================================================
// Alternative: Load from Environment Variables
// ====================================================================
// 
// If you prefer to use environment variables (recommended for production):
// 
// // Google OAuth from environment
// if (getenv('B30SC_GOOGLE_CLIENT_ID')) {
//     define('B30SC_GOOGLE_CLIENT_ID', getenv('B30SC_GOOGLE_CLIENT_ID'));
// }
// if (getenv('B30SC_GOOGLE_CLIENT_SECRET')) {
//     define('B30SC_GOOGLE_CLIENT_SECRET', getenv('B30SC_GOOGLE_CLIENT_SECRET'));
// }
// 
// // GitHub OAuth from environment
// if (getenv('B30SC_GITHUB_CLIENT_ID')) {
//     define('B30SC_GITHUB_CLIENT_ID', getenv('B30SC_GITHUB_CLIENT_ID'));
// }
// if (getenv('B30SC_GITHUB_CLIENT_SECRET')) {
//     define('B30SC_GITHUB_CLIENT_SECRET', getenv('B30SC_GITHUB_CLIENT_SECRET'));
// }

// ====================================================================
// Security Best Practices
// ====================================================================
// 
// 1. Never commit credentials to version control
//    - Add wp-config.php to .gitignore
//    - Use environment variables in production
//    - Use secrets management for sensitive values
// 
// 2. Use different credentials for each environment
//    - Development: http://localhost callback URLs
//    - Staging: https://staging.yourdomain.com callback URLs
//    - Production: https://yourdomain.com callback URLs
// 
// 3. Rotate credentials periodically
//    - Generate new secrets every 90 days
//    - Revoke old credentials after rotation
//    - Document rotation in security logs
// 
// 4. Limit OAuth scopes
//    - Only request necessary permissions
//    - Review scope requests regularly
//    - Document why each scope is needed
// 
// 5. Monitor OAuth usage
//    - Check OAuth app dashboards regularly
//    - Set up alerts for unusual activity
//    - Review user creation logs
// 
// 6. Use HTTPS in production
//    - OAuth requires SSL/TLS
//    - Get free certificate from Let's Encrypt
//    - Redirect HTTP to HTTPS
// 
// 7. Backup credentials securely
//    - Store in password manager
//    - Share via secure channels only
//    - Never email or chat credentials

// ====================================================================
// Environment-Specific Configuration Example
// ====================================================================
// 
// Define different credentials based on environment:
// 
// if (defined('WP_ENVIRONMENT_TYPE')) {
//     switch (WP_ENVIRONMENT_TYPE) {
//         case 'local':
//         case 'development':
//             define('B30SC_GOOGLE_CLIENT_ID', 'dev-google-client-id');
//             define('B30SC_GOOGLE_CLIENT_SECRET', 'dev-google-secret');
//             define('B30SC_GITHUB_CLIENT_ID', 'dev-github-client-id');
//             define('B30SC_GITHUB_CLIENT_SECRET', 'dev-github-secret');
//             break;
//         
//         case 'staging':
//             define('B30SC_GOOGLE_CLIENT_ID', 'staging-google-client-id');
//             define('B30SC_GOOGLE_CLIENT_SECRET', 'staging-google-secret');
//             define('B30SC_GITHUB_CLIENT_ID', 'staging-github-client-id');
//             define('B30SC_GITHUB_CLIENT_SECRET', 'staging-github-secret');
//             break;
//         
//         case 'production':
//             define('B30SC_GOOGLE_CLIENT_ID', getenv('B30SC_GOOGLE_CLIENT_ID'));
//             define('B30SC_GOOGLE_CLIENT_SECRET', getenv('B30SC_GOOGLE_CLIENT_SECRET'));
//             define('B30SC_GITHUB_CLIENT_ID', getenv('B30SC_GITHUB_CLIENT_ID'));
//             define('B30SC_GITHUB_CLIENT_SECRET', getenv('B30SC_GITHUB_CLIENT_SECRET'));
//             break;
//     }
// }

// ====================================================================
// Callback URLs Reference
// ====================================================================
// 
// Add these URLs to your OAuth app configurations:
// 
// Google Cloud Console (Authorized redirect URIs):
// - https://yourdomain.com/wp-login.php?loginSocial=google
// - https://yourdomain.com/?loginSocial=google
// - https://yourdomain.com/login/?loginSocial=google
// 
// GitHub OAuth App (Authorization callback URL):
// - https://yourdomain.com/wp-login.php?loginSocial=github
// 
// For local development:
// - http://localhost/wp-login.php?loginSocial=google
// - http://localhost/wp-login.php?loginSocial=github
// - http://localhost:8080/wp-login.php?loginSocial=google
// - http://localhost:8080/wp-login.php?loginSocial=github

// ====================================================================
// Verification
// ====================================================================
// 
// To verify your configuration is working:
// 
// 1. Check constants are defined:
//    Navigate to: /wp-admin/ (you'll be redirected to login)
//    Check that OAuth buttons appear
// 
// 2. Test OAuth flow:
//    Click "Continue with Google" or "Continue with GitHub"
//    Should redirect to provider, then back to your site
// 
// 3. Check for errors:
//    Enable WP_DEBUG in wp-config.php
//    Check wp-content/debug.log for errors
// 
// 4. Verify redirects:
//    After login, should redirect to appropriate page
//    Admins -> /wp-admin/
//    Users -> home page

// ====================================================================
// For complete setup instructions, see:
// - /OAUTH_SETUP.md
// - /wp-content/mu-plugins/README.md
// ====================================================================
