<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.

function get_preset_data($name = 'widgets', $image_select = false)
{
    $options = array();
    $path    = glob(WPPRESETPATH.'/'.$name.'/*.php');

    foreach ($path as $file) {
        $filename = str_replace('.php', '', wp_basename($file));
        $fileinfo = get_file_data($file, array(
            'Name' => 'Name',
        ));
        if (!empty($fileinfo['Name'])) {
            if ($image_select) {
                if (file_exists(WPPRESETPATH.'/'.$name.'/'.$filename.'.jpg')) {
                    $options[$filename] = WPPRESETURI.'/'.$name.'/'.$filename.'.jpg';
                }
            } else {
                $options[$filename] = $fileinfo['Name'];
            }
        }
    }

    return $options;
}

function template_import_widget_callback()
{
    $link = add_query_arg(
        array(
            'action' => 'wpa-create-page-widgets',
            'nonce'  => wp_create_nonce('wpa_callback_nonce')
        ), admin_url('admin-ajax.php')
    );
    echo '<a href="'.esc_url($link).'" class="button-primary wpa-save-callback">Setup page</a>';
}

/* page widgets */
function customizer_metabox_link()
{
    global $post;

    $link = add_query_arg(
        array(
            'url' => get_permalink($post->ID)
        ),
        admin_url('customize.php')
    );
    echo '<a href="'.esc_url($link).'" class="button wpa-warning-primary">Edit customize</a>';
}

if (!function_exists('wpa_update_multi_widgets')) {
    function wpa_update_multi_widgets($post = null)
    {
        if (!empty($post)) {
            $exits         = false;
            $theme_options = get_option(WPOPTIONKEY);
            $widgets       = !empty($theme_options['multi-widget']) ? $theme_options['multi-widget'] : array();
            $id            = "widget-page-{$post->post_name}";
            foreach ($widgets as $key => $widget) {
                if ($widget['id'] == $id) {
                    $exits                 = true;
                    $widgets[$key]['name'] = $post->post_title;
                    break;
                }
            }
            if (!$exits) {
                $widgets[] = array(
                    'name' => $post->post_title,
                    'id'   => $id,
                );
            }
            $theme_options['multi-widget'] = $widgets;
            // save options
            update_option(WPOPTIONKEY, $theme_options);
        }
    }
}

if (!function_exists('wpa_export_file_json')) {
    function wpa_export_file_json($filename, $file_contents)
    {
        // Build filename
        // Single Site: backup-demo.json
        $filename = apply_filters('wpa_export_widgets_filename', $filename);

        // Generate export file contents.
        // Encode the data for file contents.
        $file_contents = json_encode($file_contents);

        // Headers to prompt "Save As".
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$filename);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.strlen($file_contents));

        // Clear buffering just in case.
        // @codingStandardsIgnoreLine
        @ob_end_clean();
        flush();

        // Output file contents.
        // @codingStandardsIgnoreLine
        echo $file_contents;
    }
}

if (!function_exists('wpa_export_media_options')) {
    function wpa_export_media_options(&$result)
    {
        wp_mkdir_p(get_template_directory().'/export/images/');

        array_walk($result, function (&$value, $key) {
            if (is_array($value)) {
                $value = wpa_export_media_options($value);
            }
            if (!empty($value['id']) && !empty($value['url'])) {
                $value['url']       = '';
                $value['thumbnail'] = '';

                // Copy file
                $src_dir    = get_attached_file($value['id']);
                $filename   = basename($src_dir);
                $target_dir = get_template_directory().'/export/images/'.$filename;

                if (copy($src_dir, $target_dir)) {
                    $value['url'] = "/images/{$filename}";
                }
            }
            if (!empty($value['background-image']['url']) && !empty($value['background-image']['id'])) {
                $value['background-image']['url']       = '';
                $value['background-image']['thumbnail'] = '';

                // Copy file
                $src_dir    = get_attached_file($value['background-image']['id']);
                $filename   = basename($src_dir);
                $target_dir = get_template_directory().'/export/images/'.$filename;

                if (copy($src_dir, $target_dir)) {
                    $value['background-image']['url'] = "/images/{$filename}";
                }
            }
        });

        return $result;
    }
}

