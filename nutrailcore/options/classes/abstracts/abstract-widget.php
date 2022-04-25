<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Abstract Widget Class
 *
 * @category Widgets
 * @version  2.5.0
 * @extends  WP_Widget
 */
abstract class WPA_Widget extends WP_Widget
{
    /**
     * CSS class.
     *
     * @var string
     */
    public $widget_cssclass;
    /**
     * Widget description.
     *
     * @var string
     */
    public $widget_description;
    /**
     * Widget ID.
     *
     * @var string
     */
    public $widget_id;
    /**
     * Widget name.
     *
     * @var string
     */
    public $widget_name;
    /**
     * Settings.
     *
     * @var array
     */
    public $settings;
    /**
     * Output css.
     *
     * @var array
     */
    public $output_css;
    /**
     * Global css.
     *
     * @var array
     */
    public $global_css = false;
    /**
     * ID field.
     *
     * @var array
     */
    public $field_id = '';
    /**
     * Cache ID.
     *
     * @var array
     */
    public $cache_id = '';

    /**
     * Whether or not the widget has been registered yet.
     *
     * @since 4.8.1
     * @var bool
     */
    protected $registered = false;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $widget_ops = array(
            'classname'                   => $this->widget_cssclass,
            'description'                 => $this->widget_description,
            'customize_selective_refresh' => true,
            'show_instance_in_rest'       => true,
        );

        // widget default
        $this->widget_advanced();

        parent::__construct($this->widget_id, $this->widget_name, $widget_ops);

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    public function widget_advanced()
    {
        $this->settings = array_merge($this->settings, array(
            'widget-animation' => array(
                'id'         => 'widget-animation',
                'type'       => 'select',
                'title'      => 'Animate',
                'attributes' => array(
                    'style' => 'width: 100%'
                ),
                'options'    => array(
                    ''                  => 'None',
                    'Fading'            => [
                        'fadeIn'      => 'Fade In',
                        'fadeInDown'  => 'Fade In Down',
                        'fadeInLeft'  => 'Fade In Left',
                        'fadeInRight' => 'Fade In Right',
                        'fadeInUp'    => 'Fade In Up',
                    ],
                    'Zooming'           => [
                        'zoomIn'      => 'Zoom In',
                        'zoomInDown'  => 'Zoom In Down',
                        'zoomInLeft'  => 'Zoom In Left',
                        'zoomInRight' => 'Zoom In Right',
                        'zoomInUp'    => 'Zoom In Up',
                    ],
                    'Bouncing'          => [
                        'bounceIn'      => 'Bounce In',
                        'bounceInDown'  => 'Bounce In Down',
                        'bounceInLeft'  => 'Bounce In Left',
                        'bounceInRight' => 'Bounce In Right',
                        'bounceInUp'    => 'Bounce In Up',
                    ],
                    'Sliding'           => [
                        'slideInDown'  => 'Slide In Down',
                        'slideInLeft'  => 'Slide In Left',
                        'slideInRight' => 'Slide In Right',
                        'slideInUp'    => 'Slide In Up',
                    ],
                    'Rotating'          => [
                        'rotateIn'          => 'Rotate In',
                        'rotateInDownLeft'  => 'Rotate In Down Left',
                        'rotateInDownRight' => 'Rotate In Down Right',
                        'rotateInUpLeft'    => 'Rotate In Up Left',
                        'rotateInUpRight'   => 'Rotate In Up Right',
                    ],
                    'Attention Seekers' => [
                        'bounce'     => 'Bounce',
                        'flash'      => 'Flash',
                        'pulse'      => 'Pulse',
                        'rubberBand' => 'Rubber Band',
                        'shake'      => 'Shake',
                        'headShake'  => 'Head Shake',
                        'swing'      => 'Swing',
                        'tada'       => 'Tada',
                        'wobble'     => 'Wobble',
                        'jello'      => 'Jello',
                    ],
                    'Light Speed'       => [
                        'lightSpeedIn' => 'Light Speed In',
                    ],
                    'Specials'          => [
                        'rollIn' => 'Roll In',
                    ],
                ),
                'default'    => '',
            ),
            'widget-class'     => array(
                'id'    => 'widget-class',
                'type'  => 'text',
                'title' => 'Class',
            ),
        ));
    }

