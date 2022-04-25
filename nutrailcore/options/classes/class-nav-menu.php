<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/**
 *
 * Menu Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Menu')) {
    class WPA_Menu extends WPA_Abstract
    {
        // constants
        public $options  = array();
        public $sections = array();
        public $errors   = array();
        public $abstract = 'nav-menus';

        // run menu construct
        public function __construct($sections)
        {
            // Get options menu
            $this->sections = apply_filters('wpa_options_menu', $sections);

            // Actions menu
            add_action('wp_nav_menu_item_custom_fields', array(&$this, 'add_menu_item_fields'), 10, 5);
            add_action('wp_update_nav_menu_item', array(&$this, 'update_custom_nav_fields'), 10, 3);

            // wp enqueue for typography and output css
            parent::__construct();
        }

        // instance
        public static function instance($options = array())
        {
            return new self($options);
        }

        // add menu content
        public function add_menu_item_fields($item_id, $item, $depth, $args, $id)
        {
            if (!empty($this->sections)) {
                foreach ($this->sections as $section) {
                    if (empty($section['fields'])) {
                        continue;
                    }
                    if (!empty($section['object']) && $section['object'] != $item->object) {
                        continue;
                    }
                    if (!empty($section['type']) && $section['type'] != $item->type) {
                        continue;
                    }
                    if ($section['depth'] >= 0 && $depth > $section['depth']) {
                        continue;
                    }
                    echo '<div class="wpa-nav-menu-options">';
                    echo '<div class="wpa-fields">';
                    foreach ($section['fields'] as $field) {
                        $key                                   = $field['id'];
                        $field['id']                           = "{$field['id']}[$item_id]";
                        $field['attributes']['data-depend-id'] = $key;
                        echo WPA::field($field, get_post_meta($item_id, $key, true));
                    }
                    echo '</div>';
                    echo '</div>';
                }
            }
        }

        // save menu
        public function update_custom_nav_fields($menu_id, $menu_item_db_id, $args)
        {
            if (!empty($this->sections)) {
                foreach ($this->sections as $section) {
                    if (!empty($section['fields'])) {
                        foreach ($section['fields'] as $field) {
                            // Check if element is properly sent
                            if (!empty($_REQUEST[$field['id']][$menu_item_db_id])) {
                                update_post_meta($menu_item_db_id, $field['id'], $_REQUEST[$field['id']][$menu_item_db_id]);
                            }
                        }
                    }
                }
            }
        }
    }
}
