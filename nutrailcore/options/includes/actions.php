<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/**
 *
 * Get icons from admin ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_get_icons')) {
    function wpa_get_icons()
    {
        $content    = '';
        $nav        = '';
        $icon_lists = [];
        $nonce      = (!empty($_POST['nonce'])) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';

        if (!wp_verify_nonce($nonce, 'wpa_icon_nonce')) {
            wp_send_json_error(array(
                'error' => esc_html__('Error: Nonce verification has failed. Please try again.', 'nutrail')
            ));
        }

        ob_start();

        $icon_library = (WPA::get_config('fontawesome') == 'fa4') ? 'fa4' : 'fa5';

        WPA::include_plugin_file('fields/icon/'.$icon_library.'-icons.php');

        if ($icon_library == 'fa5' && WPA::get_config('fa4_support') == 1) {
            WPA::include_plugin_file('fields/icon/fa4-icons.php');
            $icon_lists = call_user_func('wpa_get_fa4_icons');
        }

        $icon_lists = apply_filters('wpa_field_icon_add_icons', array_merge($icon_lists,
            call_user_func('wpa_get_'.$icon_library.'_icons')
        ));

        if (!empty($icon_lists)) {
            foreach ($icon_lists as $key => $list) {

                $active         = '';
                $class_icon     = 'fa-folder';
                $sanitize_class = strtolower(sanitize_html_class($list['title']));
                $class          = $sanitize_class;

                if ($key > 0) {
                    $class .= ' hidden';
                } else {
                    $active     = 'wpa-section-active';
                    $class_icon = 'fa-folder-open';
                }

                $nav .= '<li><a href="#" data-active=".'.esc_attr($sanitize_class).'" class="'.esc_attr($active).'">';
                $nav .= '<span class="wpa-tab-icon fa '.esc_attr($class_icon).'"></span>'.esc_html($list['title']).'';
                $nav .= '</a></li>';

                $content .= '<div class="'.esc_attr($class).'">';

                foreach ($list['icons'] as $icon) {
                    $content .= '<i title="'.esc_attr($icon).'" class="'.esc_attr($icon).'"></i>';
                }

                $content .= '</div>';
            }
        } else {
            $content .= '<div class="wpa-text-error">'.esc_html__('No data provided by developer', 'nutrail').'</div>';
        }

        wp_send_json_success(array(
            'nav'     => $nav,
            'content' => $content,
        ));

    }

    add_action('wp_ajax_wpa-get-icons', 'wpa_get_icons');
}

/**
 * Add admin notice
 */
if (!function_exists('wpa_admin_flash_notices')) {
    function wpa_admin_flash_notices()
    {
        $notices = get_option('wpa_flash_notices', array());

        // Iterate through our notices to be displayed and print them.
        foreach ($notices as $notice) {
            printf('<div class="notice notice-%1$s %2$s">%3$s</div>',
                $notice['type'],
                $notice['dismissible'],
                $notice['notice']
            );
        }

        // Now we reset our options to prevent notices being displayed forever.
        if (!empty($notices)) {
            delete_option('wpa_flash_notices');
        }
    }

    add_action('admin_notices', 'wpa_admin_flash_notices', 30);
}

/**
 * Add widget to page
 */
if (!function_exists('wpa_remove_inactive_sidebar')) {
    function wpa_remove_inactive_sidebar()
    {
        $nonce = (!empty($_GET['nonce'])) ? sanitize_text_field(wp_unslash($_GET['nonce'])) : '';

        if (!wp_verify_nonce($nonce, 'wpa_backup_nonce')) {
            die(esc_html__('Error: Nonce verification has failed. Please try again.', 'nutrail'));
        }

        /** This action is documented in wp-admin/includes/ajax-actions.php */
        do_action('load-widgets.php'); // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores

        /** This action is documented in wp-admin/includes/ajax-actions.php */
        do_action('widgets.php'); // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores

        /** This action is documented in wp-admin/widgets.php */
        do_action('sidebar_admin_setup');

        // These are the widgets grouped by sidebar.
        $sidebars_widgets = wp_get_sidebars_widgets();
        $notice           = '';
        $count            = 0;

        foreach ($sidebars_widgets as $sidebar_id => $widgets) {
            if (!is_registered_sidebar($sidebar_id)) {
                $count++;
                $notice .= '<p>- '.$sidebar_id.'</p>';

                foreach ($widgets as $key => $widget_id) {
                    $pieces       = explode('-', $widget_id);
                    $multi_number = array_pop($pieces);
                    $id_base      = implode('-', $pieces);
                    $widget       = get_option('widget_'.$id_base);
                    unset($widget[$multi_number]);
                    update_option('widget_'.$id_base, $widget);
                    unset($sidebars_widgets['wp_inactive_widgets'][$key]);
                }

                $sidebars_widgets[$sidebar_id] = array();
            }
        }

        wp_set_sidebars_widgets($sidebars_widgets);

        $message = '<p><strong>'.$count.' sidebars has removed</strong></p>';
        $notices = array(
            array(
                'type'        => 'success',
                'dismissible' => '',
                'notice'      => $message.$notice,
            )
        );
        update_option('wpa_flash_notices', $notices);

        wp_send_json_success(admin_url('widgets.php'));
        wp_die();
    }

    add_action('wp_ajax_wpa-remove-inactive-sidebar', 'wpa_remove_inactive_sidebar');
}

