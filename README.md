# WP Mega Menu

A WordPress mega menu plugin with automatic hierarchy detection and mobile-responsive design.

## Features

- 🎯 Automatic mega menu detection based on menu hierarchy
- 📱 Fully mobile-responsive with hamburger menu
- 🎨 Beautiful gradient design with smooth animations
- 🔧 Easy integration via shortcode
- 🚀 No configuration required - works automatically

## Installation

1. Upload the plugin files to the `/wp-content/plugins/bliss-mega-menu` directory
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the `[bliss_mega_menu]` shortcode to display the menu

## Usage

### Basic Usage
```
[bliss_mega_menu]
```

### Display Specific Menu
```
[bliss_mega_menu menu="Main Menu"]
[bliss_mega_menu menu="primary-menu"]
[bliss_mega_menu menu="25"]
```

### Display Menu from Theme Location
```
[bliss_mega_menu theme_location="primary"]
```

### Disable Fallback
```
[bliss_mega_menu menu="Main Menu" fallback="none"]
```

## Menu Structure

The plugin automatically creates a mega menu when it detects a 3+ level hierarchy:

1. **Top Level**: Main navigation items
2. **Level 2**: Section headers (columns in mega menu)
3. **Level 3**: Service groups or categories
4. **Level 4**: Individual links

## Styling

- Full-width navbar with gradient background
- 4-column mega menu layout on desktop
- Mobile-friendly with slide-out navigation
- Smooth hover effects and transitions

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher

## License

GPL v2 or later