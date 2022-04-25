<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 *
 * Field: icon
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Field_icon')) {
    class WPA_Field_icon extends WPA_Fields
    {

        public function __construct($field, $value = '', $unique = '', $where = '', $parent = '')
        {
            parent::__construct($field, $value, $unique, $where, $parent);
        }

        public function render()
        {

            $args = wp_parse_args($this->field, array(
                'button_title' => esc_html__('Add Icon', 'nutrail'),
                'remove_title' => esc_html__('Remove Icon', 'nutrail'),
            ));

            echo $this->field_before();

            $nonce  = wp_create_nonce('wpa_icon_nonce');
            $hidden = (empty($this->value)) ? ' hidden' : '';

            echo '<div class="wpa-icon-select">';
            echo '<span class="wpa-icon-preview'.esc_attr($hidden).'"><i class="'.esc_attr($this->value).'"></i></span>';
            echo '<a href="#" class="button button-primary wpa-icon-add" data-nonce="'.esc_attr($nonce).'">'.$args['button_title'].'</a>';
            echo '<a href="#" class="button wpa-warning-primary wpa-icon-remove'.esc_attr($hidden).'">'.$args['remove_title'].'</a>';
            echo '<input type="hidden" name="'.esc_attr($this->field_name()).'" value="'.esc_attr($this->value).'" class="wpa-icon-value"'.$this->field_attributes().' />';
            echo '</div>';

            echo $this->field_after();

        }

        public function enqueue()
        {
            add_action('admin_footer', array('WPA_Field_icon', 'add_footer_modal_icon'));
            add_action('elementor/editor/footer', array('WPA_Field_icon', 'add_footer_modal_icon'));
            add_action('customize_controls_print_footer_scripts', array('WPA_Field_icon', 'add_footer_modal_icon'));
        }

        public static function add_footer_modal_icon()
        {
            ?>
            <div id="wpa-modal-icon" class="wpa-modal-v2 wpa-modal-icon">
                <div class="wpa-modal-table">
                    <div class="wpa-modal-table-cell">
                        <div class="wpa-modal-overlay"></div>
                        <div class="wpa-modal-inner wpa wpa-theme-dark">
                            <div class="wpa-header">
                                <div class="wpa-header-inner">
                                    <div class="wpa-header-left">
                                        <h1>
                                            <?php esc_html_e('Add Icon', 'nutrail'); ?>
                                        </h1>
                                    </div>
                                    <div class="wpa-header-right">
                                        <div class="wpa-search-icon">
                                            <input type="text"
                                                   placeholder="<?php esc_attr_e('Search a Icon...', 'nutrail'); ?>"
                                                   class="wpa-icon-search"/>
                                        </div>
                                        <div class="wpa-buttons">
                                            <input class="button button-secondary wpa-warning-primary wpa-modal-close"
                                                   type="button" value="<?php esc_attr_e('Close', 'nutrail'); ?>">
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div class="wpa-nav">
                                <ul></ul>
                            </div>
                            <div class="wpa-modal-content">
                                <div class="wpa-modal-loading">
                                    <div class="wpa-loading"></div>
                                </div>
                                <div class="wpa-modal-load"></div>
                            </div>
                            <div class="wpa-nav-background"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

    }
}