    /**
     * Add hooks while registering all widget instances of this widget class.
     *
     * @param int $number Optional. The unique order number of this widget instance
     *                    compared to other instances of the same class. Default -1.
     *
     * @since 4.8.0
     *
     */
    public function _register_one($number = -1)
    {
        parent::_register_one($number);
        if ($this->registered) {
            return;
        }
        $this->registered = true;

        // Note this action is used to ensure the help text is added to the end.
        add_action('load-widgets.php', array($this, 'load_field_scripts'));
        add_action('elementor/editor/before_enqueue_scripts', array($this, 'load_field_scripts'));

        // Note that the widgets component in the customizer will also do
        // the 'admin_print_scripts-widgets.php' action in WP_Customize_Widgets::print_scripts().
        add_action('admin_print_scripts-widgets.php', array($this, 'enqueue_admin_scripts'));

        // Enqueue preview scripts.
        add_action('wp_enqueue_scripts', array($this, 'enqueue_preview_scripts'));
    }

    public function generate_id($instance)
    {
        $instance['widget_id'] = $this->id;
        $collect               = json_encode($instance);

        return substr(md5($collect), 0, 6);
    }

    public function collect_output_css_and_typography($instance)
    {
        $args  = array('widget_id' => $this->cache_id);
        $cache = $this->get_cached_widget($args);
        if ($this->is_preview() || WPA::is_elementor_editor()) {
            $cache = false;
        }

        if ($cache !== false) {
            WPA::$widget_css[$this->cache_id] = $cache;

            return;
        }

        $this->recursive_output_css($this->settings, $instance);
        $this->cache_widget($args, (!empty(WPA::$widget_css[$this->cache_id])) ? WPA::$widget_css[$this->cache_id] : '');

        if ($this->is_preview() || WPA::is_elementor_editor()) {
            $type_attr = current_theme_supports('html5', 'style') ? '' : ' type="text/css"';
            echo '<style'.$type_attr.' id="'.esc_attr($this->cache_id).'">';
            echo strip_tags((!empty(WPA::$widget_css[$this->cache_id])) ? WPA::$widget_css[$this->cache_id] : '');
            echo '</style>';
        }
    }

    public function recursive_output_css($fields = array(), $instance = array(), $combine_field = array())
    {
        if (!empty($fields) && !empty($instance)) {

            foreach ($fields as $id => $field) {

                $field_id     = (!empty($field['id'])) ? $field['id'] : $id;
                $field_type   = (!empty($field['type'])) ? $field['type'] : '';
                $field_output = (isset($field['output'])) ? ".{$this->field_id} {$field['output']}" : '';
                $field_check  = ($field_type === 'typography' || $field_output) ? true : false;
                $field_class  = 'WPA_Field_'.$field_type;

                if ($field_type && $field_id) {

                    if ($field_type === 'fieldset') {
                        if (!empty($field['fields'])) {
                            $this->recursive_output_css($field['fields'], $instance, $field);
                        }
                        continue;
                    }

                    if ($field_type === 'accordion') {
                        if (!empty($field['accordions'])) {
                            foreach ($field['accordions'] as $accordion) {
                                $this->recursive_output_css($accordion['fields'], $instance, $field);
                            }
                        }
                        continue;
                    }

                    if ($field_type === 'tabbed') {
                        if (!empty($field['tabs'])) {
                            foreach ($field['tabs'] as $accordion) {
                                $this->recursive_output_css($accordion['fields'], $instance, $field);
                            }
                        }
                        continue;
                    }

                    WPA::maybe_include_field($field_type);

                    if (class_exists($field_class)) {

                        if (method_exists($field_class, 'output') || method_exists($field_class, 'enqueue_google_fonts')) {

                            $field['output'] = $field_output;
                            $options         = ($field_check && !empty($instance)) ? $instance : '';

                            if (!empty($combine_field)) {
                                $field_value = (isset($options[$combine_field['id']][$field_id])) ? $options[$combine_field['id']][$field_id] : '';
                            } else {
                                $field_value = (isset($options[$field_id])) ? $options[$field_id] : '';
                            }

                            $widget = new $field_class($field, $field_value, '', 'wp/enqueue', $this);

                            // typography enqueue and embed google web fonts
                            if ($field_type === 'typography' && !empty($field_value['font-family'])) {

                                $widget->enqueue_google_fonts('enqueue');

                            }
                            // output css
                            if ($field_output) {
                                if (!isset(WPA::$widget_css[$this->cache_id])) {
                                    WPA::$widget_css[$this->cache_id] = '';
                                }
                                WPA::$widget_css[$this->cache_id] .= $widget->output();
                            }

                            unset($widget);

                        }
                    }
                }
            }
        }
    }

