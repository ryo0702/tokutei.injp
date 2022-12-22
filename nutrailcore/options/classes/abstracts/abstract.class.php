<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/**
 *
 * Abstract Class
 * A helper class for action and filter hooks
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Abstract')) {
    abstract class WPA_Abstract
    {
        /**
         * @access public
         * @var array
         */
        public $errors       = array();
        public $args         = array();
        public $sections     = array();
        public $options      = array();
        public $pre_tabs     = array();
        public $pre_fields   = array();
        public $pre_sections = array();
        public $abstract     = '';
        public $unique       = '';
        public $output_css   = '';
        public $typographies = array();

        public function __construct($bypass = false)
        {
            // By pass with fields
            if ($bypass) {
                return;
            }

            $use_webfont = !empty($this->args['enqueue_webfont']) && $this->args['enqueue_webfont'] == true;
            $use_output  = !empty($this->args['output_css']) && $this->args['output_css'] == true;

            // Check for embed google web fonts, custom css styles
            if ($use_webfont || $use_output) {
                add_action('wp_enqueue_scripts', array(&$this, 'collect_output_css_and_typography'));
            }

            // Loads scripts and styles only when needed
            add_action('admin_enqueue_scripts', array(&$this, 'enqueue_scripts'));
        }

        public function enqueue_scripts()
        {
            global $pagenow;

            $wpscreen = get_current_screen();

            if ($this->abstract == 'options') {
                if (substr($wpscreen->id, -strlen($this->args['menu_slug'])) === $this->args['menu_slug']) {
                    $this->load_field_scripts();
                }
            }
            if ($this->abstract == 'taxonomy') {
                foreach ($this->sections as $argument) {
                    if (in_array($wpscreen->taxonomy, (array) $argument['taxonomy'])) {
                        $this->load_field_scripts();
                    }
                }
            }
            if ($this->abstract == 'metabox') {
                foreach ($this->sections as $argument) {
                    $is_post_type = in_array($wpscreen->post_type, (array) $argument['post_type']);
                    $is_edit      = in_array($pagenow, array('post.php', 'post-new.php'));
                    if ($is_post_type && $is_edit) {
                        $this->load_field_scripts();
                    }
                }
            }
            if ($this->abstract == 'comment' && $wpscreen->id === 'comment') {
                $this->load_field_scripts();
            }
            if ($this->abstract == 'profile' && ($pagenow === 'profile.php' || $pagenow === 'user-new.php')) {
                $this->load_field_scripts();
            }
            if ($this->abstract == 'nav-menus' && $wpscreen->id === 'nav-menus') {
                $this->load_field_scripts();
            }
            if ($this->abstract == 'customize' && $wpscreen->id === 'customize') {
                $this->load_field_scripts();
            }
        }

        public function load_field_scripts()
        {
            if (!empty($this->sections)) {
                foreach ($this->sections as $section) {
                    WPA::set_used_fields($section);
                }
            }
            WPA::$enqueue = true;
        }

        public function get_tabs($sections)
        {
            $result  = array();
            $parents = array();
            $count   = 100;

            foreach ($sections as $key => $section) {
                if (!empty($section['parent'])) {
                    $section['priority']           = (isset($section['priority'])) ? $section['priority'] : $count;
                    $parents[$section['parent']][] = $section;
                    unset($sections[$key]);
                }
                $count++;
            }

            foreach ($sections as $key => $section) {
                $section['priority'] = (isset($section['priority'])) ? $section['priority'] : $count;
                if (!empty($section['id']) && !empty($parents[$section['id']])) {
                    $section['subs'] = wp_list_sort($parents[$section['id']], array('priority' => 'ASC'), 'ASC', true);
                }
                $result[] = $section;
                $count++;
            }

            return wp_list_sort($result, array('priority' => 'ASC'), 'ASC', true);
        }

        public function get_fields($sections)
        {
            $result   = array();
            $sections = $this->get_sections($sections);

            if (!empty($sections)) {
                foreach ($sections as $key => $section) {
                    if (!empty($section['fields'])) {
                        foreach ($section['fields'] as $field) {
                            if ($this->abstract === 'metabox') {
                                $field['meta_key']    = !empty($section['meta_key']) ? $section['meta_key'] : '';
                                $field['meta_prefix'] = !empty($section['meta_prefix']) ? $section['meta_prefix'] : '';
                            }
                            $result[] = $field;
                        }
                    } else {
                        $result[] = $section;
                    }
                }
            }

            return $result;
        }

        public function get_sections($sections)
        {
            $count  = 0;
            $result = array();

            if (!empty($sections)) {
                foreach ($sections as $tab) {
                    $count++;
                    if (!empty($tab['sections'])) {
                        foreach ($tab['sections'] as $key => $sub) {
                            if (!empty($tab['id'])) {
                                $sub['meta_key']    = $tab['id'];
                                $sub['meta_prefix'] = !empty($tab['prefix']) ? $tab['prefix'] : '';
                            }
                            $result[] = $sub;
                        }
                    } else {
                        $result[] = $tab;
                    }
                }
            }

            return $result;
        }

        // get default value
        public function get_default($field)
        {

            $default = (isset($field['default'])) ? $field['default'] : '';
            $default = (isset($this->args['defaults'][$field['id']])) ? $this->args['defaults'][$field['id']] : $default;

            return $default;

        }

        // save defaults and set new fields value to main options
        public function save_defaults()
        {

            $tmp_options = $this->options;

            foreach ($this->pre_fields as $field) {
                if (!empty($field['id']) && !isset($field['ignore'])) {
                    $this->options[$field['id']] = (isset($this->options[$field['id']])) ? $this->options[$field['id']] : $this->get_default($field);
                }
            }

            if ($this->args['save_defaults'] && empty($tmp_options)) {
                $this->save_options($this->options);
            }

        }

        // save options database
        public function save_options($data)
        {

            if ($this->args['database'] === 'transient') {
                set_transient($this->unique, $data, $this->args['transient_time']);
            } elseif ($this->args['database'] === 'theme_mod') {
                set_theme_mod($this->unique, $data);
            } elseif ($this->args['database'] === 'network') {
                update_site_option($this->unique, $data);
            } else {
                update_option($this->unique, $data);
            }

            do_action("wpa_{$this->unique}_saved", $data, $this);

        }

        // get options from database
        public function get_options()
        {

            if ($this->args['database'] === 'transient') {
                $this->options = get_transient($this->unique);
            } elseif ($this->args['database'] === 'theme_mod') {
                $this->options = get_theme_mod($this->unique);
            } elseif ($this->args['database'] === 'network') {
                $this->options = get_site_option($this->unique);
            } else {
                $this->options = get_option($this->unique);
            }

            if (empty($this->options)) {
                $this->options = array();
            }

            return $this->options;

        }

        public function error_check($sections, $err = '')
        {
            if (!empty($sections['fields'])) {
                foreach ($sections['fields'] as $field) {
                    if (!empty($field['id'])) {
                        if (array_key_exists($field['id'], (array) $this->errors)) {
                            $err = '<span class="wpa-label-error">!</span>';
                        }
                    }
                }
            }

            if (!empty($sections['sections'])) {
                foreach ($sections['sections'] as $sub) {
                    $err = $this->error_check($sub, $err);
                }
            }

            if (!empty($sections['id']) && array_key_exists($sections['id'], (array) $this->errors)) {
                $err = $this->errors[$sections['id']];
            }

            return $err;
        }

        public function get_meta_value($field)
        {
            $field_value = '';
            $default     = '';

            if (!empty($field['meta_key'])) {
                $meta_value = '';
                $meta_key   = !empty($field['meta_prefix']) ? "{$field['meta_prefix']}{$field['id']}" : $field['meta_key'];

                if ($this->abstract === 'taxonomy') {
                    $term = get_queried_object();
                    if (!is_wp_error($term) && !empty($term->term_id)) {
                        $meta_value = get_term_meta($term->term_id, $meta_key, true);
                    }
                } else {
                    $meta_value = get_post_meta(get_the_ID(), $meta_key, true);
                }

                if (!empty($field['meta_prefix'])) {
                    $field_value = !empty($meta_value) ? $meta_value : $default;
                } else {
                    $field_value = !empty($meta_value[$field['id']]) ? $meta_value[$field['id']] : $default;
                }
            }

            return $field_value;
        }

        public function collect_output_css_and_typography()
        {
            $fields = $this->get_fields($this->sections);
            $this->recursive_output_css($fields);
        }

        public function recursive_output_css($fields = array(), $combine_field = array())
        {
            if (!empty($fields)) {
                foreach ($fields as $field) {

                    $field_id     = (!empty($field['id'])) ? $field['id'] : '';
                    $field_type   = (!empty($field['type'])) ? $field['type'] : '';
                    $field_output = (!empty($field['output'])) ? $field['output'] : '';
                    $field_check  = ($field_type === 'typography' || $field_output) ? true : false;
                    $field_class  = 'WPA_Field_'.$field_type;

                    if ($field_type && $field_id) {

                        if ($field_type === 'fieldset') {
                            if (!empty($field['fields'])) {
                                $this->recursive_output_css($field['fields'], $field);
                            }
                            continue;
                        }

                        if ($field_type === 'accordion') {
                            if (!empty($field['accordions'])) {
                                foreach ($field['accordions'] as $accordion) {
                                    $this->recursive_output_css($accordion['fields'], $field);
                                }
                            }
                            continue;
                        }

                        if ($field_type === 'tabbed') {
                            if (!empty($field['tabs'])) {
                                foreach ($field['tabs'] as $accordion) {
                                    $this->recursive_output_css($accordion['fields'], $field);
                                }
                            }
                            continue;
                        }

                        WPA::maybe_include_field($field_type);

                        if (class_exists($field_class)) {

                            if (method_exists($field_class, 'output') || method_exists($field_class, 'enqueue_google_fonts')) {

                                $field_value = '';

                                if ($field_check && ($this->abstract === 'options' || $this->abstract === 'customize')) {

                                    $options = $this->get_options();

                                    if (!empty($combine_field)) {

                                        $field_value = (isset($options[$combine_field['id']][$field_id])) ? $options[$combine_field['id']][$field_id] : '';

                                    } else {

                                        $field_value = (isset($options[$field_id])) ? $options[$field_id] : '';

                                    }

                                } elseif ($field_check && ($this->abstract === 'metabox' && is_singular() || $this->abstract === 'taxonomy' && is_archive())) {

                                    if (!empty($combine_field)) {

                                        $meta_value  = $this->get_meta_value($combine_field);
                                        $field_value = (isset($meta_value[$field_id])) ? $meta_value[$field_id] : '';

                                    } else {

                                        $meta_value  = $this->get_meta_value($field);
                                        $field_value = (isset($meta_value)) ? $meta_value : '';

                                    }

                                }

                                $instance = new $field_class($field, $field_value, $this->unique, 'wp/enqueue', $this);

                                // typography enqueue and embed google web fonts
                                if ($field_type === 'typography' && $this->args['enqueue_webfont'] && !empty($field_value['font-family'])) {

                                    $method = (!empty($this->args['async_webfont'])) ? 'async' : 'enqueue';

                                    $instance->enqueue_google_fonts($method);

                                }

                                // output css
                                if ($field_output && $this->args['output_css']) {
                                    WPA::$css .= $instance->output();
                                }

                                unset($instance);

                            }
                        }
                    }
                }
            }
        }
    }
}
