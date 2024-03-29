<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 *
 * Field: textarea
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Field_textarea')) {
    class WPA_Field_textarea extends WPA_Fields
    {
        public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
        {
            parent::__construct($field, $value, $unique, $where, $parent);
        }

        public function render()
        {
            echo $this->field_before();

            if (!empty($this->field['shortcode']) && $this->field['shortcode'] == true) {
                do_action('wpa_field_shortcode_buttons');
            }

            echo '<textarea name="'.esc_attr($this->field_name()).'"'.$this->field_attributes().'>'.$this->value.'</textarea>';

            echo $this->field_after();
        }
    }
}