    /**
     * Get cached widget.
     *
     * @param array $args Arguments.
     *
     * @return bool true if the widget is cached otherwise false
     */
    public function get_cached_widget($args)
    {
        // Don't get cache if widget_id doesn't exists.
        if (empty($args['widget_id'])) {
            return false;
        }

        $cache = get_transient($this->get_widget_id_for_cache($this->widget_id));

        if (!is_array($cache)) {
            $cache = array();
        }

        if (isset($cache[$this->get_widget_id_for_cache($args['widget_id'])])) {
            return $cache[$this->get_widget_id_for_cache($args['widget_id'])]; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
        }

        return false;
    }

    /**
     * Cache the widget.
     *
     * @param array $args Arguments.
     * @param string $content Content.
     */
    public function cache_widget($args, $content)
    {
        // Don't set any cache if widget_id doesn't exist.
        if (empty($args['widget_id'])) {
            return;
        }

        $cache = get_transient($this->get_widget_id_for_cache($this->widget_id));

        if (!is_array($cache)) {
            $cache = array();
        }

        $cache[$this->get_widget_id_for_cache($args['widget_id'])] = $content;

        set_transient($this->get_widget_id_for_cache($this->widget_id), $cache);
    }

    /**
     * Flush the cache.
     */
    public function flush_widget_cache()
    {
        foreach (array('https', 'http') as $scheme) {
            delete_transient($this->get_widget_id_for_cache($this->widget_id, $scheme));
        }
    }

    /**
     * Get this widgets title.
     *
     * @param array $instance Array of instance options.
     *
     * @return string
     */
    protected function get_instance_title($instance)
    {
        if (isset($instance['title'])) {
            return $instance['title'];
        }

        if (isset($this->settings, $this->settings['title'], $this->settings['title']['std'])) {
            return $this->settings['title']['std'];
        }

        return '';
    }

    /**
     * Output the html at the start of a widget.
     *
     * @param array $args Arguments.
     * @param array $instance Instance.
     */
    public function widget_start($args, $instance)
    {
        $attribute      = '';
        $style          = '';
        $this->cache_id = $this->generate_id($instance);
        $this->field_id = "widget-{$this->cache_id}";
        $classes        = array(
            'widget',
            $this->widget_cssclass,
            $this->field_id,
        );

        if (!empty($instance['widget-class'])) {
            $classes[] = $instance['widget-class'];
        }
        if (!empty($instance['widget-animation'])) {
            $classes[] = 'showaction';
            if ($this->is_preview() || WPA::is_elementor_editor()) {
                $classes[] = 'animate__animated animate__'.$instance['widget-animation'];
            }
            $attribute .= ' data-animate=animate__'.$instance['widget-animation'];
        }

        if (!empty($style)) {
            $attribute .= ' style="'.htmlspecialchars($style).'"';
        }

        $classes = implode(' ', array_map('esc_attr', $classes));

        if (!empty($args['before_widget'])) {
            echo str_replace('widget '.$this->widget_cssclass.'"', $classes.'"'.$attribute, $args['before_widget']);
        } else {
            echo '<div class="'.$classes.'" '.$attribute.'>';
        }

        $title = apply_filters('widget_title', $this->get_instance_title($instance), $instance, $this->id_base);

        if ($title) {
            echo $args['before_title'].$title.$args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
        }

        // Check for embed google web fonts, custom css styles
        if ($this->global_css) {
            $this->collect_output_css_and_typography($instance);
        }
    }