if (!function_exists('wpa_upload_media_options')) {
    function wpa_upload_media_options(&$result)
    {
        array_walk($result, function (&$value, $key) {
            if (is_array($value)) {
                $value = wpa_upload_media_options($value);
            }
            if (!empty($value['background-image']['url'])) {
                $attachment_id  = wpa_upload_media(WPPRESETURI.$value['background-image']['url']);
                $attachment_url = wp_get_attachment_image_url($attachment_id, 'full');
                $thumbnail_url  = wp_get_attachment_image_url($attachment_id, 'thumbnail');

                $value['background-image']['id']        = $attachment_id;
                $value['background-image']['url']       = $attachment_url;
                $value['background-image']['thumbnail'] = $thumbnail_url;
            }
            if (!empty($value['id']) && !empty($value['url'])) {
                $attachment_id  = wpa_upload_media(WPPRESETURI.$value['url']);
                $attachment_url = wp_get_attachment_image_url($attachment_id, 'full');
                $thumbnail_url  = wp_get_attachment_image_url($attachment_id, 'thumbnail');

                $value['id']        = $attachment_id;
                $value['url']       = $attachment_url;
                $value['thumbnail'] = $thumbnail_url;
            }
        });

        return $result;
    }
}

/**
 * upload media file
 **/
if (!function_exists('wpa_upload_media')) {
    function wpa_upload_media($files)
    {
        if (!function_exists('media_handle_upload')) {
            require_once ABSPATH.'wp-admin/includes/image.php';
            require_once ABSPATH.'wp-admin/includes/file.php';
            require_once ABSPATH.'wp-admin/includes/media.php';
        }

        if (is_array($files)) {
            // Download file to temp location.
            $upload = array(
                'name'     => $files['name'],
                'type'     => $files['type'],
                'tmp_name' => $files['tmp_name'],
                'error'    => $files['error'],
                'size'     => $files['size']
            );
        } else {
            $image_url  = $files;
            $parsed_url = wp_parse_url($image_url);

            // Check parsed URL.
            if (!$parsed_url || !is_array($parsed_url)) {
                return false;

            }
            // Ensure url is valid.
            $image_url = esc_url_raw($image_url);

            // Download file to temp location.
            $upload = array(
                'name'     => basename(current(explode('?', $image_url))),
                'tmp_name' => download_url($image_url)
            );
        }

        // If error storing temporarily, return the error.
        if (is_wp_error($upload['tmp_name'])) {
            return false;
        }

        // Do the validation and storage stuff.
        $file = wp_handle_sideload($upload, array('test_form' => false));

        if (isset($file['error'])) {
            @unlink($upload['tmp_name']);

            return false;
        }

        $ext  = pathinfo($upload['name'], PATHINFO_EXTENSION);
        $name = wp_basename($upload['name'], ".$ext");

        $url     = $file['url'];
        $type    = $file['type'];
        $file    = $file['file'];
        $title   = sanitize_text_field($name);
        $content = '';
        $excerpt = '';

        if (0 === strpos($type, 'image/')) {
            $image_meta = wp_read_image_metadata($file);

            if ($image_meta) {
                if (trim($image_meta['title']) && !is_numeric(sanitize_title($image_meta['title']))) {
                    $title = $image_meta['title'];
                }

                if (trim($image_meta['caption'])) {
                    $excerpt = $image_meta['caption'];
                }
            }
        }

        // Construct the attachment array.
        $attachment = array(
            'post_mime_type' => $type,
            'guid'           => $url,
            'post_parent'    => 0,
            'post_title'     => $title,
            'post_content'   => $content,
            'post_excerpt'   => $excerpt,
        );

        // This should never be set as it would then overwrite an existing attachment.
        unset($attachment['ID']);

        // Save the data.
        $attachment_id = wp_insert_attachment($attachment, $file);

        if (!is_wp_error($attachment_id)) {
            // Set a custom header with the attachment_id.
            // Used by the browser/client to resume creating image sub-sizes after a PHP fatal error.
            if (!headers_sent()) {
                header('X-WP-Upload-Attachment-ID: '.$attachment_id);
            }

            // The image sub-sizes are created during wp_generate_attachment_metadata().
            // This is generally slow and may cause timeouts or out of memory errors.
            wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $file));
        }

        update_post_meta($attachment_id, '_wp_attachment_image_alt', $title);

        return $attachment_id;
    }
}

/**
 * upload media file
 **/
