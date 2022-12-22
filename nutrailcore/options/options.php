<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.

require_once dirname(__FILE__).'/classes/setup.class.php';
// require_once dirname(__FILE__).'/views/welcome.php';

/* Add options */
function wpa_register_meta_options()
{
    $match = apply_filters('wpa_register_options', array(
        'metabox'   => 'WPA_Metabox',
        /*
        'comment'   => 'WPA_Comment',
        'customize' => 'WPA_Customize',
        'menu'      => 'WPA_Menu',
        'profile'   => 'WPA_Profile',
        'taxonomy'  => 'WPA_Taxonomy',
        */
    ));

    /* Add options */
    foreach ($match as $prefix => $class) {
        $filename = "/config/array/{$prefix}.php";

        if (file_exists(get_stylesheet_directory().$filename)) {
            include_once get_stylesheet_directory().$filename;
        } elseif (file_exists(get_template_directory().$filename)) {
            include_once get_template_directory().$filename;
        }

        if (!empty(${"array_{$prefix}"}) && is_array(${"array_{$prefix}"})) {
            $config = !empty(${"config_{$prefix}"}) ? ${"config_{$prefix}"} : null;

            if (in_array($prefix, array('options', 'shortcode', 'customize'))) {
                $class::instance($config, ${"array_{$prefix}"});
            } else {
                $class::instance(${"array_{$prefix}"});
            }
        }
    }
}

add_action('init', 'wpa_register_meta_options');

/* Add options */
function wpa_register_theme_options()
{
    $options = array();
    $parent  = glob(get_template_directory().'/config/options/*.php');
    $child   = glob(get_stylesheet_directory().'/config/options/*.php');
    $path    = array_merge($parent, $child);
    if (!empty($path)) {
        foreach ($path as $option_path) {
            $filename           = str_replace('.php', '', wp_basename($option_path));
            $options[$filename] = $option_path;
        }
    }
    /* Add options */
    if (!empty($options)) {
        foreach ($options as $prefix => $option_path) {
            include_once $option_path;
            if (!empty($array_options) && is_array($array_options)) {
                $config = !empty($config_options) ? $config_options : null;
                WPA_Options::instance($config, $array_options);
            }
        }
    }
}

add_action('init', 'wpa_register_theme_options');

/* Add widgets */
function wpa_register_custom_widget()
{
    $widgets = array();
    $parent  = glob(get_template_directory().'/config/widget/*.php');
    $child   = glob(get_stylesheet_directory().'/config/widget/*.php');
    $path    = array_merge($parent, $child);
    foreach ($path as $widget_path) {
        $filename          = str_replace('.php', '', wp_basename($widget_path));
        $classes           = implode('_', array_map('ucfirst', explode('-', $filename)));
        $widgets[$classes] = $widget_path;
    }
    if (!empty($widgets)) {
        $wp_widget_factory = new WP_Widget_Factory();
        global $wp_widget_factory;

        foreach ($widgets as $classes => $widget_path) {
            if (!class_exists($classes)) {
                include_once $widget_path;
                if (class_exists($classes)) {
                    $wp_widget_factory->register($classes);
                }
            }
        }
    }
}

//add_action('widgets_init', 'wpa_register_custom_widget');

function wpa_save_page_widget($post_ID, $post)
{
    if ($post->post_type == 'page') {
        $slug           = get_post_field('post_name', $post_ID);
        $widget_page    = get_post_meta($post_ID, 'widget-page-enable', true);
        $widget_content = get_post_meta($post_ID, 'widget-page-content', true);
        if ($widget_page == 'enabled' && empty($widget_content)) {
            wpa_update_multi_widgets($post_ID);
            update_post_meta($post_ID, 'widget-page-content', "widget-page-$slug");
        }
    }
}

//add_action('wp_after_insert_post', 'wpa_save_page_widget', 10, 2);

function wpa_delete_post_widget($post_ID, $post)
{
    if ($post->post_type == 'page') {
        $slug          = str_replace('__trashed', '', $post->post_name);
        $theme_options = get_option(WPOPTIONKEY);
        $widgets       = !empty($theme_options['multi-widget']) ? $theme_options['multi-widget'] : array();
        foreach ($widgets as $key => $widget) {
            if ($widget['id'] == "widget-page-$slug") {
                unset($widgets[$key]);
            }
        }
        $theme_options['multi-widget'] = $widgets;
        // save options
        update_option(WPOPTIONKEY, $theme_options);
    }
}

//add_action('before_delete_post', 'wpa_delete_post_widget', 10, 2);


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wpa_register_widgets_sidebar()
{
    $shared_args = array(
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '<span class="arrow"></span></h2>',
    );

    $sidebars = array(
        array(
            'name'        => esc_html__('Sidebar', 'nutrail'),
            'id'          => 'widget-sidebar',
            'description' => esc_html__('Place the widget in the sidebar', 'nutrail'),
        ),
    );

    foreach ($sidebars as $sidebar) {
        register_sidebar(
            array_merge($shared_args, $sidebar)
        );
    }
}

add_action('widgets_init', 'wpa_register_widgets_sidebar');

/**
 * track view count
 */
function wpa_set_track_post_view()
{
    global $post;

    if (is_singular() && !empty($post->ID)) {
        $count = absint(get_post_meta($post->ID, 'post_views_count', true));

        if (!empty($count)) {
            update_post_meta($post->ID, 'post_views_count', 0);
        } else {
            $count++;
            update_post_meta($post->ID, 'post_views_count', $count);
        }
    }
}

add_action('template_redirect', 'wpa_set_track_post_view');