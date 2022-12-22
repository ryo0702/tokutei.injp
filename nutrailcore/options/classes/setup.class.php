<?php
if (!defined('ABSPATH')) {
    die;
}

/**
 * WPA - WordPress Admin Options
 * Domain: wpa
 */

if (!class_exists('WPA')) {
    class WPA
    {
        /**
         * Version
         */
        public static $version = '1.0.0';
        /**
         *
         * instance
         * @access private
         * @var WPA
         */
        private static $instance = null;
        /**
         * constants
         */
        public static $css        = '';
        public static $file       = '';
        public static $widget_css = array();
        public static $dir        = null;
        public static $url        = null;
        public static $suffix     = null;
        public static $webfonts   = array();
        public static $subsets    = array();
        public static $fields     = array();
        public static $enqueue    = false;
        public static $complex    = array(
            'accordion',
            'background',
            'border',
            'button_set',
            'checkbox',
            'color_group',
            'date',
            'dimensions',
            'fieldset',
            'group',
            'image_select',
            'link',
            'link_color',
            'media',
            'palette',
            'repeater',
            'sortable',
            'sorter',
            'spacing',
            'switcher',
            'tabbed',
            'typography'
        );

        // instance
        public static function instance($file = __FILE__)
        {
            // Set file constant
            self::$file = $file;

            /* check for developer mode */
            self::$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

            // set constants
            self::constants();

            // include files
            self::includes();

            if (is_null(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        // Initialize
        public function __construct()
        {
            // init action
            do_action('wpa_init');

            // enqueue frontend scripts
            add_action('wp_enqueue_scripts', array($this, 'frontend_scripts'), 30);
            add_action('wp_footer', array($this, 'footer_scripts'), 30);

            // enqueue scripts
            add_action('admin_enqueue_scripts', array($this, 'register_scripts'));
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'), 30);

            // enqueue scripts elementor
            add_action('elementor/editor/before_enqueue_scripts', array($this, 'register_scripts'));
            add_action('elementor/editor/after_enqueue_scripts', array($this, 'enqueue_scripts'));
        }

        public static function include_plugin_file($file, $load = true)
        {
            $path     = '';
            $file     = ltrim($file, '/');
            $override = apply_filters('wpa_options_override_template', 'wpa-options');

            if (file_exists(get_parent_theme_file_path($override.'/'.$file))) {
                $path = get_parent_theme_file_path($override.'/'.$file);
            } elseif (file_exists(get_theme_file_path($override.'/'.$file))) {
                $path = get_theme_file_path($override.'/'.$file);
            } elseif (file_exists(self::$dir.'/'.$override.'/'.$file)) {
                $path = self::$dir.'/'.$override.'/'.$file;
            } elseif (file_exists(self::$dir.'/'.$file)) {
                $path = self::$dir.'/'.$file;
            }

            if (!empty($path) && !empty($file) && $load) {

                global $wp_query;

                if (is_object($wp_query) && function_exists('load_template')) {

                    load_template($path, true);

                } else {

                    require_once($path);

                }

            } else {

                return self::$dir.'/'.$file;

            }

            return self::$dir;
        }

        // Sanitize dirname
        public static function sanitize_dirname($dirname)
        {
            return preg_replace('/[^A-Za-z]/', '', $dirname);
        }

        // Set plugin url
        public static function include_plugin_url($file)
        {
            return esc_url(self::$url).'/'.ltrim($file, '/');
        }

        // Define constants
        public static function constants()
        {
            // We need this path-finder code for set URL of framework
            $dirname        = str_replace('//', '/', wp_normalize_path(dirname(dirname(self::$file))));
            $theme_dir      = str_replace('//', '/', wp_normalize_path(get_parent_theme_file_path()));
            $plugin_dir     = str_replace('//', '/', wp_normalize_path(WP_PLUGIN_DIR));
            $plugin_dir     = str_replace('/opt/bitnami', '/bitnami', $plugin_dir);
            $located_plugin = (preg_match('#'.self::sanitize_dirname($plugin_dir).'#', self::sanitize_dirname($dirname))) ? true : false;
            $directory      = ($located_plugin) ? $plugin_dir : $theme_dir;
            $directory_uri  = ($located_plugin) ? WP_PLUGIN_URL : get_parent_theme_file_uri();
            $foldername     = str_replace($directory, '', $dirname);
            $protocol_uri   = (is_ssl()) ? 'https' : 'http';
            $directory_uri  = set_url_scheme($directory_uri, $protocol_uri);

            self::$dir = $dirname;
            self::$url = $directory_uri.$foldername;
        }

        // Includes options files
        public static function includes()
        {
            // includes helpers
            self::include_plugin_file('includes/helpers.php');
            self::include_plugin_file('includes/deprecated.php');
            self::include_plugin_file('includes/fallback.php');
            self::include_plugin_file('includes/actions.php');
            self::include_plugin_file('includes/sanitize.php');
            self::include_plugin_file('includes/validate.php');
            // self::include_plugin_file('includes/blocks.php');

            // includes abstract
            self::include_plugin_file('classes/abstracts/abstract.class.php');
            self::include_plugin_file('classes/abstracts/abstract-fields.php');
            self::include_plugin_file('classes/abstracts/abstract-breadcrumb.php');
            // self::include_plugin_file('classes/abstracts/abstract-colors.php');
            // self::include_plugin_file('classes/abstracts/abstract-widget.php');

            // includes classes
            self::include_plugin_file('classes/class-options.php');
            self::include_plugin_file('classes/class-metabox.php');
            // self::include_plugin_file('classes/class-taxonomy.php');
            // self::include_plugin_file('classes/class-profile.php');
            // self::include_plugin_file('classes/class-shortcode.php');
            // self::include_plugin_file('classes/class-customize.php');
            // self::include_plugin_file('classes/class-comment.php');
            // self::include_plugin_file('classes/class-nav-menu.php');

            // includes callback
            do_action('wpa_after_includes');
        }

        //
        // Enqueue frontend scripts.
        public static function frontend_scripts()
        {
            // Font awesome 4 and 5 loader
            if (WPA::get_config('fontawesome') == 'fa4') {

                wp_enqueue_style('font-awesome', WPA::include_plugin_url('assets/lib/font-awesome/css/font-awesome-4.7.0.min.css'), null, '4.7.0');

            } elseif (WPA::get_config('fontawesome') == 'fa5') {

                wp_enqueue_style('wpa-fa5', WPA::include_plugin_url('assets/lib/font-awesome/css/font-awesome-5.15.4.min.css'), null, '5.15.4');

                if (WPA::get_config('fa4_support') == 1) {

                    wp_enqueue_style('wpa-fa5-v4-shims', WPA::include_plugin_url('assets/lib/font-awesome/css/v4-shims.min.css'), null, '5.15.4');

                }
            }

            // Typography loader
            WPA::add_typography_enqueue_styles();
        }

        //
        // Enqueue inline scripts.
        public static function footer_scripts()
        {
            $global_id = 'wpa-global-css';
            $type_attr = current_theme_supports('html5', 'style') ? '' : ' type="text/css"';

            // Widgets css loader
            if (!is_customize_preview() && !empty(WPA::$widget_css)) {
                WPA::$css .= implode('', WPA::$widget_css);
            }

            // Custom css loader
            WPA::$css = apply_filters('wpa_options_output_css', WPA::$css);
            if (!empty(WPA::$css)) {
                $href = 'data:text/css;charset=utf-8,'.rawurlencode(strip_tags(WPA::$css)).'';
                echo '<link rel="stylesheet" id="'.esc_attr($global_id).'" type="text/css" href="'.$href.'" />';
            }

            // script preview
            if (is_customize_preview()) {
                echo '<style'.$type_attr.'>';
                echo '.widget{position: relative}';
                echo '.widget .customize-partial-edit-shortcut{width:100%;height:100%;top:0;left:0;right:0;bottom:0}';
                echo '</style>';
            }
        }

        /**
         * Get the config.
         *
         * @param  string  $key
         * @param  bool  $default
         *
         * @return string
         */
        public static function get_config($key = '', $default = false)
        {
            $args   = array(
                'fa4_support' => false,
                'fontawesome' => '',
            );
            $key    = trim($key);
            $config = array();
            $config = wp_parse_args($config, $args);

            if (empty($key)) {
                return $config;
            }

            if (!empty($config[$key])) {
                return $config[$key];
            }

            return $default;
        }

        public static function disable_scripts()
        {
            $wpscreen = function_exists('get_current_screen') ? get_current_screen() : array();
            $include  = apply_filters('wpa_screen_enqueue_scripts', [
                'widgets',
                'customize',
            ]);

            if (apply_filters('wpa_admin_enqueue_scripts', false) == true) {
                return false;
            }

            if (WPA::is_elementor_editor()) {
                return false;
            }

            if (is_admin() && !empty($wpscreen->id) && in_array($wpscreen->id, $include)) {
                return false;
            }

            if (!WPA::$enqueue) {
                return true;
            }

            return false;
        }

        /**
         * is Elementor editor?
         *
         * @return bool
         */
        public static function is_elementor_editor()
        {
            if (class_exists('Elementor\Plugin')) {
                if (Elementor\Plugin::$instance->preview->is_preview_mode() || Elementor\Plugin::$instance->editor->is_edit_mode()) {
                    return true;
                }
            }

            return false;
        }

        //
        // Register admin scripts.
        public static function enqueue_scripts()
        {
            if (WPA::disable_scripts()) {
                return;
            }

            /* admin utilities */
            wp_enqueue_media();

            /* wp color picker */
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');

            /* Font Awesome */
            wp_enqueue_style('wpa-fa5', WPA::include_plugin_url('assets/lib/font-awesome/css/font-awesome-5.15.4.min.css'), null, '5.15.4');
            wp_enqueue_style('wpa-fa5-v4-shims', WPA::include_plugin_url('assets/lib/font-awesome/css/v4-shims.min.css'), null, '5.15.4');

            /* Main style */
            wp_enqueue_style('wpa-options');
            wp_enqueue_style('wpa-options-custom');

            /* Main RTL styles */
            if (is_rtl()) {
                wp_enqueue_style('wpa-options-rtl');
            }

            /* Main scripts */
            wp_enqueue_script('wpa-options');

            /* Main variables */
            wp_localize_script('wpa-options', 'wpa_vars', array(
                    'color_palette' => apply_filters('wpa_color_palette', array()),
                    'i18n'          => array(
                        // global localize
                        'confirm'             => esc_html__('Are you sure?', 'nutrail'),
                        'reset_notification'  => esc_html__('Restoring options.', 'nutrail'),
                        'import_notification' => esc_html__('Importing options.', 'nutrail'),

                        // chosen localize
                        'typing_text'         => esc_html__('Please enter %s or more characters', 'nutrail'),
                        'searching_text'      => esc_html__('Searching...', 'nutrail'),
                        'no_results_text'     => esc_html__('No results match', 'nutrail'),
                    ),
                    'is_preview'    => WPA::is_elementor_editor(),
                )
            );

            // Enqueue fields scripts and styles
            foreach (WPA::$fields as $field_type => $value) {
                $classname = 'WPA_Field_'.$field_type;
                WPA::maybe_include_field($field_type);
                if (class_exists($classname) && method_exists($classname, 'enqueue')) {
                    $instance = new $classname(array('type' => $field_type));
                    if (method_exists($classname, 'enqueue')) {
                        $instance->enqueue();
                    }
                    unset($instance);
                }
            }

            do_action('wpa_after_enqueue');

        }

        //
        // Enqueue admin scripts.
        public static function register_scripts()
        {
            /* Main style */
            wp_register_style('wpa-options', WPA::include_plugin_url('assets/css/style'.self::$suffix.'.css'), null, WPA::$version);
            wp_register_style('wpa-options-custom', WPA::include_plugin_url('assets/css/custom'.self::$suffix.'.css'), null, WPA::$version);

            /* Main RTL styles */
            wp_register_style('wpa-options-rtl', WPA::include_plugin_url('assets/css/style-rtl'.self::$suffix.'.css'), null, WPA::$version);

            /* Main scripts */
            wp_register_script('wpa-plugins', WPA::include_plugin_url('assets/js/plugins'.self::$suffix.'.js'), array('jquery'), WPA::$version, true);
            wp_register_script('wpa-options', WPA::include_plugin_url('assets/js/main'.self::$suffix.'.js'), array('wpa-plugins'), WPA::$version, true);
        }

        // Add typography enqueue styles to front page
        public static function add_typography_enqueue_styles()
        {

            if (!empty(self::$webfonts)) {

                if (!empty(self::$webfonts['enqueue'])) {

                    $query = array();
                    $fonts = array();

                    foreach (self::$webfonts['enqueue'] as $family => $styles) {
                        $fonts[] = $family.((!empty($styles)) ? ':'.implode(',', $styles) : '');
                    }

                    if (!empty($fonts)) {
                        $query['family'] = implode('%7C', $fonts);
                    }

                    if (!empty(self::$subsets)) {
                        $query['subset'] = implode(',', self::$subsets);
                    }

                    $query['display'] = 'swap';

                    wp_enqueue_style('wpa-google-web-fonts', esc_url(add_query_arg($query, '//fonts.googleapis.com/css')), array(), null);

                }

                if (!empty(self::$webfonts['async'])) {

                    $fonts = array();

                    foreach (self::$webfonts['async'] as $family => $styles) {
                        $fonts[] = $family.((!empty($styles)) ? ':'.implode(',', $styles) : '');
                    }

                    wp_enqueue_script('wpa-google-web-fonts', esc_url('//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js'), array(), null, true);

                    wp_localize_script('wpa-google-web-fonts', 'WebFontConfig', array('google' => array('families' => $fonts)));

                }

            }

        }

        // Set all of used fields
        public static function set_used_fields($sections)
        {
            $fields = [];
            if (!empty($sections['sections'])) {
                $fields = $sections['sections'];
            }
            if (!empty($sections['fields'])) {
                $fields = $sections['fields'];
            }
            if (!empty($fields)) {
                foreach ($fields as $field) {
                    if (!empty($field['fields'])) {
                        self::set_used_fields($field);
                    }
                    if (!empty($field['tabs'])) {
                        self::set_used_fields(['fields' => $field['tabs']]);
                    }
                    if (!empty($field['accordions'])) {
                        self::set_used_fields(['fields' => $field['accordions']]);
                    }
                    if (!empty($field['type'])) {
                        self::$fields[$field['type']] = $field;
                    }
                }
            }
        }

        // Include field
        public static function maybe_include_field($type = '')
        {
            if (!class_exists("WPA_Field_{$type}") && class_exists('WPA_Fields')) {
                self::include_plugin_file("fields/{$type}/{$type}.php");
            }
        }

        //
        // Add a new framework field
        public static function field($field = array(), $value = '', $unique = '', $where = '', $parent = '')
        {
            // language for fields
            $languages = wpa_language_defaults();

            // Check for unallow fields
            if (!empty($field['_notice'])) {
                $field_type       = $field['type'];
                $field            = array();
                $field['content'] = esc_html__('Oops! Not allowed.', 'nutrail').' <strong>('.$field_type.')</strong>';
                $field['type']    = 'notice';
                $field['class']   = 'danger';
            }

            $output     = '';
            $depend     = '';
            $visible    = '';
            $unique     = (!empty($unique)) ? $unique : '';
            $class      = (!empty($field['class'])) ? ' '.esc_attr($field['class']) : '';
            $hidden     = (!empty($field['show_only_language']) && ($field['show_only_language'] != $languages['current'])) ? ' hidden' : '';
            $is_pseudo  = (!empty($field['pseudo'])) ? ' wpa-pseudo-field' : '';
            $field_type = (!empty($field['type'])) ? esc_attr($field['type']) : '';

            if (!empty($field['dependency'])) {

                $dependency      = $field['dependency'];
                $depend_visible  = '';
                $data_controller = '';
                $data_condition  = '';
                $data_value      = '';
                $data_global     = '';

                if (is_array($dependency[0])) {
                    $data_controller = implode('|', array_column($dependency, 0));
                    $data_condition  = implode('|', array_column($dependency, 1));
                    $data_value      = implode('|', array_column($dependency, 2));
                    $data_global     = implode('|', array_column($dependency, 3));
                    $depend_visible  = implode('|', array_column($dependency, 4));
                } else {
                    $data_controller = (!empty($dependency[0])) ? $dependency[0] : '';
                    $data_condition  = (!empty($dependency[1])) ? $dependency[1] : '';
                    $data_value      = (!empty($dependency[2])) ? $dependency[2] : '';
                    $data_global     = (!empty($dependency[3])) ? $dependency[3] : '';
                    $depend_visible  = (!empty($dependency[4])) ? $dependency[4] : '';
                }

                $depend .= ' data-controller="'.esc_attr($data_controller).'"';
                $depend .= ' data-condition="'.esc_attr($data_condition).'"';
                $depend .= ' data-value="'.esc_attr($data_value).'"';
                $depend .= (!empty($data_global)) ? ' data-depend-global="true"' : '';

                $visible = (!empty($depend_visible)) ? ' wpa-depend-visible' : ' wpa-depend-hidden';

            }

            $output .= '<div class="wpa-field wpa-field-'.$field_type.$is_pseudo.$class.$hidden.$visible.'"'.$depend.'>';

            if (!empty($field_type)) {

                if (!empty($field['fancy_title'])) {
                    $output .= '<div class="wpa-fancy-title">'.$field['fancy_title'].'</div>';
                }

                if (!empty($field['title'])) {
                    $output .= '<div class="wpa-title">';
                    $output .= '<h4>'.$field['title'].'</h4>';
                    $output .= (!empty($field['subtitle'])) ? '<div class="wpa-text-subtitle">'.$field['subtitle'].'</div>' : '';
                    $output .= (!empty($field['desc'])) ? '<div class="wpa-text-desc">'.$field['desc'].'</div>' : '';
                    $output .= '</div>';
                }

                $output .= (!empty($field['title']) || !empty($field['fancy_title'])) ? '<div class="wpa-fieldset">' : '';

                $value     = (!isset($value) && isset($field['default'])) ? $field['default'] : $value;
                $value     = (isset($field['value'])) ? $field['value'] : $value;
                $classname = 'WPA_Field_'.$field_type;

                WPA::maybe_include_field($field_type);

                if (class_exists($classname)) {
                    ob_start();
                    $instance = new $classname($field, $value, $unique, $where, $parent);
                    $instance->render();
                    $output .= ob_get_clean();
                } else {
                    $output .= '<p>'.esc_html__('Field not found!', 'nutrail').'</p>';
                }

            } else {
                $output .= '<p>'.esc_html__('Field not found!', 'nutrail').'</p>';
            }

            $output .= (!empty($field['title']) || !empty($field['fancy_title'])) ? '</div>' : '';
            $output .= '<div class="clear"></div>';
            $output .= '</div>';

            return $output;
        }

        //
        // Create custom field class
        public static function createField($field = array(), $is_ajax = false)
        {
            if (!isset($field['type'])) {
                return '';
            }

            $output    = '';
            $onload    = ($is_ajax) ? ' wpa-onload' : '';
            $classname = 'WPA_Field_'.$field['type'];

            WPA::maybe_include_field($field['type']);

            $output .= '<div class="wpa-field-custom'.$onload.'">';

            if (class_exists($classname) && method_exists($classname, 'enqueue')) {
                $instance = new $classname($field);
                if (method_exists($classname, 'enqueue')) {
                    $instance->enqueue();
                }
                unset($instance);
            }

            $output .= self::field($field);

            $output .= '</div>';

            return $output;
        }

        /**
         * placeholder svg
         *
         * source: data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30"></svg>
         *
         * @param $width
         * @param $height
         *
         * @param  bool  $image
         *
         * @return string
         */
        public static function image_svg($width, $height, $image = false)
        {
            $data = "data:image/svg+xml;charset=utf-8,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22{$width}%22%20height%3D%22{$height}%22%20viewBox%3D%220%200%20{$width}%20{$height}%22%3E%3C%2Fsvg%3E";

            if (!$image) {
                return $data;
            }

            return "<img src='{$data}' width='{$width}' height='{$height}' alt='".get_site_url()."'/>";
        }
    }
}

/**
 * Returns the main instance of WPA.
 *
 * @return WPA
 * @since  1.0
 */
function WPA()
{ // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
    return WPA::instance(__FILE__);
}

// Global for backwards compatibility.
$GLOBALS['nutrail'] = WPA();