if (!function_exists('wpa_handle_form_upload')) {
    function wpa_handle_form_upload($files, $field_name = null, $limit = 3)
    {
        $count         = 0;
        $attachment_id = array();
        $files         = !empty($files[$field_name]) ? $files[$field_name] : array();
        $limit_size    = wp_convert_hr_to_bytes('2M');

        add_filter('upload'.'_'.'mimes', 'wpa_upload_limit_mimes', 999);

        if (!empty($files['name'])) {
            if (is_array($files['name'])) {
                foreach ($files['name'] as $key => $filename) {
                    if ($count >= $limit || $limit_size < $files['size'][$key] || $files['size'][$key] == 1) {
                        continue;
                    }
                    $upload          = array(
                        'name'     => $filename,
                        'type'     => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error'    => $files['error'][$key],
                        'size'     => $files['size'][$key]
                    );
                    $attachment_id[] = wpa_upload_media($upload);
                }
            } else {
                if ($limit_size >= $files['size'] && $files['error'] == 0) {
                    $attachment_id[] = wpa_upload_media($files);
                }
            }
        }

        remove_filter('upload'.'_'.'mimes', 'wpa_upload_limit_mimes', 999);

        return $attachment_id;
    }
}

if (!function_exists('wpa_upload_limit_mimes')) {
    function wpa_upload_limit_mimes($mimes)
    {
        return apply_filters('wpa_upload_limit_mimes', [
            'jpg|jpeg|jpe' => 'image/jpeg',
            'png'          => 'image/png',
        ]);
    }
}

/**
 * Call a shortcode function by tag name.
 *
 * @param  string  $tag  The shortcode whose function to call.
 * @param  array  $atts  The attributes to pass to the shortcode function. Optional.
 * @param  array  $content  The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 * @since  1.4.6
 *
 */
if (!function_exists('wpa_do_shortcode')) {
    function wpa_do_shortcode($tag, array $atts = array(), $content = null)
    {
        global $shortcode_tags;

        if (!isset($shortcode_tags[$tag])) {
            return false;
        }

        return call_user_func($shortcode_tags[$tag], $atts, $content, $tag);
    }
}

/**
 *
 * Array search key & value
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_array_search')) {
    function wpa_array_search($array, $key, $value)
    {

        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $sub_array) {
                $results = array_merge($results, wpa_array_search($sub_array, $key, $value));
            }

        }

        return $results;

    }
}
/**
 *
 * GET OPTION
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 **/
if (!function_exists('wpa_get_option')) {
    function wpa_get_option($option_name = '', $default = '', $key = WPOPTIONKEY)
    {
        $options = get_option($key);

        if (isset($_GET[$option_name])) {
            $default               = wp_unslash($_GET[$option_name]);
            $options[$option_name] = wp_unslash($_GET[$option_name]);
        }

        $options = apply_filters('wpa_get_framework_option', $options, $option_name, $default);

        if (!empty($options) && isset($options[$option_name])) {
            $option = $options[$option_name];
            if (is_array($option) && isset($option['multilang']) && $option['multilang'] == true) {
                if (defined('ICL_LANGUAGE_CODE')) {
                    if (isset($option[ICL_LANGUAGE_CODE])) {
                        return $option[ICL_LANGUAGE_CODE];
                    }
                } else {
                    $option = reset($option);
                }
            }

            return $option;
        } else {
            return $default;
        }
    }
}
/**
 *
 * Multi language option
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_get_multilang_option')) {
    function wpa_get_multilang_option($option_name = '', $default = '')
    {
        $value     = wpa_get_option($option_name, $default);
        $languages = wpa_language_defaults();
        $default   = $languages['default'];
        $current   = $languages['current'];
        if (is_array($value) && is_array($languages) && isset($value[$current])) {
            return $value[$current];
        } else {
            if ($default != $current) {
                return '';
            }
        }

        return $value;
    }
}
/**
 *
 * Multi language value
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_get_multilang_value')) {
    function wpa_get_multilang_value($value = '', $default = '')
    {
        $languages = wpa_language_defaults();
        $default   = $languages['default'];
        $current   = $languages['current'];
        if (is_array($value) && is_array($languages) && isset($value[$current])) {
            return $value[$current];
        } else {
            if ($default != $current) {
                return '';
            }
        }

        return $value;
    }
}
/**
 * Available widgets
 *
 * Gather site's widgets into array with ID base, name, etc.
 * Used by export and import functions.
 *
 * @return array Widget information
 * @global array $wp_registered_widget_updates
 * @since 0.4
 */