/**
 * Add widget to page
 */
if (!function_exists('wpa_create_page_widgets')) {
    function wpa_create_page_widgets()
    {
        $options = !empty($_REQUEST['options']) ? json_decode(wp_unslash(trim($_REQUEST['options'])), true) : array();
        $nonce   = !empty($_REQUEST['nonce']) ? wp_unslash($_REQUEST['nonce']) : '';

        if (!wp_verify_nonce($nonce, 'wpa_callback_nonce')) {
            die(esc_html__('Error: Nonce verification has failed. Please try again.', 'nutrail'));
        }
        if (!empty($options[WPOPTIONKEY])) {
            $options = $options[WPOPTIONKEY];
        }

        $type         = !empty($options['select-type']) ? $options['select-type'] : '';
        $page_title   = !empty($options['select-page-title']) ? $options['select-page-title'] : 'Sample Page';
        $page_id      = !empty($options['select-page']) ? $options['select-page'] : '';
        $widget_id    = !empty($options['select-widget-set']) ? $options['select-widget-set'] : '';
        $template     = !empty($options['select-template']) ? $options['select-template'] : '';
        $is_frontpage = !empty($options['select-frontpage']) ? $options['select-frontpage'] : '';

        if ($type != 'existing') {
            // Insert the post into the database
            $page_id = wp_insert_post(array(
                'post_title'   => $page_title,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ));
        }

        $post   = get_post($page_id);
        $new_id = "widget-page-{$post->post_name}";

        // Update widgets
        wpa_update_multi_widgets($post);

        // update new widget
        if (file_exists(WPPRESETPATH.'/widgets/'.$widget_id.'.php')) {
            $data_widgets = include WPPRESETPATH.'/widgets/'.$widget_id.'.php';
            wpa_generate_import_widgets($data_widgets, $new_id);
        }

        // update postmeta
        update_post_meta($page_id, '_wp_page_template', $template);
        update_post_meta($page_id, 'widget-page-enable', 'enabled');
        update_post_meta($page_id, 'widget-page-content', $new_id);

        // update frontpage
        if ($is_frontpage == 'on') {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $page_id);
        }

        wp_send_json_success(add_query_arg(
            array(
                'url' => get_permalink($page_id)
            ),
            admin_url('customize.php')
        ));
    }

    add_action('wp_ajax_wpa-create-page-widgets', 'wpa_create_page_widgets');
}

/**
 * Generate export data
 *
 * @return string Export file contents
 * @since 0.1
 */
if (!function_exists('wpa_export_widgets')) {
    function wpa_export_widgets()
    {
        $nonce  = (!empty($_GET['nonce'])) ? sanitize_text_field(wp_unslash($_GET['nonce'])) : '';
        $unique = (!empty($_GET['unique'])) ? sanitize_text_field(wp_unslash($_GET['unique'])) : '';

        if (!wp_verify_nonce($nonce, 'wpa_backup_nonce')) {
            die(esc_html__('Error: Nonce verification has failed. Please try again.', 'nutrail'));
        }

        if (empty($unique)) {
            die(esc_html__('Error: Options unique id could not valid.', 'nutrail'));
        }

        global $wp_registered_sidebars;

        $notices = array();
        $widgets = wpa_generate_export_widgets();

        if (wp_mkdir_p(get_template_directory().'/export/options/')) {
            $options = get_option($unique);
            $options = wpa_export_media_options($options);
            $options = preg_replace('(\d+\s=>)', "", var_export($options, true));
            call_user_func('file_put'.'_contents', get_template_directory().'/export/options/theme-options.php', '<?php '.PHP_EOL.'return '.$options.';');
        }
        if (!empty($widgets)) {
            wp_mkdir_p(get_template_directory().'/export/widgets/');
        }
        foreach ($widgets as $id => $widget) {
            if (!empty($wp_registered_sidebars[$id]['name'])) {
                $title       = $wp_registered_sidebars[$id]['name'];
                $widget      = wpa_export_media_options($widget);
                $widget_data = preg_replace('(\d+\s=>)', "", var_export(array($id => $widget), true));
                call_user_func('file_put'.'_contents',get_template_directory().'/export/widgets/'.$id.'.php', '<?php '.PHP_EOL.' /* Name: '.$title.' */ return '.$widget_data.';');
            } else {
                unregister_sidebar($id);
            }
        }

        $notices[] = array(
            'type'        => 'success',
            'dismissible' => '',
            'notice'      => '<p><strong>Create file Successful</strong></p>',
        );
        update_option('wpa_flash_notices', $notices);

        // Stop execution.
        wp_safe_redirect(admin_url('/admin.php?page=admin_options'));
        exit;

    }

    add_action('wp_ajax_wpa-export-widgets', 'wpa_export_widgets');
}

