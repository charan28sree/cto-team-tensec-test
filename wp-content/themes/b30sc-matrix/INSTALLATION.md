# B30SC Matrix Theme - Installation & Setup Guide

This guide walks you through installing and activating the B30SC Matrix WordPress theme.

## System Requirements

Before installing the theme, ensure your WordPress installation meets these requirements:

- **WordPress Version**: 6.0 or higher
- **PHP Version**: 7.4 or higher
- **MySQL/MariaDB**: 5.6 or higher
- **Full Site Editing (FSE)**: Must be enabled in WordPress

### Recommended Environment
- WordPress 6.3+
- PHP 8.0+
- Modern browser for theme customization
- 1GB+ available disk space

## Installation Methods

### Method 1: Via WordPress Admin Dashboard (Easiest)

1. **Log in to WordPress Admin**
   - Go to your WordPress dashboard
   - You should see your WordPress admin URL like: `yoursite.com/wp-admin`

2. **Navigate to Themes**
   - In the left menu, hover over "Appearance"
   - Click on "Themes"

3. **Add New Theme**
   - Click the "Add New" button at the top of the page
   - You'll see a "Upload Theme" button or option
   - Click on it

4. **Upload the Theme**
   - Click "Browse" or drag-and-drop the theme zip file
   - Select the B30SC Matrix theme zip file
   - Click "Install Now"

5. **Activate the Theme**
   - After installation completes, click "Activate"
   - The theme is now active on your website

### Method 2: Manual File Upload (FTP/SFTP)

1. **Download the Theme**
   - Download the B30SC Matrix theme files
   - Extract the ZIP file to a folder

2. **Connect via FTP/SFTP**
   - Use FileZilla, WinSCP, or your host's file manager
   - Navigate to: `/wp-content/themes/`

3. **Upload the Theme**
   - Upload the `b30sc-matrix` folder to `/wp-content/themes/`
   - The full path should be: `/wp-content/themes/b30sc-matrix/`

4. **Activate in Dashboard**
   - Go to WordPress admin → Appearance → Themes
   - Find "B30SC Matrix" and click "Activate"

### Method 3: Via Git Clone (For Developers)

1. **SSH into Your Server**
   ```bash
   ssh user@yourhost.com
   cd /path/to/wordpress/wp-content/themes/
   ```

2. **Clone the Repository**
   ```bash
   git clone <repository-url> b30sc-matrix
   cd b30sc-matrix
   ```

3. **Activate in WordPress**
   - Go to WordPress admin → Appearance → Themes
   - Click "Activate" on B30SC Matrix

## Post-Installation Setup

After activating the theme, follow these steps to complete the setup:

### 1. Configure Basic Settings

1. **Go to Appearance → Customize**
   - Review the current theme options
   - Customize colors if desired (optional)

2. **Set Site Identity**
   - Go to Settings → General
   - Verify your Site Title and Tagline
   - Add a site logo under Appearance → Customize → Site Identity

### 2. Create Your Menu

1. **Navigate to Appearance → Menus**
2. **Create a New Menu**
   - Give it a name (e.g., "Main Menu")
   - Add menu items (Home, Services, Blog, Contact, etc.)
   - Click "Create Menu"

3. **Assign to Header**
   - Check the box for "Display location" → "Header Navigation"
   - Save the menu

### 3. Create Content

#### Create a Homepage
1. Go to Pages → Add New
2. Name it "Home"
3. Click the block editor and add content using patterns or blocks
4. Publish the page

To set as homepage:
- Go to Settings → Reading
- Select "A static page" under "Your homepage displays"
- Choose "Home" from the dropdown

#### Create Blog Posts
1. Go to Posts → Add New
2. Write your first post
3. Add featured image (optional but recommended)
4. Add categories or tags
5. Publish

#### Add Services Page
1. Create a new page titled "Services"
2. Use the block editor to add the Services block pattern
3. Customize with your services
4. Publish

#### Add Contact Page
1. Create a new page titled "Contact"
2. Add contact information and forms
3. Publish

### 4. Configure Navigation Links

Edit the template parts to point to your actual pages:

1. Go to **Appearance → Editor (Beta)**
2. In the editor sidebar, click on "Parts" or scroll down
3. Edit the Header part:
   - Update navigation links to point to your actual pages
   - Change # placeholders to real URLs

4. Edit the Footer part:
   - Update contact email
   - Update phone number
   - Update links

### 5. Test the Theme

1. **View Your Site**
   - Click "Visit Site" in the admin
   - Check that everything looks correct
   - Test responsiveness on mobile devices

2. **Test Different Pages**
   - Homepage - should show hero and services
   - Blog archive - should list all posts
   - Single post - should show full post content
   - 404 page - go to a non-existent URL to test

3. **Check Links and Navigation**
   - Click menu items
   - Test all buttons
   - Verify footer links work