if (!function_exists('wpa_get_available_widgets')) {
    function wpa_get_available_widgets()
    {
        global $wp_registered_widget_controls;

        $widget_controls = $wp_registered_widget_controls;

        $available_widgets = array();

        foreach ($widget_controls as $widget) {
            // No duplicates.
            if (!empty($widget['id_base']) && !isset($available_widgets[$widget['id_base']])) {
                $available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
                $available_widgets[$widget['id_base']]['name']    = $widget['name'];
            }
        }

        return apply_filters('wpa_available_widgets', $available_widgets);
    }
}
/**
 * Generate export data
 *
 * @return string Export file contents
 * @since 0.1
 */
if (!function_exists('wpa_generate_export_widgets')) {
    function wpa_generate_export_widgets()
    {
        // Get all available widgets site supports.
        $available_widgets = wpa_get_available_widgets();

        // Get all widget instances for each widget.
        $widget_instances = array();

        // Loop widgets.
        foreach ($available_widgets as $widget_data) {
            // Get all instances for this ID base.
            $instances = get_option('widget_'.$widget_data['id_base']);

            // Have instances.
            if (!empty($instances)) {
                // Loop instances.
                foreach ($instances as $instance_id => $instance_data) {
                    // Key is ID (not _multiwidget).
                    if (is_numeric($instance_id)) {
                        $unique_instance_id                    = $widget_data['id_base'].'-'.$instance_id;
                        $widget_instances[$unique_instance_id] = $instance_data;
                    }
                }
            }
        }

        // Gather sidebars with their widget instances.
        $sidebars_widgets          = wp_get_sidebars_widgets();
        $sidebars_widget_instances = array();
        foreach ($sidebars_widgets as $sidebar_id => $widget_ids) {
            // Skip inactive widgets.
            if ('wp_inactive_widgets' === $sidebar_id) {
                continue;
            }

            // Skip if no data or not an array (array_version).
            if (!is_array($widget_ids) || empty($widget_ids)) {
                continue;
            }

            // Loop widget IDs for this sidebar.
            foreach ($widget_ids as $widget_id) {
                // Is there an instance for this widget ID?
                if (isset($widget_instances[$widget_id])) {
                    // Add to array.
                    $sidebars_widget_instances[$sidebar_id][$widget_id] = $widget_instances[$widget_id];
                }
            }
        }

        // Filter pre-encoded data.
        $data = apply_filters('wpa_unencoded_export_data', $sidebars_widget_instances);

        // Return contents.
        return apply_filters('wpa_generate_export_data', $data);
    }
}
/**
 * Import widget JSON data
 *
 * @param  object  $data  JSON widget data from .wie file.
 *
 * @return array Results array
 * @since 0.4
 * @global array $wp_registered_sidebars
 */
