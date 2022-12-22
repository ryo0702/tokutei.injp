<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 *
 * Field: image_select
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Field_image_select')) {
    class WPA_Field_image_select extends WPA_Fields
    {

        public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
        {
            parent::__construct($field, $value, $unique, $where, $parent);
        }

        public function render()
        {

            $args = wp_parse_args($this->field, array(
                'multiple' => false,
                'inline'   => false,
                'options'  => array(),
            ));

            $inline = ($args['inline']) ? ' wpa--inline-list' : '';
            $value  = (is_array($this->value)) ? $this->value : array_filter((array) $this->value);

            echo $this->field_before();

            if (!empty($args['options'])) {

                echo '<div class="wpa-siblings wpa--image-group'.esc_attr($inline).'" data-multiple="'.esc_attr($args['multiple']).'">';

                $num = 1;

                foreach ($args['options'] as $key => $option) {

                    $type    = ($args['multiple']) ? 'checkbox' : 'radio';
                    $extra   = ($args['multiple']) ? '[]' : '';
                    $active  = (in_array($key, $value)) ? ' wpa--active' : '';
                    $checked = (in_array($key, $value)) ? ' checked' : '';

                    echo '<div class="wpa--sibling wpa--image'.esc_attr($active).'">';
                    echo '<figure>';
                    echo '<img src="'.esc_url($option).'" alt="img-'.esc_attr($num++).'" title="'.esc_attr($key).'" />';
                    echo '<input type="'.esc_attr($type).'" name="'.esc_attr($this->field_name($extra)).'" value="'.esc_attr($key).'"'.$this->field_attributes().esc_attr($checked).'/>';
                    echo '</figure>';
                    echo '</div>';

                }

                echo '</div>';

            }

            echo $this->field_after();

        }

        public function output()
        {

            $output    = '';
            $bg_image  = array();
            $important = (!empty($this->field['output_important'])) ? '!important' : '';
            $elements  = (is_array($this->field['output'])) ? join(',', $this->field['output']) : $this->field['output'];

            if (!empty($elements) && isset($this->value) && $this->value !== '') {
                $output = $elements.'{background-image:url('.$this->value.')'.$important.';}';
            }

            $this->parent->output_css .= $output;

            return $output;

        }

    }
}