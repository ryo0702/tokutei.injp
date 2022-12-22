<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 *
 * Field: backup widgets
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Field_backup_widgets')) {
    class WPA_Field_backup_widgets extends WPA_Fields
    {

        public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
        {
            parent::__construct($field, $value, $unique, $where, $parent);
        }

        public function render()
        {
            $unique         = (isset($this->field['unique'])) ? $this->field['unique'] : $this->unique;
            $options        = (isset($this->field['options'])) ? $this->field['options'] : 'option';
            $default        = (isset($this->field['default'])) ? $this->field['default'] : '';
            $ajax_url       = admin_url('admin-ajax.php');
            $nonce          = wp_create_nonce('wpa_backup_nonce');
            $import_demo    = add_query_arg(array(
                'action' => 'wpa-import-widgets',
                'unique' => $unique,
                'nonce'  => $nonce
            ), $ajax_url);
            $remove_sidebar = add_query_arg(array(
                'action' => 'wpa-remove-inactive-sidebar',
                'nonce'  => $nonce
            ), $ajax_url);

            echo $this->field_before();

            if ($options == 'widget') {
                echo WPA::field(array(
                    'id'       => 'backup_widget_list',
                    'type'     => 'image_select',
                    'title'    => 'Select widgets import',
                    'multiple' => true,
                    'ignore'   => true,
                    'options'  => get_preset_data('widgets', true),
                ), $default);

                echo '<a href="'.esc_url($import_demo).'" class="button button-primary wpa-save-callback" style="margin-right: 15px">Import Widgets Demo</a>';
                echo '<a href="'.esc_url($remove_sidebar).'" class="button wpa-warning-primary wpa-save-callback">Remove Inactive Sidebar</a>';
            }

            if ($options == 'option') {
                echo WPA::field(array(
                    'id'      => 'backup_options_list',
                    'type'    => 'image_select',
                    'title'   => 'Select theme options import',
                    'ignore'  => true,
                    'options' => get_preset_data('options', true),
                ), $default);

                echo '<a href="'.esc_url($import_demo).'&import-theme-options=true" class="button button-primary wpa-save-callback">Import Options Demo</a>';
                echo '<p class="wpa-text-error" style="margin-bottom: 20px;">Warning: when importing the value in admin option and the selected widget will be overwritten.</p>';
            }

            echo $this->field_after();

        }

    }
}