if (!function_exists('wpa_generate_import_widgets')) {
    function wpa_generate_import_widgets($data, $new_id = '')
    {
        global $wp_registered_sidebars;

        $data = apply_filters('wpa_import_widgets_data', $data);
        $data = wpa_upload_media_options($data);
        unset($data['widget-option']);

        // Get all available widgets site supports.
        $available_widgets = wpa_get_available_widgets();

        // Get all existing widget instances.
        $widget_instances = array();
        foreach ($available_widgets as $widget_data) {
            $widget_instances[$widget_data['id_base']] = get_option('widget_'.$widget_data['id_base']);
        }

        // Begin results.
        $results = array();

        // Loop import data's sidebars.
        foreach ($data as $sidebar_id => $widgets) {
            // Skip inactive widgets (should not be in export file).
            if ('wp_inactive_widgets' === $sidebar_id) {
                continue;
            }

            // Check if sidebar is available on this site.
            // Otherwise add widgets to inactive, and say so.
            if (isset($wp_registered_sidebars[$sidebar_id])) {
                $sidebar_available    = true;
                $use_sidebar_id       = $sidebar_id;
                $sidebar_message_type = 'success';
                $sidebar_message      = '';
            } else {
                $sidebar_available    = false;
                $use_sidebar_id       = 'wp_inactive_widgets'; // Add to inactive if sidebar does not exist in theme.
                $sidebar_message_type = 'error';
                $sidebar_message      = esc_html__('Widget area does not exist in theme (using Inactive)', 'nutrail');
            }

            if (!empty($new_id)) {
                $sidebar_available    = true;
                $use_sidebar_id       = $new_id;
                $sidebar_message_type = 'success';
                $sidebar_message      = '';
            }

            // Result for sidebar
            // Sidebar name if theme supports it; otherwise ID.
            $results[$sidebar_id]['name']         = !empty($wp_registered_sidebars[$sidebar_id]['name']) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id;
            $results[$sidebar_id]['message_type'] = $sidebar_message_type;
            $results[$sidebar_id]['message']      = $sidebar_message;
            $results[$sidebar_id]['widgets']      = array();

            // Loop widgets.
            foreach ($widgets as $widget_instance_id => $widget) {
                $fail = false;

                // Get id_base (remove -# from end) and instance ID number.
                $id_base            = preg_replace('/-[0-9]+$/', '', $widget_instance_id);
                $instance_id_number = str_replace($id_base.'-', '', $widget_instance_id);

                // Does site support this widget?
                if (!$fail && !isset($available_widgets[$id_base])) {
                    $fail                = true;
                    $widget_message_type = 'error';
                    $widget_message      = __('Site does not support widget', 'nutrail'); // Explain why widget not imported.
                }

                // Filter to modify settings object before conversion to array and import
                // Leave this filter here for backwards compatibility with manipulating objects (before conversion to array below)
                // Ideally the newer wie_widget_settings_array below will be used instead of this.
                $widget = apply_filters('wpa_widget_settings', $widget);

                // Convert multidimensional objects to multidimensional arrays
                // Some plugins like Jetpack Widget Visibility store settings as multidimensional arrays
                // Without this, they are imported as objects and cause fatal error on Widgets page
                // If this creates problems for plugins that do actually intend settings in objects then may need to consider other approach: https://wordpress.org/support/topic/problem-with-array-of-arrays
                // It is probably much more likely that arrays are used than objects, however.
                $widget = json_decode(wp_json_encode($widget), true);

                // Filter to modify settings array
                // This is preferred over the older wie_widget_settings filter above
                // Do before identical check because changes may make it identical to end result (such as URL replacements).
                $widget = apply_filters('wpa_widget_settings_array', $widget);

                // Does widget with identical settings already exist in same sidebar?
                if (!$fail && isset($widget_instances[$id_base])) {
                    // Get existing widgets in this sidebar.
                    $sidebars_widgets = get_option('sidebars_widgets');
                    $sidebar_widgets  = isset($sidebars_widgets[$use_sidebar_id]) ? $sidebars_widgets[$use_sidebar_id] : array(); // Check Inactive if that's where will go.

                    // Loop widgets with ID base.
                    $single_widget_instances = !empty($widget_instances[$id_base]) ? $widget_instances[$id_base] : array();
                    foreach ($single_widget_instances as $check_id => $check_widget) {
                        // Is widget in same sidebar and has identical settings?
                        if (in_array("$id_base-$check_id", $sidebar_widgets, true) && (array) $widget === $check_widget) {
                            $fail                = true;
                            $widget_message_type = 'warning';

                            // Explain why widget not imported.
                            $widget_message = __('Widget already exists', 'nutrail');

                            break;
                        }
                    }
                }

                // No failure.
                if (!$fail) {
                    // Add widget instance
                    $single_widget_instances   = get_option('widget_'.$id_base); // All instances for that widget ID base, get fresh every time.
                    $single_widget_instances   = !empty($single_widget_instances) ? $single_widget_instances : array(
                        '_multiwidget' => 1,   // Start fresh if have to.
                    );
                    $single_widget_instances[] = $widget; // Add it.

                    // Get the key it was given.
                    end($single_widget_instances);
                    $new_instance_id_number = key($single_widget_instances);

                    // If key is 0, make it 1
                    // When 0, an issue can occur where adding a widget causes data from other widget to load,
                    // and the widget doesn't stick (reload wipes it).
                    if ('0' === strval($new_instance_id_number)) {
                        $new_instance_id_number                           = 1;
                        $single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
                        unset($single_widget_instances[0]);
                    }

                    // Move _multiwidget to end of array for uniformity.
                    if (isset($single_widget_instances['_multiwidget'])) {
                        $multiwidget = $single_widget_instances['_multiwidget'];
                        unset($single_widget_instances['_multiwidget']);
                        $single_widget_instances['_multiwidget'] = $multiwidget;
                    }

                    // Update option with new widget.
                    update_option('widget_'.$id_base, $single_widget_instances);

                    // Assign widget instance to sidebar.
                    // Which sidebars have which widgets, get fresh every time.
                    $sidebars_widgets = get_option('sidebars_widgets');

                    // Avoid rarely fatal error when the option is an empty string
                    if (!$sidebars_widgets) {
                        $sidebars_widgets = array();
                    }

                    // Use ID number from new widget instance.
                    $new_instance_id = $id_base.'-'.$new_instance_id_number;

                    // Add new instance to sidebar.
                    $sidebars_widgets[$use_sidebar_id][] = $new_instance_id;

                    // Save the amended data.
                    update_option('sidebars_widgets', $sidebars_widgets);

                    // After widget import action.
                    $after_widget_import = array(
                        'sidebar'           => $use_sidebar_id,
                        'sidebar_old'       => $sidebar_id,
                        'widget'            => $widget,
                        'widget_type'       => $id_base,
                        'widget_id'         => $new_instance_id,
                        'widget_id_old'     => $widget_instance_id,
                        'widget_id_num'     => $new_instance_id_number,
                        'widget_id_num_old' => $instance_id_number,
                    );
                    do_action('wpa_after_widget_import', $after_widget_import);

                    // Success message.
                    if ($sidebar_available) {
                        $widget_message_type = 'success';
                        $widget_message      = __('Imported', 'nutrail');
                    } else {
                        $widget_message_type = 'warning';
                        $widget_message      = __('Imported to Inactive', 'nutrail');
                    }
                }

                // Result for widget instance
                $results[$sidebar_id]['widgets'][$widget_instance_id]['name']         = isset($available_widgets[$id_base]['name']) ? $available_widgets[$id_base]['name'] : $id_base;      // Widget name or ID if name not available (not supported by site).
                $results[$sidebar_id]['widgets'][$widget_instance_id]['title']        = !empty($widget['title']) ? $widget['title'] : esc_html__('No Title', 'nutrail');  // Show "No Title" if widget instance is untitled.
                $results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
                $results[$sidebar_id]['widgets'][$widget_instance_id]['message']      = $widget_message;
            }
        }

        // Return results.
        return apply_filters('wpa_import_widgets_results', $results);
    }
}

