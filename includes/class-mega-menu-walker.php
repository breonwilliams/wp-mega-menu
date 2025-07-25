<?php
/**
 * Custom Walker for Bliss Mega Menu
 * Automatically creates mega menu structure based on hierarchy
 */

class Bliss_Mega_Menu_Walker extends Walker_Nav_Menu {
    
    private $has_mega_menu = false;
    private $in_mega_menu = false;
    
    /**
     * Starts the list before the elements are added
     */
    public function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        
        // Starting a mega menu dropdown
        if ($depth === 0 && $this->has_mega_menu) {
            $output .= "\n$indent<ul class=\"sub-menu mega-menu\" data-bliss-mega=\"true\">\n";
            $output .= "$indent\t<div class=\"mega-content\">\n";
            $this->in_mega_menu = true;
        } 
        // Service children list (depth 2 in mega menu)
        elseif ($depth === 2 && $this->in_mega_menu) {
            $output .= "\n$indent<ul class=\"service-children\">\n";
        }
        // Regular sub menu
        else {
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        }
    }
    
    /**
     * Ends the list after the elements are added
     */
    public function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        
        if ($depth === 0 && $this->in_mega_menu) {
            $output .= "$indent\t</div>\n";
            $this->in_mega_menu = false;
        }
        
        $output .= "$indent</ul>\n";
    }
    
    /**
     * Starts the element output
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Check if this item has children
        $has_children = in_array('menu-item-has-children', $classes);
        
        // Auto-detect mega menu based on depth of children
        if ($depth === 0 && $has_children) {
            // Check if this menu item has grandchildren (depth 2+ items)
            $this->has_mega_menu = $this->has_grandchildren($item->ID);
        }
        
        // Build attributes
        $atts = array();
        $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
        $atts['href'] = !empty($item->url) ? $item->url : '';
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $item_output = $args->before ?? '';
        
        // Depth 0: Top level menu items
        if ($depth === 0) {
            $classes[] = 'menu-item';
            
            if ($has_children) {
                $classes[] = 'menu-item-has-children';
            }
            
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
            
            $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';
            
            $output .= $indent . '<li' . $id . $class_names .'>';
            
            if ($has_children) {
                $item_output .= '<div class="menu-header">';
                $item_output .= '<a'. $attributes .' class="menu-link">';
                $item_output .= ($args->link_before ?? '') . apply_filters('the_title', $item->title, $item->ID) . ($args->link_after ?? '');
                $item_output .= '</a>';
                $item_output .= '<button class="mobile-submenu-toggle"></button>';
                $item_output .= '</div>';
            } else {
                $item_output .= '<a'. $attributes .'>';
                $item_output .= ($args->link_before ?? '') . apply_filters('the_title', $item->title, $item->ID) . ($args->link_after ?? '');
                $item_output .= '</a>';
            }
        }
        // Depth 1: Column headers in mega menu
        elseif ($depth === 1 && $this->in_mega_menu) {
            // Start mega column
            $output .= $indent . '<div class="mega-column">' . "\n";
            
            // Section header
            $item_output .= $indent . "\t" . '<a'. $attributes .' class="section-header">';
            $item_output .= ($args->link_before ?? '') . apply_filters('the_title', $item->title, $item->ID) . ($args->link_after ?? '');
            $item_output .= '</a>' . "\n";
            
            // If no children, wrap in service group
            if (!$has_children) {
                $output .= $item_output;
                $output .= $indent . "\t" . '<div class="service-group">' . "\n";
                $output .= $indent . "\t</div>\n";
                $output .= $indent . "</div>\n"; // Close mega-column
                return; // Skip normal processing
            }
        }
        // Depth 2: Service groups in mega menu
        elseif ($depth === 2 && $this->in_mega_menu) {
            if (!$has_children) {
                // Single service link without children
                $output .= $indent . '<div class="service-group">' . "\n";
                $output .= $indent . "\t" . '<ul class="service-children">' . "\n";
                $output .= $indent . "\t\t" . '<li class="service-child">';
                $item_output .= '<a'. $attributes .'>';
                $item_output .= ($args->link_before ?? '') . apply_filters('the_title', $item->title, $item->ID) . ($args->link_after ?? '');
                $item_output .= '</a>';
                $output .= $item_output;
                $output .= '</li>' . "\n";
                $output .= $indent . "\t" . '</ul>' . "\n";
                $output .= $indent . '</div>' . "\n";
                return; // Skip normal processing
            } else {
                // Service group with children
                $output .= $indent . '<div class="service-group">' . "\n";
                $item_output .= $indent . "\t" . '<a'. $attributes .' class="service-group-link">';
                $item_output .= ($args->link_before ?? '') . apply_filters('the_title', $item->title, $item->ID) . ($args->link_after ?? '');
                $item_output .= '</a>';
            }
        }
        // Depth 3: Individual service items
        elseif ($depth === 3 && $this->in_mega_menu) {
            $classes[] = 'service-child';
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
            
            $output .= $indent . '<li' . $class_names .'>';
            $item_output .= '<a'. $attributes .'>';
            $item_output .= ($args->link_before ?? '') . apply_filters('the_title', $item->title, $item->ID) . ($args->link_after ?? '');
            $item_output .= '</a>';
        }
        // Regular menu items (for depth 1 without mega menu)
        else {
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
            
            $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';
            
            $output .= $indent . '<li' . $id . $class_names .'>';
            $item_output .= '<a'. $attributes .'>';
            $item_output .= ($args->link_before ?? '') . apply_filters('the_title', $item->title, $item->ID) . ($args->link_after ?? '');
            $item_output .= '</a>';
        }
        
        $item_output .= $args->after ?? '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    /**
     * Ends the element output
     */
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        
        if ($depth === 0) {
            $output .= "</li>\n";
            $this->has_mega_menu = false;
        }
        elseif ($depth === 1 && $this->in_mega_menu && $has_children) {
            $output .= "</div>\n"; // Close mega-column
        }
        elseif ($depth === 2 && $this->in_mega_menu && $has_children) {
            $output .= "</div>\n"; // Close service-group
        }
        elseif ($depth === 3 && $this->in_mega_menu) {
            $output .= "</li>\n";
        }
        elseif (!($depth === 1 && $this->in_mega_menu) && !($depth === 2 && $this->in_mega_menu)) {
            $output .= "</li>\n";
        }
    }
    
    /**
     * Check if a menu item has grandchildren
     */
    private function has_grandchildren($parent_id) {
        global $wpdb;
        
        // Get all menu items
        $menu_items = $wpdb->get_results($wpdb->prepare("
            SELECT p1.ID 
            FROM {$wpdb->posts} p1
            INNER JOIN {$wpdb->postmeta} pm1 ON p1.ID = pm1.post_id
            INNER JOIN {$wpdb->postmeta} pm2 ON p1.ID = pm2.post_id
            WHERE p1.post_type = 'nav_menu_item'
            AND pm1.meta_key = '_menu_item_menu_item_parent'
            AND pm1.meta_value IN (
                SELECT p2.ID 
                FROM {$wpdb->posts} p2
                INNER JOIN {$wpdb->postmeta} pm3 ON p2.ID = pm3.post_id
                WHERE p2.post_type = 'nav_menu_item'
                AND pm3.meta_key = '_menu_item_menu_item_parent'
                AND pm3.meta_value = %d
            )
            LIMIT 1
        ", $parent_id));
        
        return !empty($menu_items);
    }
}