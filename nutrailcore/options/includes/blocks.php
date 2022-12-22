<?php
/* Register post menu */
call_user_func('register'.'_post_type', 'blocks', [
    'labels'              => array(
        'add_new_item'       => __('Add block', 'nutrail'),
        'name'               => __('Blocks builder', 'nutrail'),
        'singular_name'      => __('Block', 'nutrail'),
        'edit_item'          => __('Edit Block', 'nutrail'),
        'view_item'          => __('View Block', 'nutrail'),
        'search_items'       => __('Search Blocks', 'nutrail'),
        'not_found'          => __('No Blocks found', 'nutrail'),
        'not_found_in_trash' => __('No Blocks found in Trash', 'nutrail'),
    ),
    'public'              => true,
    'has_archive'         => false,
    'show_in_menu'        => 'wpa-welcome',
    'supports'            => array('thumbnail', 'editor', 'title', 'revisions', 'custom-fields'),
    'show_in_nav_menus'   => true,
    'exclude_from_search' => true,
    'rewrite'             => array('slug' => ''),
    'publicly_queryable'  => true,
    'show_ui'             => true,
    'query_var'           => true,
    'capability_type'     => 'page',
    'hierarchical'        => true,
    'menu_position'       => null,
    'show_in_rest'        => true,
    'menu_icon'           => 'dashicons-tagcloud',
]);

function wpa_edit_blocks_columns()
{
    $columns = array(
        'cb'        => '<input type="checkbox" />',
        'title'     => __('Title', 'nutrail'),
        'shortcode' => __('Shortcode', 'nutrail'),
        'date'      => __('Date', 'nutrail'),
    );

    return $columns;
}

add_filter('manage_edit-blocks_columns', 'wpa_edit_blocks_columns');

function wpa_manage_blocks_columns($column, $post_id)
{
    $post_data = get_post($post_id, ARRAY_A);
    $slug      = $post_data['post_name'];
    switch ($column) {
        case 'shortcode':
            echo "<input type='text' value='[block id=\"{$slug}\"]'>";
            break;
    }
}

add_action('manage_blocks_posts_custom_column', 'wpa_manage_blocks_columns', 10, 2);


/**
 * Disable gutenberg support for now.
 *
 * @param bool $use_block_editor Whether the post type can be edited or not. Default true.
 * @param string $post_type The post type being checked.
 *
 * @return bool
 */
function wpa_blocks_disable_gutenberg($use_block_editor, $post_type)
{
    return $post_type === 'blocks' ? false : $use_block_editor;
}

add_filter('use_block_editor_for_post_type', 'wpa_blocks_disable_gutenberg', 10, 2);
add_filter('gutenberg_can_edit_post_type', 'wpa_blocks_disable_gutenberg', 10, 2);


/**
 * Update block preview URL
 */
function wpa_block_scripts()
{
    global $typenow;

    if ('blocks' == $typenow && isset($_GET["post"])) {
        ?>
        <script>
            jQuery(document).ready(function ($) {
                const block_id = $('input#post_name').val();
                $('#submitdiv').after(
                    '<div class="postbox">' +
                    '<div class="postbox-header"><h2 class="hndle">Shortcode</h2></div>' +
                    '<div class="inside"><p><input id="wpa-block-shortcode" style="width:100%" type="text" value=""></p></div>' +
                    '</div>'
                );
                document.getElementById("wpa-block-shortcode").value = '[block id="' + block_id + '"]';
            })
        </script>
        <?php
    }
}

add_action('admin_head', 'wpa_block_scripts');

function wpa_block_shortcode($atts, $content = null)
{
    global $post;

    extract(shortcode_atts(array(
        'id' => '',
    ), $atts));

    // Abort if ID is empty.
    if (empty ($id)) {
        return '<p><mark>No block ID is set</mark></p>';
    }

    if (is_woocommerce_activated() && is_shop()) {
        $post = get_post(wc_get_page_id('shop'));
    }

    if (is_home()) {
        $post = get_post(get_option('page_for_posts'));
    }

    $post_id  = wpa_get_block_id($id);
    $the_post = $post_id ? get_post($post_id, OBJECT, 'display') : null;

    if ($the_post) {
        $html = $the_post->post_content;

        if (empty($html)) {
            $html = '<p class="lead shortcode-error">Open this to add and edit content</p>';
        }

        // Add edit link for admins.
        if (isset($post) && current_user_can('edit_pages') && !is_customize_preview()) {
            $edit_link         = get_edit_post_link($post_id, 'raw');
            $edit_link_backend = admin_url('post.php?post='.$post_id.'&action=edit');
            $html              = '<div class="block-edit-link" data-title="Edit Block: '.get_the_title($post_id).'" data-backend="'.esc_url($edit_link_backend).'" data-link="'.esc_url($edit_link).'"></div>'.$html.'';
        }
    } else {
        $html = '<p class="text-center"><mark>Block <b>"'.esc_html($id).'"</b> not found</mark></p>';
    }

    return do_shortcode($html);
}

call_user_func('add'.'_shortcode', 'block', 'wpa_block_shortcode');

function wpa_get_block_id($post_id)
{
    global $wpdb;

    if (empty ($post_id)) {
        return null;
    }

    // Get post ID if using post_name as id attribute.
    if (!is_numeric($post_id)) {
        $post_id = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT ID FROM $wpdb->posts WHERE post_type = 'blocks' AND post_name = %s",
                $post_id
            )
        );
    }

    // Polylang support.
    if (function_exists('pll_get_post')) {
        if ($lang_id = pll_get_post($post_id)) {
            $post_id = $lang_id;
        }
    }

    // WPML Support.
    if (function_exists('wpml_object_id_filter')) {
        if ($lang_id = wpml_object_id_filter($post_id, 'blocks', false, ICL_LANGUAGE_CODE)) {
            $post_id = $lang_id;
        }
    }

    return $post_id;
}

if (!function_exists('wpa_blocks_categories')) {
    /**
     * Add block categories support
     */
    function wpa_blocks_categories()
    {
        call_user_func('register'.'_taxonomy', 'block_cat', ['blocks'], [
            'hierarchical'      => true,
            'public'            => false,
            'show_ui'           => true,
            'show_in_nav_menus' => true,
        ]);

    }

    // Hook into the 'init' action
    // add_action('init', 'wpa_blocks_categories', 0);
}
