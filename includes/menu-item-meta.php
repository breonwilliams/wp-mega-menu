<?php
/**
 * Menu Item Meta Fields for Mega Menu Configuration
 */

// Add custom fields to menu items
add_action('wp_nav_menu_item_custom_fields', 'bliss_mega_menu_item_custom_fields', 10, 5);
function bliss_mega_menu_item_custom_fields($item_id, $item, $depth, $args, $current_object_id) {
    // Only show on top-level items
    if ($depth !== 0) {
        return;
    }
    
    $enable_mega = get_post_meta($item_id, '_bliss_mega_menu_enable', true);
    $columns = get_post_meta($item_id, '_bliss_mega_menu_columns', true) ?: 4;
    $style = get_post_meta($item_id, '_bliss_mega_menu_style', true) ?: 'services';
    ?>
    <p class="field-bliss-mega-menu description description-wide">
        <label for="edit-menu-item-bliss-mega-menu-<?php echo $item_id; ?>">
            <input type="checkbox" id="edit-menu-item-bliss-mega-menu-<?php echo $item_id; ?>" 
                   name="menu-item-bliss-mega-menu[<?php echo $item_id; ?>]" 
                   value="1" <?php checked($enable_mega, 1); ?> />
            <?php _e('Enable Mega Menu for this item', 'bliss-mega-menu'); ?>
        </label>
    </p>
    <p class="field-bliss-mega-style description description-wide" <?php echo !$enable_mega ? 'style="display:none;"' : ''; ?>>
        <label for="edit-menu-item-bliss-style-<?php echo $item_id; ?>">
            <?php _e('Mega Menu Style:', 'bliss-mega-menu'); ?>
            <select id="edit-menu-item-bliss-style-<?php echo $item_id; ?>" 
                    name="menu-item-bliss-style[<?php echo $item_id; ?>]">
                <option value="services" <?php selected($style, 'services'); ?>>Services (Default)</option>
                <option value="areas" <?php selected($style, 'areas'); ?>>Service Areas</option>
            </select>
        </label>
    </p>
    <p class="field-bliss-mega-columns description description-wide" <?php echo !$enable_mega ? 'style="display:none;"' : ''; ?>>
        <label for="edit-menu-item-bliss-columns-<?php echo $item_id; ?>">
            <?php _e('Number of columns:', 'bliss-mega-menu'); ?>
            <select id="edit-menu-item-bliss-columns-<?php echo $item_id; ?>" 
                    name="menu-item-bliss-columns[<?php echo $item_id; ?>]">
                <option value="2" <?php selected($columns, 2); ?>>2</option>
                <option value="3" <?php selected($columns, 3); ?>>3</option>
                <option value="4" <?php selected($columns, 4); ?>>4</option>
                <option value="5" <?php selected($columns, 5); ?>>5</option>
            </select>
        </label>
    </p>
    <?php
}

// Save custom field values
add_action('wp_update_nav_menu_item', 'bliss_mega_menu_update_custom_fields', 10, 2);
function bliss_mega_menu_update_custom_fields($menu_id, $menu_item_db_id) {
    // Enable mega menu
    if (isset($_POST['menu-item-bliss-mega-menu'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_bliss_mega_menu_enable', 1);
    } else {
        delete_post_meta($menu_item_db_id, '_bliss_mega_menu_enable');
    }
    
    // Mega menu style
    if (isset($_POST['menu-item-bliss-style'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_bliss_mega_menu_style', sanitize_text_field($_POST['menu-item-bliss-style'][$menu_item_db_id]));
    }
    
    // Number of columns
    if (isset($_POST['menu-item-bliss-columns'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_bliss_mega_menu_columns', intval($_POST['menu-item-bliss-columns'][$menu_item_db_id]));
    }
}

// Add JavaScript to show/hide column selector
add_action('admin_footer', 'bliss_mega_menu_admin_footer_script');
function bliss_mega_menu_admin_footer_script() {
    if (get_current_screen()->id !== 'nav-menus') {
        return;
    }
    ?>
    <script>
    jQuery(document).ready(function($) {
        // Toggle mega menu fields visibility
        $(document).on('change', 'input[id^="edit-menu-item-bliss-mega-menu-"]', function() {
            var $settings = $(this).closest('.menu-item-settings');
            var $styleField = $settings.find('.field-bliss-mega-style');
            var $columnField = $settings.find('.field-bliss-mega-columns');
            
            if ($(this).is(':checked')) {
                $styleField.slideDown();
                $columnField.slideDown();
            } else {
                $styleField.slideUp();
                $columnField.slideUp();
            }
        });
    });
    </script>
    <?php
}

// Add admin styles
add_action('admin_head-nav-menus.php', 'bliss_mega_menu_admin_styles');
function bliss_mega_menu_admin_styles() {
    ?>
    <style>
    .field-bliss-mega-menu,
    .field-bliss-mega-columns {
        padding: 10px;
        background: #f0f0f1;
        border-left: 4px solid #2271b1;
        margin: 10px 0;
    }
    </style>
    <?php
}