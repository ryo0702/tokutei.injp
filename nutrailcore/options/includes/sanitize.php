<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

if (!function_exists('wpa_sanitize_multi_widget')) {
    function wpa_sanitize_multi_widget($data)
    {
        if (!empty($data['multi-widget'])) {
            $result = array();

            foreach ($data['multi-widget'] as $widget) {
                if (!wpa_array_search($result, 'id', $widget['id'])) {
                    $result[$widget['id']] = $widget;
                }
            }

            $data['multi-widget'] = array_values($result);
        }

        return $data;
    }

    add_filter('wpa_'.WPOPTIONKEY.'_save', 'wpa_sanitize_multi_widget');
}

/**
 *
 * Sanitize
 * Replace letter a to letter b
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_sanitize_replace_a_to_b')) {
    function wpa_sanitize_replace_a_to_b($value)
    {
        return str_replace('a', 'b', $value);
    }
}

/**
 *
 * Sanitize title
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_sanitize_title')) {
    function wpa_sanitize_title($value)
    {
        return sanitize_title($value);
    }
}
