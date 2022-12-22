<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 *
 * Field: code_editor
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Field_code_editor')) {
    class WPA_Field_code_editor extends WPA_Fields
    {
        public $version = '5.64.0';
        public $cdn_url = 'https://cdn.jsdelivr.net/npm/codemirror@';

        public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
        {
            parent::__construct($field, $value, $unique, $where, $parent);
        }

        public function render()
        {
            $default_settings = array(
                'tabSize'     => 2,
                'lineNumbers' => true,
                'theme'       => 'default',
                'mode'        => 'htmlmixed',
                'cdnURL'      => $this->cdn_url.$this->version,
            );

            $settings = (!empty($this->field['settings'])) ? $this->field['settings'] : array();
            $settings = wp_parse_args($settings, $default_settings);

            echo $this->field_before();
            echo '<textarea name="'.esc_attr($this->field_name()).'"'.$this->field_attributes().' data-editor="'.esc_attr(json_encode($settings)).'">'.$this->value.'</textarea>';
            echo $this->field_after();
        }

        public function enqueue()
        {
            // Do not loads CodeMirror in revslider page.
            if (WPA::disable_scripts()) {
                return;
            }

            if (!wp_script_is('wpa-codemirror')) {
                wp_enqueue_script('wpa-codemirror', $this->cdn_url.$this->version.'/lib/codemirror.min.js', array('wpa-options'), $this->version, true);
                wp_enqueue_script('wpa-codemirror-loadmode', $this->cdn_url.$this->version.'/addon/mode/loadmode.min.js', array('wpa-codemirror'), $this->version, true);
            }

            if (!wp_style_is('wpa-codemirror')) {
                wp_enqueue_style('wpa-codemirror', $this->cdn_url.$this->version.'/lib/codemirror.min.css', array(), $this->version);
            }
        }
    }
}
