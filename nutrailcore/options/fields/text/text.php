<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/**
 *
 * Field: text
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Field_text')) {
    class WPA_Field_text extends WPA_Fields
    {
        public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
        {
            parent::__construct($field, $value, $unique, $where, $parent);
        }

        public function render()
        {
            $type = (!empty($this->field['attributes']['type'])) ? $this->field['attributes']['type'] : 'text';

            echo $this->field_before();

            echo '<input type="'.esc_attr($type).'" name="'.esc_attr($this->field_name()).'" value="'.esc_attr($this->value).'"'.$this->field_attributes().' />';

            echo $this->field_after();
        }
    }
}