    /**
     * Output the html at the end of a widget.
     *
     * @param array $args Arguments.
     */
    public function widget_end($args)
    {
        if (!empty($args['after_widget'])) {
            echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
        } else {
            echo '</div>';
        }
    }

    /**
     * Updates a particular instance of a widget.
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array
     * @see    WP_Widget->update
     */
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        if (empty($this->settings)) {
            return $instance;
        }

        // Loop settings and get values to save.
        foreach ($this->settings as $key => $setting) {
            if (!isset($setting['type'])) {
                continue;
            }
            $id             = !is_numeric($key) ? $key : $setting['id'];
            $instance[$key] = !empty($new_instance[$id]) ? $new_instance[$id] : null;
        }

        $this->flush_widget_cache();

        return $instance;
    }

    /**
     * Outputs the settings update form.
     *
     * @param array $instance
     *
     * @see   WP_Widget->form
     *
     */
    public function form($instance)
    {
        if (empty($this->settings)) {
            parent::form($instance);

            return;
        }

        echo '<div class="wpa-widgets wpa-fields">';

        foreach ($this->settings as $key => $setting) {
            if (!empty($setting['id'])) {
                $key = $setting['id'];
                unset($setting['id']);
            }
            $default = isset($setting['default']) ? $setting['default'] : '';
            $value   = isset($instance[$key]) ? $instance[$key] : $default;
            $field   = array(
                'id'   => $this->get_field_name($key),
                'name' => $this->get_field_name($key),
            );
            if (!empty($setting['attributes']['id'])) {
                $setting['attributes']['id'] .= ' '.$this->get_field_id($key);
            } else {
                $setting['attributes']['id'] = $this->get_field_id($key);
            }
            $setting['attributes']['data-depend-id'] = $key;

            $field = array_merge($field, $setting);

            echo WPA::field($field, $value);
        }

        echo '</div>';
    }

    /**
     * Get widget id plus scheme/protocol to prevent serving mixed content from (persistently) cached widgets.
     *
     * @param string $widget_id Id of the cached widget.
     * @param string $scheme Scheme for the widget id.
     *
     * @return string            Widget id including scheme/protocol.
     * @since  3.4.0
     */
    protected function get_widget_id_for_cache($widget_id, $scheme = '')
    {
        if ($scheme) {
            $widget_id_for_cache = $widget_id.'-'.$scheme;
        } else {
            $widget_id_for_cache = $widget_id.'-'.(is_ssl() ? 'https' : 'http');
        }

        return apply_filters('wpa_cached_widget_id', $widget_id_for_cache);
    }

    /**
     * Enqueue preview scripts.
     *
     * These scripts normally are enqueued just-in-time when a widget is rendered.
     * In the customizer, however, widgets can be dynamically added and rendered via
     * selective refresh, and so it is important to unconditionally enqueue them in
     * case a widget does get added.
     *
     * @since 4.8.0
     */
    public function enqueue_preview_scripts()
    {
    }

    /**
     * Loads the required scripts and styles for the widget control.
     *
     * @since 4.8.0
     */
    public function enqueue_admin_scripts()
    {
    }

    /**
     * Loads the type fields for the widget control.
     *
     * @since 4.8.0
     */
    public function load_field_scripts()
    {
        WPA::set_used_fields(['fields' => $this->settings]);
    }
}