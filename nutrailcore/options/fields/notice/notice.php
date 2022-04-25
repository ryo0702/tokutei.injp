<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/**
 *
 * Field: notice
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Field_notice')) {
    class WPA_Field_notice extends WPA_Fields
    {
        public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
        {
            parent::__construct($field, $value, $unique, $where, $parent);
        }

        public function render()
        {
            $style = (!empty($this->field['style'])) ? $this->field['style'] : 'normal';

            echo (!empty($this->field['content'])) ? '<div class="wpa-notice wpa-notice-'.esc_attr($style).'">'.$this->field['content'].'</div>' : '';
        }
    }
}
