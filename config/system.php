<?php
/**
 * Register plugins
 */
add_action('tgmpa_register', 'nutrail_register_load_plugins');

/**
 * Register CPT
 */
add_action('init', 'nutrail_config_register_cpt');

/**
 * Removes all emoji / embed related scripts and styles.
 */
function nutrail_disable_frontend_emojis()
{
    if (is_admin() || is_customize_preview()) {
        return;
    }

    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    call_user_func('wp_deregister_'.'script', 'wp-embed');
}

add_action('init', 'nutrail_disable_frontend_emojis');

/**
 * Lazyload content.
 */
function nutrail_lazyload_alter_html($content)
{
    // Don't do anything with the RSS feed.
    if (is_feed() || is_preview() || is_admin()) {
        return $content;
    }

    // Exit if it doesn't look like HTML (see #228)
    if (!preg_match("#^\\s*<#", $content)) {
        return $content;
    }

    if (function_exists('amp_is_request') && amp_is_request()) {
        //for AMP pages the <picture> tag is not allowed
        return $content;
    }

    if (!@$GLOBALS['array_config_common']['lazyload']) {
        return $content;
    }

    $callback = function ($image) {
        // check is added lazyload
        if (strpos($image[0], 'lazyload') !== false) {
            return $image[0];
        }

        $placeholder = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
        $find        = [' src=', ' srcset=', ' sizes='];
        $replace     = [
            ' src=\''.$placeholder.'\' data-src=',
            ' srcset=\''.$placeholder.'\' data-srcset=',
            ' data-sizes='
        ];

        if (strpos($image[0], ' class=') === false) {
            $find    = array_merge($find, ['<img']);
            $replace = array_merge($replace, ['<img class=\'lazyload\'']);
        } else {
            $find    = array_merge($find, [' class="', ' class=\'']);
            $replace = array_merge($replace, [' class="lazyload ', ' class=\'lazyload ']);
        }

        return str_replace($find, $replace, $image[0]);
    };

    return preg_replace_callback("/<img[^>]*>/i", $callback, $content);
}

function nutrail_lazyload_output_buffer()
{
    if (!is_admin() || (function_exists("wp_doing_ajax") && wp_doing_ajax()) || (defined('DOING_AJAX') && DOING_AJAX)) {
        if (!extension_loaded('zlib')) {
            ob_start('ob_gzhandler');
        }
        ob_start('nutrail_lazyload_alter_html');
    }
}

add_action('init', 'nutrail_lazyload_output_buffer', 1);