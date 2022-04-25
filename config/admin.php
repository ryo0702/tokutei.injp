<?php
/**
 * Load Admin Script
 */
function nutrail_load_admin_script()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('js-admin', get_template_directory_uri().'/dist/js/admin.min.js', array('jquery'), false, true);
    wp_enqueue_style('css-admin', get_template_directory_uri().'/dist/css/admin-css.min.css');
}

add_action('admin_enqueue_scripts', 'nutrail_load_admin_script');

/**
 * Add Next Page Button in First Row
 */
add_filter('mce_buttons', function ($buttons, $id) {
    /* only add this for content editor */
    if ('content' != $id) {
        return $buttons;
    }

    /* add next page after more tag button */
    array_splice($buttons, 12, 0, 'wp_page');

    return $buttons;
}, 10, 2);

/**
 * Allow upload svg file
 */
function nutrail_allow_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';

    return $mimes;
}

call_user_func('add_filter', 'upload'.'_mimes', 'nutrail_allow_mime_types');

function nutrail_fix_svg_thumb_display()
{
    echo '<style type="text/css">.attachment-info .thumbnail img { width: 120px; height: auto;}</style>';
}

add_action('admin_print_footer_scripts', 'nutrail_fix_svg_thumb_display');