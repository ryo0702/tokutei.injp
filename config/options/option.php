<?php if (!defined('ABSPATH')) {
    die;
}

// Include
include locate_template('/config/array/options.php');

// Setting Options Menu
$config_options = array(
    'option_name'      => WPOPTIONKEY,
    'menu_title'       => esc_html__('Site settings', 'nutrail'),
    'menu_type'        => 'menu',
    'menu_slug'        => 'admin_options',
    'menu_parent'      => '',
    'menu_position'    => 25,
    'menu_icon'        => 'dashicons-wordpress',
    'show_search'      => true,
    'show_reset'       => true,
    'show_footer'      => false,
    'show_bar_menu'    => true,
    'show_all_options' => true,
    'sticky_header'    => true,
    'framework_title'  => esc_html__('Site settings', 'nutrail'),
);