if (!function_exists('wpa_regenerate_resize_image')) {
    function wpa_regenerate_resize_image($attachment_id, $src, $width, $height, $attr)
    {
        $html     = '';
        $hwstring = image_hwstring($width, $height);
        $size     = $width.'x'.$height;

        if ($src) {
            $attachment   = get_post($attachment_id);
            $default_attr = array(
                'src'   => $src,
                'class' => "attachment-$attachment_id",
                'alt'   => trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true))),
            );
            $attr         = wp_parse_args($attr, $default_attr);

            // Add `loading` attribute.
            if (function_exists('wp_lazy_loading_enabled') && wp_lazy_loading_enabled('img', 'wp_get_attachment_image')) {
                $attr['loading'] = 'lazy';
            }

            // If `loading` attribute default of `lazy` is overridden for this
            // image to omit the attribute, ensure it is not included.
            if (array_key_exists('loading', $attr) && !$attr['loading']) {
                unset($attr['loading']);
            }

            /**
             * Filters the list of attachment image attributes.
             *
             * @param  array  $attr  Array of attribute values for the image markup, keyed by attribute name.
             *                                 See wp_get_attachment_image().
             * @param  WP_Post  $attachment  Image attachment post.
             * @param  string|array  $size  Requested size. Image size or array of width and height values
             *                                 (in that order). Default 'thumbnail'.
             *
             * @since 2.8.0
             *
             */
            $attr = apply_filters('wp_get_attachment_image_attributes', $attr, $attachment, $size);

            if (empty($attr['alt'])) {
                $attr['alt'] = $attachment->post_title;
            }

            $attr = array_map('esc_attr', $attr);
            $html = rtrim("<img $hwstring");

            foreach ($attr as $name => $value) {
                $html .= " $name=".'"'.$value.'"';
            }

            $html .= ' />';
        }

        return apply_filters('wpa_regenerate_resize_image_data', $html, $attr, $size, $attachment_id);
    }
}

