=== Bliss Mega Menu ===
Contributors: blissplumbing
Tags: mega menu, navigation, menu, dropdown, responsive
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple static mega menu plugin that displays a beautiful mega menu via shortcode.

== Description ==

Bliss Mega Menu provides a fully-featured mega menu that can be inserted anywhere on your site using the [bliss_mega_menu] shortcode.

Features:
* Beautiful gradient navigation bar
* Full-width mega menu dropdowns
* Mobile responsive with hamburger menu
* 3-level menu hierarchy
* Service areas with organized city listings
* Smooth animations and hover effects

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/bliss-mega-menu` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the [bliss_mega_menu] shortcode to display the menu anywhere on your site

== Usage ==

Basic usage - displays the first available menu or static fallback:
[bliss_mega_menu]

Display a specific menu by name, ID, or slug:
[bliss_mega_menu menu="Main Menu"]
[bliss_mega_menu menu="primary-menu"]
[bliss_mega_menu menu="25"]

Display menu from a theme location:
[bliss_mega_menu theme_location="primary"]

Disable fallback (show nothing if menu not found):
[bliss_mega_menu menu="Main Menu" fallback="none"]

== Setting Up Your Menu ==

1. Go to Appearance > Menus in WordPress admin
2. Create your menu with this structure:
   - Top Level: Main navigation items (Home, Services, About, etc.)
   - Level 2: Section headers/columns in mega menu
   - Level 3: Service groups or categories
   - Level 4: Individual service links

3. Save the menu

The plugin automatically detects when a menu item has grandchildren (3+ levels deep) and converts it to a mega menu format. No configuration needed!

== Frequently Asked Questions ==

= Can I customize the menu items? =

Currently, this is a static menu. Future versions will include options to customize menu items through the WordPress admin.

= Can I change the colors? =

The menu uses a blue gradient theme. Color customization options will be added in future versions.

= Is it mobile responsive? =

Yes! The menu automatically converts to a mobile-friendly hamburger menu on smaller screens.

== Changelog ==

= 1.0.0 =
* Initial release
* Static mega menu with plumbing services
* Mobile responsive design
* Shortcode support