## Customizing the Theme

### Change Colors

The theme uses a predefined color palette. To change colors:

1. **Via the Customizer** (Easiest)
   - Go to Appearance → Customize
   - Look for color options
   - Change colors as desired

2. **Edit theme.json** (Advanced)
   - Use a code editor to edit `/wp-content/themes/b30sc-matrix/theme.json`
   - Modify the color values in the `palette` array
   - Save and refresh WordPress

### Change Typography

To modify fonts:

1. **Via theme.json**
   - Edit the `fontFamilies` section in `theme.json`
   - Update font names and URLs
   - Save the file

2. **Add Google Fonts** (Optional)
   - Edit `functions.php`
   - Add font import links in `b30sc_matrix_add_font_support()` function

### Add Custom CSS

1. **Via Customizer**
   - Go to Appearance → Customize
   - Look for "Additional CSS" section
   - Add your custom CSS
   - Save changes

2. **Edit style.css** (Advanced)
   - Open `/wp-content/themes/b30sc-matrix/style.css`
   - Add your custom CSS rules
   - Save the file

## Using Block Patterns

The theme includes reusable block patterns:

1. **In the Block Editor**
   - Click the "Patterns" button (usually in the left sidebar)
   - Browse available patterns
   - Click to insert a pattern
   - Customize with your content

2. **Available Patterns**
   - Hero Section - Use for eye-catching intros
   - Services Section - Showcase your services
   - Features Section - List key features
   - Call-to-Action - Encourage user interaction

## Troubleshooting

### Theme Not Showing Correctly

1. **Clear Cache**
   - Clear your browser cache (Ctrl+Shift+Delete or Cmd+Shift+Delete)
   - Clear WordPress cache if using caching plugin

2. **Check WordPress Version**
   - Go to Dashboard
   - Ensure WordPress is up to date
   - Update if needed

3. **Disable Other Plugins**
   - Temporarily disable all plugins
   - Activate them one by one to find conflicts
   - Keep problematic plugins disabled

### CSS Not Loading

1. **Verify File Permissions**
   - Ensure `style.css` has proper read permissions (644)
   - Check file ownership

2. **Regenerate Permalinks**
   - Go to Settings → Permalinks
   - Change setting and save
   - Change back and save again

3. **Check Web Server**
   - Verify web server is running
   - Check server logs for errors

### Colors Not Applying

1. **Hard Refresh Browser**
   - Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)

2. **Check theme.json Syntax**
   - Ensure JSON is valid (no missing commas or brackets)
   - Use a JSON validator online

3. **Verify File Uploads**
   - Ensure theme files are completely uploaded
   - Check file sizes match original

## Getting Help

### Documentation
- See README.md for complete feature documentation
- Check CHANGELOG.md for version information

### Support
- Email: info@b30sc.com
- Website: https://b30sc.com
- Documentation: https://docs.b30sc.com

### Community
- WordPress Theme Directory (if published)
- WordPress Support Forums
- GitHub Issues (if using repository)

## Next Steps

After successful installation:

1. **Customize Your Content**
   - Add your company information
   - Create your service/product pages
   - Build your blog

2. **Optimize for SEO**
   - Install Yoast SEO or similar
   - Optimize meta descriptions
   - Create XML sitemaps

3. **Set Up Analytics**
   - Add Google Analytics
   - Set up goal tracking
   - Monitor visitor behavior

4. **Improve Performance**
   - Install caching plugin
   - Optimize images
   - Minimize CSS/JS

5. **Backup Regularly**
   - Set up automated backups
   - Test restore procedures
   - Keep backups off-site

## Security Best Practices

1. **Keep WordPress Updated**
   - Always update core, plugins, and themes

2. **Use Strong Passwords**
   - Admin user with strong password
   - Database user with strong password

3. **Regular Backups**
   - Daily automated backups
   - Test restore from backups

4. **Security Plugins**
   - Install Wordfence or similar
   - Enable two-factor authentication
   - Monitor for vulnerabilities

5. **File Permissions**
   - Proper ownership (typically www-data)
   - Proper permissions (644 for files, 755 for directories)
   - No direct access to sensitive files

## Updating the Theme

When updates are available:

1. **Via Dashboard**
   - Go to Appearance → Themes
   - If update available, click "Update"
   - Wait for completion

2. **Backup First**
   - Always backup before updating
   - Test in staging environment if possible

3. **Check Compatibility**
   - Read changelog for breaking changes
   - Test with current plugins

## Support & Feedback

We'd love to hear about your experience:

- **Bug Reports**: Report issues via support email
- **Feature Requests**: Suggest improvements
- **Reviews**: Share your experience
- **Testimonials**: Tell us how you're using the theme

---

**Congratulations!** Your B30SC Matrix theme is now installed and ready to use. Start creating amazing content! 🎉