if (!function_exists('wpa_resize_image')) {
    function wpa_resize_image($attachment_id = null, $width = null, $height = null, $crop = true, $placeholder = true, $attr = array())
    {
        $needs_resize   = true;
        $original       = false;
        $image_src      = array();
        $width          = absint($width);
        $height         = absint($height);
        $placeholder_id = null;

        if ($width == null || $height == null) {
            $original = true;
        }
        if (is_numeric($attachment_id)) {
            $image_src     = wp_get_attachment_image_src($attachment_id, 'full');
            $attached_file = get_attached_file($attachment_id);
            // this is not an attachment, let's use the image url
        } elseif (!empty($attachment_id) && @getimagesize($attachment_id)) {
            $img_url       = $attachment_id;
            $file_path     = parse_url($img_url);
            $attached_file = rtrim(ABSPATH, '/').$file_path['path'];
            $orig_size     = @getimagesize($attached_file);
            $image_src[0]  = $img_url;
            $image_src[1]  = $orig_size[0];
            $image_src[2]  = $orig_size[1];
        }

        if (!empty($attached_file)) {
            // checking if the full size
            if ($crop == false && $original == false) {
                $image_src[1] = $width;
                $image_src[2] = $height;
                $original     = true;
            }
            if ($original == true) {
                return wpa_regenerate_resize_image(
                    $attachment_id,
                    $image_src[0],
                    $image_src[1],
                    $image_src[2],
                    $attr
                );
            }
            // Look through the attachment meta data for an image that fits our size.
            $meta = wp_get_attachment_metadata($attachment_id);
            if (!empty($meta['file'])) {
                $upload_dir = wp_upload_dir();
                $base_dir   = trim($upload_dir['basedir']);
                $base_url   = trim($upload_dir['baseurl']);
                $src        = trailingslashit($base_url).$meta['file'];
                $path       = trailingslashit($base_dir).$meta['file'];
                if (!empty($meta['sizes'])) {
                    foreach ($meta['sizes'] as $key => $size) {
                        if (($size['width'] == $width && $size['height'] == $height) || $key == sprintf('resized-%dx%d', $width, $height)) {
                            if (!empty($size['file'])) {
                                $file = str_replace(basename($path), $size['file'], $path);
                                if (file_exists($file)) {
                                    $needs_resize = false;
                                    $src          = str_replace(basename($src), $size['file'], $src);
                                }
                            }
                            break;
                        }
                    }
                }
                // checking if the file size is larger than the target size
                // if it is smaller or the same size, stop right here and return
                if ($needs_resize) {
                    $resized = image_make_intermediate_size($attached_file, $width, $height, $crop);

                    if (is_wp_error($resized)) {
                        return wpa_regenerate_resize_image(
                            $attachment_id,
                            $image_src[0],
                            $image_src[1],
                            $image_src[2],
                            $attr
                        );
                    }
                    if (empty($resized)) {
                        $image_no_crop = wp_get_attachment_image_src($attachment_id, array($width, $height));

                        return wpa_regenerate_resize_image(
                            $attachment_id,
                            $image_no_crop[0],
                            $image_no_crop[1],
                            $image_no_crop[2],
                            $attr
                        );
                    }

                    // Let metadata know about our new size.
                    $key                 = sprintf('resized-%dx%d', $width, $height);
                    $meta['sizes'][$key] = $resized;
                    if (!empty($resized['file'])) {
                        $src = str_replace(basename($src), $resized['file'], $src);
                    }
                    wp_update_attachment_metadata($attachment_id, $meta);

                    // Record in backup sizes so everything's cleaned up when attachment is deleted.
                    $backup_sizes = get_post_meta($attachment_id, '_wp_attachment_backup_sizes', true);
                    if (!is_array($backup_sizes)) {
                        $backup_sizes = array();
                    }
                    $backup_sizes[$key] = $resized;
                    update_post_meta($attachment_id, '_wp_attachment_backup_sizes', $backup_sizes);
                }

                // output image
                return wpa_regenerate_resize_image(
                    $attachment_id,
                    $src,
                    $width,
                    $height,
                    $attr
                );
            }
        } elseif (!empty($image_src)) {
            return wpa_regenerate_resize_image(
                $attachment_id,
                $image_src[0],
                $image_src[1],
                $image_src[2],
                $attr
            );
        }
        // placeholder image
        $hwstring = image_hwstring($width, $height);
        $size     = $width.'x'.$height;
        if ($placeholder) {
            if (!empty($placeholder_id)) {
                return wpa_resize_image($placeholder_id,
                    $width,
                    $height,
                    $crop,
                    $placeholder,
                    $attr
                );
            } else {
                $placeholder_url = "https://via.placeholder.com/{$width}x{$height}?text={$width}x{$height}";
                $placeholder_img = "<img src='{$placeholder_url}' {$hwstring} loading='lazy' alt='placeholder'>";
            }
        } else {
            $placeholder_img = '';
        }

        return apply_filters('wpa_regenerate_resize_image_data', $placeholder_img, null, $size, 0);
    }
}

