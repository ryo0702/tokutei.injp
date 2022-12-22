<?php
require_once get_template_directory().'/nutrailcore/inc.php';

if (!function_exists('nutrail_theme_setup')) {
    require_once NUTRAIL_THEME_DIR.'/inc/nutrail_theme_setup.php';
}

function nutrail_load_theme_scripts(){
    $version = wp_get_theme()->get('Version');
    $inline_css = include NUTRAIL_THEME_DIR.'/inc/nutrail_inline_css.php';

    wp_enqueue_style('nutrail_main', get_theme_file_uri('/dist/css/style.min.css'), null, $version);
    if (!empty($inline_css)) {
        wp_add_inline_style('nutrail_main', $inline_css);
    }
    if (nutrail_is_amp()) {
        return;
    }
    wp_enqueue_script('nutrail_main', get_theme_file_uri('/dist/js/main.min.js'), null, $version, true);
    wp_enqueue_script('nutrail_runtime', get_theme_file_uri('/dist/js/runtime.min.js'), ['jquery-core'], $version, true);
}
add_action('wp_enqueue_scripts', 'nutrail_load_theme_scripts');