/**
 * Import data
 *
 * @return string Import file contents
 * @since 0.1
 */
if (!function_exists('wpa_import_widgets')) {
    function wpa_import_widgets()
    {

        $options = (!empty($_REQUEST['options'])) ? json_decode(wp_unslash(trim($_REQUEST['options'])), true) : array();
        $nonce   = (!empty($_GET['nonce'])) ? sanitize_text_field(wp_unslash($_GET['nonce'])) : '';
        $unique  = (!empty($_GET['unique'])) ? sanitize_text_field(wp_unslash($_GET['unique'])) : '';
        $widgets = (!empty($options['backup_widget_list'])) ? $options['backup_widget_list'] : array();

        if (!wp_verify_nonce($nonce, 'wpa_backup_nonce')) {
            die(esc_html__('Error: Nonce verification has failed. Please try again.', 'nutrail'));
        }

        if (empty($unique)) {
            die(esc_html__('Error: Options unique id could not valid.', 'nutrail'));
        }

        $theme_data                 = get_option($unique);
        $theme_data['multi-widget'] = !empty($theme_data['multi-widget']) ? $theme_data['multi-widget'] : array();

        // import theme option only
        if (isset($_GET['import-theme-options'])) {
            $option_name = (!empty($options['backup_options_list'])) ? $options['backup_options_list'] : '';

            if (file_exists(WPPRESETPATH.'/options/'.$option_name.'.php')) {
                $theme_option = include WPPRESETPATH.'/options/'.$option_name.'.php';
                $theme_option = wpa_upload_media_options($theme_option);
                if (!empty($theme_option['multi-widget'])) {
                    foreach ($theme_option['multi-widget'] as $widget) {
                        $widget_option = wpa_array_search($theme_data['multi-widget'], 'id', $widget['id']);
                        if (empty($widget_option)) {
                            $theme_data['multi-widget'][] = array(
                                'id'   => $widget['id'],
                                'name' => $widget['name'],
                            );
                        }
                    }
                }

                $theme_option['multi-widget'] = $theme_data['multi-widget'];

                update_option($unique, $theme_option);
            }

            wp_send_json_success(admin_url('/admin.php?page=admin_options'));
            wp_die();
        }

        if (!empty($widgets)) {
            $import_results = array();
            $notices        = array();

            foreach ($widgets as $widget) {
                $widget_path = WPPRESETPATH.'/widgets/'.$widget.'.php';
                if (file_exists($widget_path)) {
                    $data_widgets  = include $widget_path;
                    $widget_id     = array_keys($data_widgets)[0];
                    $new_id        = 'widget-demo-'.mt_rand();
                    $widget_option = wpa_array_search($theme_data['multi-widget'], 'id', $new_id);
                    $file_info     = get_file_data($widget_path, array('Name' => 'Name'));

                    if (empty($widget_option)) {
                        $theme_data['multi-widget'][] = array(
                            'id'   => $new_id,
                            'name' => $file_info['Name'],
                        );
                        update_option($unique, $theme_data);
                    }

                    $results = wpa_generate_import_widgets($data_widgets, $new_id);

                    if (!empty($results[$widget_id])) {
                        $import_results[] = $results[$widget_id];
                    }
                }
            }

            // Update notice
            if (!empty($import_results)) {
                foreach ($import_results as $result) {
                    $message = $result['message_type'] == 'success' ? '<span>Success</span>' : '<span>'.$result['message'].'</span>';
                    $notice  = '<p><strong>'.$result['name'].': </strong>'.$message.'</p>';
                    foreach ($result['widgets'] as $widget) {
                        $notice .= '<p>- '.$widget['name'].': '.$widget['message'].'</p>';
                    }
                    $notices[] = array(
                        'type'        => $result['message_type'],
                        'dismissible' => '',
                        'notice'      => $notice,
                    );
                }
            }
            update_option('wpa_flash_notices', $notices);
        }

        wp_send_json_success(admin_url('widgets.php'));
        wp_die();

    }

    add_action('wp_ajax_wpa-import-widgets', 'wpa_import_widgets');
}

