<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/**
 *
 * Customize Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Customize')) {
    class WPA_Customize extends WPA_Abstract
    {
        // constants
        public $priority = 1;
        public $options  = array();
        public $sections = array();
        public $abstract = 'customize';
        // default args
        public $args = array(
            'option_name'     => '_wpa_customize_options',

            // database model
            'database'        => 'options',

            // typography options
            'enqueue_webfont' => false,
            'async_webfont'   => false,

            // others
            'output_css'      => false,

            // external default values
            'save_defaults'   => true,
            'defaults'        => array(),
        );

        // run customize construct
        public function __construct($args, $params = array())
        {
            // Get options customize
            $this->args     = apply_filters("wpa_customize_{$this->unique}_settings", wp_parse_args($args, $this->args), $this);
            $this->sections = apply_filters("wpa_customize_{$this->unique}_options", $params);
            $this->unique   = $this->args['option_name'];

            // framework init
            add_action('admin_init', array(&$this, 'setup'));

            // Actions customize
            add_action('customize_register', array(&$this, 'add_customize_options'));

            // wp enqueue for typography and output css
            parent::__construct();
        }

        // instance
        public static function instance($args, $params = array())
        {
            return new self($args, $params);
        }

        public function setup()
        {
            // run only is admin panel options, avoid performance loss
            $this->pre_fields = $this->get_fields($this->sections);

            // Default framework
            $this->get_options();
            $this->save_defaults();
        }

        public function add_customize_options($wp_customize)
        {
            // load extra WP_Customize_Control
            WPA::include_plugin_file('includes/customize.php');

            $panel_priority = 1;

            foreach ($this->sections as $value) {
                $this->priority = $panel_priority;
                if (isset($value['sections'])) {
                    $unique_id = $this->unique.'-'.sanitize_title($value['name']);
                    $wp_customize->add_panel(new WP_Customize_Panel_WPA($wp_customize, $unique_id,
                            array(
                                'title'       => $value['title'],
                                'priority'    => (isset($value['priority'])) ? $value['priority'] : $panel_priority,
                                'description' => (isset($value['description'])) ? $value['description'] : '',
                            )
                        )
                    );
                    $this->add_section($wp_customize, $value, $unique_id);
                } else {
                    $this->add_section($wp_customize, $value);
                }
                $panel_priority++;
            }
        }

        // add customize section
        public function add_section($wp_customize, $value, $panel = false)
        {
            $priority = ($panel) ? 1 : $this->priority;
            $sections = ($panel) ? $value['sections'] : array('sections' => $value);
            foreach ($sections as $section) {
                $section_name = !empty($section['name']) ? $section['name'] : $section['title'];
                $section_name = sanitize_title($section_name);
                $section_id   = $this->unique.'-'.$section_name;
                $wp_customize->add_section(new WP_Customize_Section_WPA($wp_customize, $section_id, array(
                            'title'       => $section['title'],
                            'priority'    => (isset($section['priority'])) ? $section['priority'] : $priority,
                            'description' => (isset($section['description'])) ? $section['description'] : '',
                            'panel'       => ($panel) ? $panel : '',
                        )
                    )
                );
                $field_priority = 1;
                if (!empty($section['fields'])) {
                    foreach ($section['fields'] as $field) {
                        $field_id        = (isset($field['id'])) ? $field['id'] : sanitize_title('-nonce-'.$section_name.'-'.$field_priority);
                        $setting_id      = $this->unique.'['.$field_id.']';
                        $setting_args    = (isset($field['setting_args'])) ? $field['setting_args'] : array();
                        $control_args    = (isset($field['control_args'])) ? $field['control_args'] : array();
                        $field_default   = (isset($field['default'])) ? $field['default'] : '';
                        $field_sanitize  = (isset($field['sanitize'])) ? $field['sanitize'] : '';
                        $field_validate  = (isset($field['validate'])) ? $field['validate'] : '';
                        $field_transport = (isset($field['transport'])) ? $field['transport'] : 'refresh';
                        $wp_customize->add_setting($setting_id,
                            wp_parse_args($setting_args, array(
                                    'default'           => $field_default,
                                    'type'              => 'option',
                                    'transport'         => $field_transport,
                                    'capability'        => 'edit_theme_options',
                                    'sanitize_callback' => $field_sanitize,
                                    'validate_callback' => $field_validate,
                                )
                            )
                        );
                        $wp_customize->add_control(new WP_Customize_Control_WPA($wp_customize, $setting_id,
                                wp_parse_args($control_args, array(
                                        'unique'   => $this->unique,
                                        'field'    => $field,
                                        'section'  => $section_id,
                                        'settings' => $setting_id,
                                        'priority' => $field_priority,
                                    )
                                )
                            )
                        );
                        if (isset($field['selective_refresh']) && isset($wp_customize->selective_refresh)) {
                            $wp_customize->selective_refresh->add_partial($setting_id, array(
                                'selector'            => $field['selective_refresh'],
                                'container_inclusive' => true,
                            ));
                        }
                        $field_priority++;
                    }
                }
                $priority++;
            }
        }
    }
}
