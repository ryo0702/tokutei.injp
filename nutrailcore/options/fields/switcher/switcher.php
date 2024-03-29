<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 *
 * Field: switcher
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Field_switcher')) {
    class WPA_Field_switcher extends WPA_Fields
    {
        public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
        {
            parent::__construct($field, $value, $unique, $where, $parent);
        }

        public function render()
        {
            $active     = (!empty($this->value)) ? ' wpa--active' : '';
            $text_on    = (!empty($this->field['text_on'])) ? $this->field['text_on'] : __('On', 'nutrail');
            $text_off   = (!empty($this->field['text_off'])) ? $this->field['text_off'] : __('Off', 'nutrail');
            $text_width = (!empty($this->field['text_width'])) ? ' style="width: '.$this->field['text_width'].'px;"' : '';

            echo $this->field_before();

            echo '<div class="wpa--switcher'.esc_attr($active).'"'.$text_width.'>';
            echo '<span class="wpa--on">'.esc_attr($text_on).'</span>';
            echo '<span class="wpa--off">'.esc_attr($text_off).'</span>';
            echo '<span class="wpa--ball"></span>';
            echo '<input type="text" name="'.esc_attr($this->field_name()).'" value="'.esc_attr($this->value).'"'.$this->field_attributes().' />';
            echo '</div>';

            echo (!empty($this->field['label'])) ? '<span class="wpa--label">'.esc_attr($this->field['label']).'</span>' : '';

            echo $this->field_after();
        }
    }
}