/**
 *
 * Add framework element
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_add_field')) {
    function wpa_add_field($field = array(), $value = '', $unique = '', $where = '', $parent = '')
    {
        return WPA::field($field, $value, $unique, $where, $parent);
    }
}
/**
 *
 * Array search key & value
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_array_search')) {
    function wpa_array_search($array, $key, $value)
    {
        $results = array();
        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }
            foreach ($array as $sub_array) {
                $results = array_merge($results, wpa_array_search($sub_array, $key, $value));
            }
        }

        return $results;
    }
}

/**
 *
 * Getting POST Var
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_get_var')) {
    function wpa_get_var($var, $default = '')
    {
        if (isset($_POST[$var])) {
            return wp_unslash($_POST[$var]);
        }
        if (isset($_GET[$var])) {
            return wp_unslash($_GET[$var]);
        }

        return $default;
    }
}
/**
 *
 * Getting POST Vars
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_get_vars')) {
    function wpa_get_vars($var, $depth, $default = '')
    {
        if (isset($_POST[$var][$depth])) {
            return wp_unslash($_POST[$var][$depth]);
        }
        if (isset($_GET[$var][$depth])) {
            return wp_unslash($_GET[$var][$depth]);
        }

        return $default;
    }
}
/**
 *
 * Between Microtime
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_microtime')) {
    function wpa_timeout($timenow, $starttime, $timeout = 30)
    {
        return (($timenow - $starttime) < $timeout) ? true : false;
    }
}
/**
 *
 * Check for wp editor api
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_wp_editor_api')) {
    function wpa_wp_editor_api()
    {
        global $wp_version;

        return version_compare($wp_version, '4.8', '>=');
    }
}
/**
 *
 * Encode string for backup options
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_encode_string')) {
    function wpa_encode_string($string)
    {
        return json_encode(trim($string));
    }
}
/**
 *
 * Decode string for backup options
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_decode_string')) {
    function wpa_decode_string($string)
    {
        return json_decode(wp_unslash(trim($string)), true);
    }
}
/**
 *
 * Getting Custom Options for Fields
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_get_custom_options')) {
    function wpa_get_custom_options()
    {
        $default = array(
            'key-1' => 'Key 1',
            'key-2' => 'Key 2',
            'key-3' => 'Key 3',
        );

        return $default;
    }
}
/**
 *
 * Get language defaults
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!function_exists('wpa_language_defaults')) {
    function wpa_language_defaults()
    {
        $multilang = array();
        if (class_exists('SitePress') || class_exists('Polylang') || function_exists('qtrans_getSortedLanguages')) {
            if (class_exists('SitePress')) {
                global $sitepress;
                $multilang['default']   = $sitepress->get_default_language();
                $multilang['current']   = $sitepress->get_current_language();
                $multilang['languages'] = $sitepress->get_active_languages();
            } else {
                if (class_exists('Polylang')) {
                    global $polylang;
                    $current    = pll_current_language();
                    $default    = pll_default_language();
                    $current    = (empty($current)) ? $default : $current;
                    $poly_langs = $polylang->model->get_languages_list();
                    $languages  = array();
                    foreach ($poly_langs as $p_lang) {
                        $languages[$p_lang->slug] = $p_lang->slug;
                    }
                    $multilang['default']   = $default;
                    $multilang['current']   = $current;
                    $multilang['languages'] = $languages;
                } else {
                    if (function_exists('qtrans_getSortedLanguages')) {
                        global $q_config;
                        $multilang['default']   = $q_config['default_language'];
                        $multilang['current']   = $q_config['language'];
                        $multilang['languages'] = array_flip(qtrans_getSortedLanguages());
                    }
                }
            }
        }
        $multilang = apply_filters('wpa_language_defaults', $multilang);

        return (!empty($multilang)) ? $multilang : false;
    }
}
