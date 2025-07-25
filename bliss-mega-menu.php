<?php
/**
 * Plugin Name: Bliss Mega Menu
 * Plugin URI: https://example.com/bliss-mega-menu
 * Description: A static mega menu plugin with shortcode support. Use [bliss_mega_menu] to display the menu.
 * Version: 1.0.0
 * Author: Bliss Plumbing
 * Author URI: https://example.com
 * License: GPL v2 or later
 * Text Domain: bliss-mega-menu
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('BLISS_MEGA_MENU_VERSION', '1.0.0');
define('BLISS_MEGA_MENU_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('BLISS_MEGA_MENU_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once BLISS_MEGA_MENU_PLUGIN_DIR . 'includes/class-mega-menu-walker.php';
// Menu item meta not needed anymore - auto detection
// require_once BLISS_MEGA_MENU_PLUGIN_DIR . 'includes/menu-item-meta.php';
// require_once BLISS_MEGA_MENU_PLUGIN_DIR . 'includes/debug-menu.php';

// Enqueue assets
function bliss_mega_menu_enqueue_assets() {
    wp_enqueue_style(
        'bliss-mega-menu-style',
        BLISS_MEGA_MENU_PLUGIN_URL . 'assets/style.css',
        array(),
        BLISS_MEGA_MENU_VERSION
    );
    
    wp_enqueue_script(
        'bliss-mega-menu-script',
        BLISS_MEGA_MENU_PLUGIN_URL . 'assets/script.js',
        array(),
        BLISS_MEGA_MENU_VERSION,
        true
    );
}

// Shortcode function
function bliss_mega_menu_shortcode($atts) {
    // Parse attributes
    $atts = shortcode_atts(array(
        'menu' => '',              // Menu ID, slug, or name
        'theme_location' => '',    // Theme location
        'fallback' => 'static'     // Fallback: 'static' or 'none'
    ), $atts, 'bliss_mega_menu');
    
    // Enqueue assets when shortcode is used
    bliss_mega_menu_enqueue_assets();
    
    // Start output buffering
    ob_start();
    
    // Include the appropriate template
    $template_args = array(
        'menu' => $atts['menu'],
        'theme_location' => $atts['theme_location'],
        'fallback' => $atts['fallback']
    );
    
    include BLISS_MEGA_MENU_PLUGIN_DIR . 'templates/mega-menu.php';
    
    // Return the buffered content
    return ob_get_clean();
}

// Register shortcode
add_shortcode('bliss_mega_menu', 'bliss_mega_menu_shortcode');