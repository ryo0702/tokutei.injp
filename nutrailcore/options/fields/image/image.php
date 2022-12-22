<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/**
 *
 * Field: Image
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Field_Image')) {
    class WPA_Field_Image extends WPA_Fields
    {
        public function __construct($field, $value = '', $unique = '', $where = '')
        {
            parent::__construct($field, $value, $unique, $where);
        }

        public function render()
        {
            echo $this->field_before();

            $preview = '';
            $add     = (!empty($this->field['add_title'])) ? $this->field['add_title'] : esc_html__('Add image', 'nutrail');
            $hidden  = (empty($this->value)) ? ' hidden' : '';
            if (!empty($this->value)) {
                $attachment = wp_get_attachment_image_src($this->value, 'thumbnail');
                $preview    = $attachment[0];
            }

            echo '<div class="wpa-image-preview'.esc_attr($hidden).'">';
            echo '<div class="wpa-image-inner"><i class="fa fa-times wpa-image-remove"></i><img src="'.esc_url($preview).'" alt="" /></div>';
            echo '</div>';
            echo '<a href="#" class="button button-primary wpa-button">'.$add.'</a>';
            echo '<input type="text" name="'.$this->field_name().'" value="'.$this->value.'"'.$this->field_class().$this->field_attributes().'/>';

            echo $this->field_after();
        }
    }
}
