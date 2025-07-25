<?php
/**
 * Debug helper to show menu structure and meta values
 */

add_shortcode('bliss_debug_menu', 'bliss_mega_menu_debug_shortcode');
function bliss_mega_menu_debug_shortcode($atts) {
    $atts = shortcode_atts(array(
        'menu' => ''
    ), $atts);
    
    $output = '<div style="background: #f0f0f0; padding: 20px; margin: 20px 0;">';
    $output .= '<h3>Menu Debug Information</h3>';
    
    // Get the menu
    $menu_obj = false;
    if (!empty($atts['menu'])) {
        $menu_obj = wp_get_nav_menu_object($atts['menu']);
    } else {
        $menus = wp_get_nav_menus();
        if (!empty($menus)) {
            $menu_obj = $menus[0];
        }
    }
    
    if (!$menu_obj) {
        $output .= '<p>No menu found!</p>';
        $output .= '</div>';
        return $output;
    }
    
    $output .= '<p><strong>Menu:</strong> ' . esc_html($menu_obj->name) . ' (ID: ' . $menu_obj->term_id . ')</p>';
    
    // Get menu items
    $menu_items = wp_get_nav_menu_items($menu_obj->term_id);
    
    if (empty($menu_items)) {
        $output .= '<p>No menu items found!</p>';
        $output .= '</div>';
        return $output;
    }
    
    $output .= '<h4>Menu Items:</h4>';
    $output .= '<ul>';
    
    foreach ($menu_items as $item) {
        $mega_enabled = get_post_meta($item->ID, '_bliss_mega_menu_enable', true);
        $mega_style = get_post_meta($item->ID, '_bliss_mega_menu_style', true);
        $mega_columns = get_post_meta($item->ID, '_bliss_mega_menu_columns', true);
        
        $output .= '<li>';
        $output .= str_repeat('— ', $item->menu_item_parent ? 1 : 0);
        $output .= '<strong>' . esc_html($item->title) . '</strong> (ID: ' . $item->ID . ')';
        
        if ($item->menu_item_parent == 0) {
            $output .= '<br>';
            $output .= str_repeat('&nbsp;', 4);
            $output .= 'Mega Menu: ' . ($mega_enabled ? 'YES' : 'NO');
            if ($mega_enabled) {
                $output .= ' | Style: ' . ($mega_style ?: 'services');
                $output .= ' | Columns: ' . ($mega_columns ?: '4');
            }
        }
        
        $output .= '</li>';
    }
    
    $output .= '</ul>';
    $output .= '</div>';
    
    return $output;
}

// Add to admin bar for easy access
add_action('admin_bar_menu', 'bliss_mega_menu_admin_bar_debug', 100);
function bliss_mega_menu_admin_bar_debug($admin_bar) {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    $admin_bar->add_menu(array(
        'id' => 'bliss-mega-debug',
        'title' => 'Debug Mega Menu',
        'href' => '#',
        'meta' => array(
            'onclick' => 'alert("Add [bliss_debug_menu] shortcode to any page to see menu debug info");return false;'
        )
    ));
}