<?php
/**
 * nutrail_theme_setup.php
 *
 * This file is the file to be read if the function nutrail_theme_setup is not enable.
 *
 * @package WordPress
 * @subpackage NUTRAIL
 */

function nutrail_theme_setup()
{
    /**
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Next, use a find and replace
     * to change 'astra' to the name of your theme in all the template files.
     */
    load_theme_textdomain('nutrail', get_template_directory().'/languages');

    /**
     * Manage titles.
     */
    add_theme_support('title-tag');

    /**
     * Enable thumbnails.
     * It also sets the default thumbnail size.
     */
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1568, 9999);

    /**
     * Add nav-menu.
     */
    register_nav_menus(array(
        'menu_main'                 => esc_html__('Main Menu', 'nutrail'),
        'menu_footer'               => esc_html__('Footer Menu', 'nutrail'),
        'menu_footer_site_overview' => esc_html__('Footer Menu (Site Overview)', 'nutrail'),
    ));

    /**
     * Add page excerpt.
     */
    add_post_type_support('page', 'excerpt');

    /**
     * Support amp.
     */
    add_theme_support('amp', array(
        'paired' => true,
    ));

    /**
     * Rank Math Breadcrumb.
     */
    add_theme_support('rank-math-breadcrumbs');

    /**
     * Support block.
     */
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');

    // Switch default core markup for search form, comment form, and comments.
    // to output valid HTML5.
    // Added a new value in HTML5 array 'navigation-widgets' as this was introduced in WP5.5 for better accessibility.
    add_theme_support(
        'html5',
        array(
            'navigation-widgets',
            'search-form',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    /**
     * Other config.
     */
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('customize-selective-refresh-widgets');

    // Remove Template Editor support until WP 5.9 since more Theme Blocks are going to be introduced.
    remove_theme_support('block-templates');
}

add_action('after_setup_theme', 'nutrail_theme_setup');

/**
 * Remove svg
 */
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

/**
 * Changing excerpt more
 */
function nutrail_excerpt_more($output_filter)
{
    if (is_admin() && !wp_doing_ajax()) {
        return $output_filter;
    }

    return '...';
}

add_filter('excerpt_more', 'nutrail_excerpt_more', 11);

/**
 * Changing switch theme
 */
function nutrail_switch_theme()
{
    $theme_options = get_option(WPOPTIONKEY);
    if (!empty($theme_options['config-common']['colors'])) {
        unset($theme_options['config-common']['colors']);
        update_option(WPOPTIONKEY, $theme_options);
    }
}

add_action('after_switch_theme', 'nutrail_switch_theme');

/**
 * Add async to javascript file for performance
 */
function nutrail_script_async($tag, $handle)
{
    if (is_admin()) {
        return $tag;
    }

    $defer = [
        'nutrail_main',
        'nutrail_runtime',
        'wp-embed',
    ];

    if (in_array($handle, $defer)) {
        return str_replace('<script', '<script defer', $tag);
    }

    return $tag;
}

add_action('script_loader_tag', 'nutrail_script_async', 30, 2);

/**
 * dequeue scripts
 */
function nutrail_dequeue_scripts()
{
    $has_block = false;
    $template  = get_page_template_slug();

    if (is_single() || is_page()) {
        $has_block = true;
    }
    if (is_page() && !empty($template)) {
        $has_block = false;
    }
    if (is_front_page()) {
        $has_block = false;
    }
    if (!$has_block) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('global-styles');
    }
}

add_action('wp_enqueue_scripts', 'nutrail_dequeue_scripts', 999);

/**
 * add carets to menu item
 */
function nutrail_carets_menu_items($item_output, $item, $depth, $args)
{
    if ($depth == 0 && !empty($item->classes) && in_array('menu-item-has-children', $item->classes)) {
        // @note Why not a <button>?
        $expand_attrs = ' class="carets" role="button" tabindex="0"';

        // Add toggle behavior in AMP.
        if (nutrail_is_amp()) {
            $expand_attrs .= sprintf(
                ' id="%s" on="%s"',
                esc_attr("carets-{$item->ID}"),
                esc_attr("tap:menu-item-{$item->ID}.toggleClass(class='open-submenu'),carets-{$item->ID}.toggleClass(class='active')")
            );
        }

        $item_output = "<span {$expand_attrs}></span>{$item_output}";
    }

    return $item_output;
}