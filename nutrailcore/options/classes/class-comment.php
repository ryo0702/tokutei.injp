<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/**
 *
 * Metabox Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Comment')) {
    class WPA_Comment extends WPA_Abstract
    {
        // constants
        public $sections = array();
        public $errors   = array();
        public $abstract = 'comment';

        // run metabox construct
        public function __construct($sections)
        {
            // Get comment metabox
            $this->sections = apply_filters('wpa_comment_metabox', $sections);

            // Actions metabox
            add_action('add_meta_boxes_comment', array(&$this, 'add_meta_box'));
            add_action('edit_comment', array(&$this, 'save_meta_box'), 10, 2);

            // wp enqueue for typography and output css
            parent::__construct();
        }

        // instance
        public static function instance($sections = array())
        {
            return new self($sections);
        }

        // add metabox
        public function add_meta_box($post_type)
        {
            foreach ($this->sections as $meta) {
                //$value['__back_compat_meta_box'] = true;
                add_meta_box(
                    $meta['id'],
                    $meta['title'],
                    array(&$this, 'add_meta_box_content'),
                    'comment',
                    $meta['context'],
                    $meta['priority'],
                    $meta
                );
            }
        }

        // add metabox content
        public function add_meta_box_content($comment, $callback)
        {
            global $typenow;

            wp_nonce_field('wpa-comment', 'wpa-comment-nonce');

            $args       = $callback['args'];
            $unique     = $args['id'];
            $sections   = (!empty($args['sections'])) ? $args['sections'] : $args['fields'];
            $meta_value = get_comment_meta($comment->comment_ID, $unique, true);
            $has_nav    = (count($sections) >= 2 && $args['context'] != 'side') ? true : false;
            $show_all   = (!$has_nav) ? ' wpa-show-all' : '';
            $timenow    = round(microtime(true));
            $errors     = (isset($meta_value['_transient']['errors'])) ? $meta_value['_transient']['errors'] : array();
            $section    = (isset($meta_value['_transient']['section'])) ? $meta_value['_transient']['section'] : false;
            $expires    = (isset($meta_value['_transient']['expires'])) ? $meta_value['_transient']['expires'] : 0;
            $timein     = wpa_timeout($timenow, $expires, 20);
            $section_id = ($timein && $section) ? $section : '';
            $section_id = wpa_get_var('wpa-section', $section_id);

            // add error
            $this->errors = ($timein) ? $errors : array();

            do_action('wpa_html_comment_before');

            echo '<div class="wpa wpa-theme-dark wpa-metabox">';

            echo '<input type="hidden" name="'.esc_attr($unique).'[_transient][section]" class="wpa-section-id" value="'.esc_attr($section_id).'">';

            echo '<div class="wpa-wrapper'.esc_attr($show_all).'">';

            if ($has_nav) {
                echo '<div class="wpa-nav wpa-nav-metabox" data-unique="'.esc_attr($unique).'">';
                echo '<ul>';
                $num = 0;
                foreach ($sections as $tab) {
                    if (!empty($tab['typenow']) && $tab['typenow'] !== $typenow) {
                        continue;
                    }
                    $tab_error = $this->error_check($tab);
                    $tab_icon  = (!empty($tab['icon'])) ? '<i class="wpa-tab-icon '.esc_attr($tab['icon']).'"></i>' : '';
                    if (isset($tab['fields'])) {
                        echo '<li><a href="#" data-section="'.esc_attr($unique).'_'.esc_attr($tab['name']).'">'.wp_kses_post($tab_icon.$tab['title'].$tab_error).'</a></li>';
                    } else {
                        echo '<li><div class="wpa-seperator">'.wp_kses_post($tab_icon.$tab['title'].$tab_error).'</div></li>';
                    }
                    $num++;
                }
                echo '</ul>';
                echo '</div>';
            }

            echo '<div class="wpa-content">';

            echo '<div class="wpa-sections">';

            $num = 0;

            foreach ($sections as $fields) {
                if (!empty($fields['typenow']) && $fields['typenow'] !== $typenow) {
                    continue;
                }
                if (isset($fields['fields'])) {
                    $active_content = (!$has_nav) ? 'wpa-onload' : '';

                    echo '<div id="wpa-section-'.esc_attr($unique).'_'.esc_attr($fields['name']).'" class="wpa-section '.esc_attr($active_content).'">';

                    echo (isset($fields['title'])) ? '<div class="wpa-section-title"><h3>'.wp_kses_post($fields['title']).'</h3></div>' : '';

                    foreach ($fields['fields'] as $field_key => $field) {
                        $is_field_error = $this->error_check($field);
                        if (!empty($is_field_error)) {
                            $field['_error'] = $is_field_error;
                        }
                        $default    = (isset($field['default'])) ? $field['default'] : '';
                        $elem_id    = (isset($field['id'])) ? $field['id'] : '';
                        $elem_value = (is_array($meta_value) && isset($meta_value[$elem_id])) ? $meta_value[$elem_id] : $default;
                        if (!empty($args['prefix'])) {
                            $elem_value = get_comment_meta($comment->comment_ID, "{$args['prefix']}{$elem_id}", true);
                            if (empty($elem_value)) {
                                $elem_value = $default;
                            }
                        }
                        echo WPA::field($field, $elem_value, $unique, 'metabox');
                    }

                    echo '</div>';
                }
                $num++;
            }

            echo '</div>';

            echo '<div class="clear"></div>';

            if (!empty($args['show_restore'])) {
                echo '<div class="wpa-restore-wrapper">';
                echo '    <label>';
                echo '        <input type="checkbox" name="'.esc_attr($unique).'[_restore]" />';
                echo '        <span class="button wpa-button-restore">'.esc_html__('Restore', 'nutrail').'</span>';
                echo '        <span class="button wpa-button-cancel">'.sprintf('<small>( %s )</small> %s', esc_html__('update post for restore ', 'nutrail'), esc_html__('Cancel', 'nutrail')).'</span>';
                echo '    </label>';
                echo '</div>';
            }

            echo '</div>';
            echo ($has_nav) ? '<div class="wpa-nav-background"></div>' : '';
            echo '<div class="clear"></div>';
            echo '</div>';
            echo '</div>';

            do_action('wpa_html_comment_after');
        }

        // save metabox
        public function save_meta_box($post_id, $post)
        {
            if (wp_verify_nonce(wpa_get_var('wpa-comment-nonce'), 'wpa-comment')) {
                $errors = array();
                foreach ($this->sections as $request_value) {
                    $request_key = $request_value['id'];
                    $request     = wpa_get_var($request_key, array());
                    // ignore _nonce
                    if (isset($request['_nonce'])) {
                        unset($request['_nonce']);
                    }
                    // sanitize and validate
                    if (!empty($request_value['sections'])) {
                        foreach ($request_value['sections'] as $key => $section) {
                            if (!empty($section['fields'])) {
                                foreach ($section['fields'] as $field) {
                                    if (!empty($field['id'])) {
                                        // sanitize
                                        if (!empty($field['sanitize'])) {
                                            $sanitize = $field['sanitize'];
                                            if (function_exists($sanitize)) {
                                                $value_sanitize        = wpa_get_vars($request_key, $field['id']);
                                                $request[$field['id']] = call_user_func($sanitize, $value_sanitize);
                                            }
                                        }
                                        // validate
                                        if (!empty($field['validate'])) {
                                            $validate = $field['validate'];
                                            if (function_exists($validate)) {
                                                $value_validate = wpa_get_vars($request_key, $field['id']);
                                                $has_validated  = call_user_func($validate, $value_validate);
                                                if (!empty($has_validated)) {
                                                    $meta_value            = get_comment_meta($post_id, $request_key, true);
                                                    $errors[$field['id']]  = $has_validated;
                                                    $default_value         = isset($field['default']) ? $field['default'] : '';
                                                    $request[$field['id']] = (isset($meta_value[$field['id']])) ? $meta_value[$field['id']] : $default_value;
                                                }
                                            }
                                        }
                                        // auto sanitize
                                        if (!isset($request[$field['id']]) || is_null($request[$field['id']])) {
                                            $request[$field['id']] = '';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $request['_transient']['expires'] = round(microtime(true));
                    if (!empty($errors)) {
                        $request['_transient']['errors'] = $errors;
                    }
                    $request = apply_filters('wpa_save_comment_metabox', $request, $request_key, $post);

                    if (empty($request) || !empty($request['_restore'])) {
                        if (!empty($request_value['prefix'])) {
                            foreach ($request as $key => $value) {
                                if ($key != '_transient' && $key != '_restore' && $key != '_nonce') {
                                    delete_comment_meta($post_id, "{$request_value['prefix']}{$key}", $value);
                                }
                            }
                        }
                        delete_comment_meta($post_id, $request_key);
                    } else {
                        if (!empty($request_value['prefix'])) {
                            foreach ($request as $key => $value) {
                                if ($key != '_transient' && $key != '_restore' && $key != '_nonce') {
                                    unset($request[$key]);
                                    update_comment_meta($post_id, "{$request_value['prefix']}{$key}", $value);
                                }
                            }
                        }
                        update_comment_meta($post_id, $request_key, $request);
                    }
                }
            }
        }
    }
}
