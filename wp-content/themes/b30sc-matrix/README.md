# B30SC Matrix Theme

A custom WordPress block theme with a black/green cybersecurity aesthetic inspired by The Matrix movie. This full-site editing (FSE) compatible theme features neon effects, code-like typography, and a futuristic design perfect for security-focused websites.

## Features

### Design & Aesthetic
- **Black/Green Color Scheme**: Matrix-inspired neon green (#00FF00) text on pure black (#000000) backgrounds
- **Cybersecurity Theme**: Professional security-focused design with code-like typography
- **Neon Effects**: Text glows, animations, and visual depth using CSS effects
- **Code-Like Background**: Scanline effect simulating terminal/matrix themes

### Typography
- **OCR A Font**: Primary font for headings and prominent text
- **Courier New**: Monospace font for body text and code blocks
- **System Sans**: Clean fallback sans-serif font

### Color Palette
The theme includes a comprehensive color palette:
- **Neon Green** (#00FF00) - Primary accent color
- **Matrix Green** (#00CC00) - Secondary accent
- **Dark Green** (#00AA00) - Tertiary accent
- **Black** (#000000) - Primary background
- **Dark Background** (#1A1A1A) - Secondary background
- **Darker Background** (#0D0D0D) - Tertiary background
- **White** (#FFFFFF) - Bright text color
- **Light Gray** (#CCCCCC) - Body text color

### Gradients
- Linear gradient from black to neon green
- Dark to matrix green gradient
- Black through greens gradient
- Dark subtle gradient

### Components & Blocks

#### Block Patterns
The theme includes reusable block patterns:

1. **Hero Section** (`hero.php`)
   - Full-width hero with headline and dual call-to-action buttons
   - Neon glow effects on heading
   - Green and outlined button styles

2. **Services Section** (`services.php`)
   - Three-column layout showcasing services
   - Custom green borders and backgrounds
   - Responsive card design with hover effects

3. **Call-to-Action Section** (`cta.php`)
   - Prominent CTA section with split layout
   - Bordered container with green accents
   - Centered action button

#### Templates

1. **Front Page** (`front-page.html`)
   - Homepage with hero, services, and CTA sections
   - Fully customizable with block editor
   - Features responsive layout

2. **Archive** (`archive.html`)
   - Blog archive/listing page
   - Query loop with featured posts
   - Pagination support
   - Green accent styling

3. **Single** (`single.html`)
   - Individual post/article page
   - Related posts section
   - Post metadata display
   - Full content area

4. **Index** (`index.html`)
   - Generic listing page
   - Query loop for posts
   - Pagination controls

#### Template Parts

1. **Header** (`parts/header.html`)
   - Site logo and title
   - Navigation menu
   - Dark background with green border bottom
   - Responsive design

2. **Footer** (`parts/footer.html`)
   - Three-column layout with About, Services, and Contact
   - Copyright information
   - Privacy and Terms links
   - Green accent styling

### CSS Features

- **Neon Glow Effects**: Text shadows for h1, h2, h3 headings
- **Scanline Animation**: Background animation creating CRT/terminal effect
- **Hover States**: Interactive elements with glow and scale effects
- **Custom Styling**: Buttons, inputs, tables, code blocks, and navigation
- **Responsive Design**: Mobile-friendly layouts with media queries
- **Print Styles**: Optimized printing with disabled animations

### Block Customization

The theme provides custom styling for WordPress blocks:
- Core buttons with neon green styling
- Code blocks with dark backgrounds
- Headings with glow effects
- Paragraph text in light gray
- Tables with green borders
- Quote blocks with green left border
- Group blocks with left green borders

## File Structure

```
wp-content/themes/b30sc-matrix/
├── style.css                 # Main stylesheet (required)
├── style-editor.css          # Editor-specific styles
├── theme.json                # Theme configuration and settings
├── functions.php             # Theme functions and hooks
├── README.md                 # This file
├── templates/                # Block templates
│   ├── front-page.html      # Homepage
│   ├── archive.html         # Blog archive
│   ├── index.html           # Generic listing
│   └── single.html          # Single post
├── parts/                    # Template parts
│   ├── header.html          # Site header
│   └── footer.html          # Site footer
└── patterns/                 # Reusable block patterns
    ├── hero.php             # Hero pattern
    ├── services.php         # Services pattern
    └── cta.php              # Call-to-action pattern
```

## Installation & Activation

### Prerequisites
- WordPress 6.0 or higher
- PHP 7.4 or higher
- Full Site Editing (FSE) support enabled

### Installation Steps

1. **Via WordPress Admin Dashboard:**
   - Go to `Appearance → Themes`
   - Click on "Add New"
   - Click on "Upload Theme"
   - Upload the theme zip file (or copy to wp-content/themes/b30sc-matrix/)
   - Click "Activate"

2. **Manual Installation:**
   - Download the theme
   - Extract to `/wp-content/themes/b30sc-matrix/`
   - Go to `Appearance → Themes` in WordPress admin
   - Find "B30SC Matrix" in the theme list
   - Click "Activate"

3. **Via Git Clone:**
   ```bash
   cd wp-content/themes/
   git clone <repository-url> b30sc-matrix
   ```

### After Activation

1. **Customize Colors and Fonts:**
   - Go to `Appearance → Customize`
   - Edit color palette and typography settings
   - Changes are stored in theme.json

2. **Create Homepage:**
   - Go to `Appearance → Editor (Beta)`
   - The front-page template will be available
   - Edit and customize as needed

3. **Configure Navigation:**
   - Go to `Appearance → Menus`
   - Create a menu and assign to the header location
   - Menu items will be displayed in the header template part

4. **Add Blog Posts:**
   - Go to `Posts → Add New`
   - Create content - it will automatically use the archive and single templates

5. **Use Block Patterns:**
   - In the block editor, click the patterns button
   - Browse and insert Hero, Services, or CTA patterns
   - Customize with your content

## Customization Guide

### Changing Colors
Edit `theme.json` to modify the color palette:
```json
"palette": [
  {
    "color": "#00FF00",
    "name": "Neon Green",
    "slug": "neon-green"
  }
]
```

### Modifying Typography
Edit font families in `theme.json`:
```json
"fontFamilies": [
  {
    "fontFamily": "\"OCR A\", \"Courier New\", monospace",
    "name": "OCR A",
    "slug": "ocr-a"
  }
]
```

### Custom CSS
Add custom CSS to `style.css` for additional styling beyond what's defined in `theme.json`.

### Block-Specific Styling
Modify styles in `style.css` or individual block styles in `theme.json` under the `styles.blocks` section.

## Browser Support

The theme is optimized for:
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Notes

- Minimal JavaScript - theme primarily uses CSS
- Optimized font loading
- Efficient CSS animations (GPU-accelerated)
- Responsive images support
- Fast page load times

## Accessibility

The theme follows WCAG 2.1 guidelines:
- Semantic HTML structure
- Proper heading hierarchy
- Color contrast compliance
- Keyboard navigation support
- ARIA labels where appropriate

## License

GPL v2 or later. See LICENSE file for details.

## Support & Contribution

For issues, feature requests, or contributions, please contact:
- **Email**: info@b30sc.com
- **Website**: https://b30sc.com

## Changelog

### Version 1.0.0
- Initial theme release
- Full block theme implementation
- Hero, Services, and CTA patterns
- Homepage, Archive, Single, and Index templates
- Header and Footer template parts
- Comprehensive styling and effects

## Credits

Theme developed for B30SC
Inspired by The Matrix aesthetic and modern cybersecurity design principles.
