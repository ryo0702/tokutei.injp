<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 *
 * Field: backup
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Field_backup')) {
    class WPA_Field_backup extends WPA_Fields
    {

        public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
        {
            parent::__construct($field, $value, $unique, $where, $parent);
        }

        public function render()
        {
            $unique      = (isset($this->field['unique'])) ? $this->field['unique'] : $this->unique;
            $ajax_url    = admin_url('admin-ajax.php');
            $nonce       = wp_create_nonce('wpa_backup_nonce');
            $export      = add_query_arg(array(
                'action' => 'wpa-export',
                'unique' => $unique,
                'nonce'  => $nonce
            ), $ajax_url);
            $export_demo = add_query_arg(array(
                'action' => 'wpa-export-widgets',
                'unique' => $unique,
                'nonce'  => $nonce
            ), $ajax_url);

            echo $this->field_before();

            echo '<a href="'.esc_url($export_demo).'" class="button button-secondary">Export Demo File</a>';
            echo '<hr />';

            echo '<textarea name="wpa_import_data" class="wpa-import-data"></textarea>';
            echo '<button type="submit" class="button button-primary wpa-confirm wpa-import" data-unique="'.esc_attr($unique).'" data-nonce="'.esc_attr($nonce).'">'.esc_html__('Import', 'nutrail').'</button>';
            echo '<small>( '.esc_html__('copy-paste your backup string here', 'nutrail').' )</small>';
            echo '<hr />';

            echo '<textarea readonly="readonly" class="wpa-export-data">'.esc_attr(json_encode(get_option($unique))).'</textarea>';
            echo '<a href="'.esc_url($export).'" class="button button-primary wpa-export" target="_blank">'.esc_html__('Export & Download', 'nutrail').'</a>';
            echo '<hr />';

            echo '<button type="submit" name="wpa_transient[reset]" value="reset" class="button wpa-warning-primary wpa-confirm wpa-reset" data-unique="'.esc_attr($unique).'" data-nonce="'.esc_attr($nonce).'">'.esc_html__('Reset All', 'nutrail').'</button>';
            echo '<small class="wpa-text-error">'.esc_html__('Please be sure for reset all of options.', 'nutrail').'</small>';
            
            echo $this->field_after();

        }

    }
}