/**
 *
 * Export
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_export')) {
    function wpa_export()
    {

        $nonce  = (!empty($_GET['nonce'])) ? sanitize_text_field(wp_unslash($_GET['nonce'])) : '';
        $unique = (!empty($_GET['unique'])) ? sanitize_text_field(wp_unslash($_GET['unique'])) : '';

        if (!wp_verify_nonce($nonce, 'wpa_backup_nonce')) {
            die(esc_html__('Error: Nonce verification has failed. Please try again.', 'nutrail'));
        }

        if (empty($unique)) {
            die(esc_html__('Error: Options unique id could not valid.', 'nutrail'));
        }

        // Export
        header('Content-Type: application/json');
        header('Content-disposition: attachment; filename=backup-'.gmdate('d-m-Y').'.json');
        header('Content-Transfer-Encoding: binary');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo json_encode(get_option($unique));

        die();

    }

    add_action('wp_ajax_wpa-export', 'wpa_export');
}

/**
 *
 * Import Ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_import_ajax')) {
    function wpa_import_ajax()
    {

        $nonce  = (!empty($_POST['nonce'])) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
        $unique = (!empty($_POST['unique'])) ? sanitize_text_field(wp_unslash($_POST['unique'])) : '';
        $data   = (!empty($_POST['data'])) ? wp_kses_post_deep(json_decode(wp_unslash(trim($_POST['data'])),
            true)) : array();

        if (!wp_verify_nonce($nonce, 'wpa_backup_nonce')) {
            wp_send_json_error(array(
                'error' => esc_html__('Error: Nonce verification has failed. Please try again.', 'nutrail')
            ));
        }

        if (empty($unique)) {
            wp_send_json_error(array(
                'error' => esc_html__('Error: Options unique id could not valid.', 'nutrail')
            ));
        }

        if (empty($data) || !is_array($data)) {
            wp_send_json_error(array(
                'error' => esc_html__('Error: Import data could not valid.', 'nutrail')
            ));
        }

        // Success
        update_option($unique, $data);

        wp_send_json_success();

    }

    add_action('wp_ajax_wpa-import', 'wpa_import_ajax');
}

/**
 *
 * Reset Ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_reset_ajax')) {
    function wpa_reset_ajax()
    {

        $nonce  = (!empty($_POST['nonce'])) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
        $unique = (!empty($_POST['unique'])) ? sanitize_text_field(wp_unslash($_POST['unique'])) : '';

        if (!wp_verify_nonce($nonce, 'wpa_backup_nonce')) {
            wp_send_json_error(array(
                'error' => esc_html__('Error: Nonce verification has failed. Please try again.', 'nutrail')
            ));
        }

        // Success
        delete_option($unique);

        wp_send_json_success();

    }

    add_action('wp_ajax_wpa-reset', 'wpa_reset_ajax');
}
/**
 *
 * Chosen Ajax
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_chosen_ajax')) {
    function wpa_chosen_ajax()
    {

        $nonce = (!empty($_POST['nonce'])) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
        $type  = (!empty($_POST['type'])) ? sanitize_text_field(wp_unslash($_POST['type'])) : '';
        $term  = (!empty($_POST['term'])) ? sanitize_text_field(wp_unslash($_POST['term'])) : '';
        $query = (!empty($_POST['query_args'])) ? wp_kses_post_deep($_POST['query_args']) : array();

        if (!wp_verify_nonce($nonce, 'wpa_chosen_ajax_nonce')) {
            wp_send_json_error(array('error' => esc_html__('Error: Invalid nonce verification.', 'nutrail')));
        }

        if (empty($type) || empty($term)) {
            wp_send_json_error(array('error' => esc_html__('Error: Invalid term ID.', 'nutrail')));
        }

        $capability = apply_filters('wpa_chosen_ajax_capability', 'manage_options');

        if (!current_user_can($capability)) {
            wp_send_json_error(array('error' => esc_html__('Error: You do not have permission to do that.', 'nutrail')));
        }

        // Success
        $options = WPA_Fields::field_data($type, $term, $query);

        wp_send_json_success($options);

    }

    add_action('wp_ajax_wpa-chosen', 'wpa_chosen_ajax');
}