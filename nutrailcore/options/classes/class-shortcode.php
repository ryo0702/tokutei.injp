<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
/**
 *
 * Shortcodes Class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Shortcode')) {
    class WPA_Shortcode extends WPA_Abstract
    {
        // constants
        public $unique   = '';
        public $sections = array();
        public $abstract = 'shortcode';
        public $args     = array();

        // run shortcode construct
        public function __construct($args = array(), $sections = array())
        {
            $this->args     = array(
                'id'           => '',
                'title'        => 'WPA Shortcode',
                'desc'         => 'Add wpa shortcode to content editor',
                'button_title' => 'shortcode',
                'select_title' => 'Select a shortcode',
                'insert_title' => 'Insert Shortcode',
                'close_title'  => esc_html__('Close', 'nutrail'),
            );
            $this->sections = apply_filters('wpa_options_shortcode', $sections, $this);
            $this->args     = apply_filters('wpa_settings_shortcode', wp_parse_args($args, $this->args), $this);

            if (!empty($this->args['id'])) {
                // ID shortcode
                $this->unique = $this->args['id'];

                // add button to Editor
                add_action('wp_tiny_mce_init', array(&$this, 'tiny_mce_script'));
                add_filter('mce_buttons', array(&$this, 'register_new_button'));

                // add button
                add_action('media_buttons', array(&$this, 'shortcode_button'), 99);
                add_action('wpa_field_shortcode_buttons', array(&$this, 'shortcode_button'), 99);

                // get shortcode
                add_action('wp_ajax_wpa-get-shortcode-'.$this->unique, array(&$this, 'get_shortcode'));

                // add modal
                add_action('admin_footer', array(&$this, 'shortcode_modal_v2'));
                add_action('elementor/editor/footer', array(&$this, 'shortcode_modal_v2'));
                add_action('customize_controls_print_footer_scripts', array(&$this, 'shortcode_modal_v2'));
            }

            // wp enqueue for typography and output css
            parent::__construct();
        }

        // instance
        public static function instance($args = array(), $sections = array())
        {
            return new self($args, $sections);
        }

        /*
         * add the new button to the tinymce array
        */
        function register_new_button($buttons)
        {
            array_push($buttons, $this->unique);

            return $buttons;
        }

        /*
         * Call the javascript file that loads the
         * instructions for the new button
        */
        function tiny_mce_script($mce_settings)
        {
            ?>
            <script type="text/javascript">
                if (typeof tinymce !== 'undefined' && typeof jQuery !== 'undefined') {

                    jQuery(document).on('tinymce-editor-setup', function (event, editor) {

                        editor.addButton("<?php echo esc_js($this->unique); ?>",
                            {
                                text   : "<?php echo esc_js($this->args['button_title']); ?>",
                                icon   : "wpa-shortcode",
                                tooltip: "<?php echo esc_js($this->args['desc']); ?>",
                                classes: "wpa-shortcode-button",
                                onclick: function () {
                                    jQuery(document).triggerHandler("wpa_button_tinymce_<?php echo esc_js($this->unique); ?>", [this, editor.id]);
                                }
                            },
                        );

                    });

                    if (typeof QTags !== 'undefined') {

                        var add_wpa_button = true;

                        if (typeof edButtons !== 'undefined') {
                            for (var key in edButtons) {
                                if (!edButtons.hasOwnProperty(key) || add_wpa_button === false) {
                                    continue;
                                }
                                if (edButtons[key].id === "<?php echo esc_js($this->unique); ?>") {
                                    add_wpa_button = false;
                                }
                            }
                        }

                        if (add_wpa_button) {
                            QTags.addButton(
                                "<?php echo esc_js($this->unique); ?>",
                                "<?php echo esc_js($this->args['button_title']); ?>",
                                function (element, editor) {
                                    jQuery(document).triggerHandler("wpa_button_tinymce_<?php echo esc_js($this->unique); ?>", [this, editor.id]);
                                }
                            );
                        }

                    }

                }
            </script>
            <?php
        }

        public function shortcode_button($editor_id)
        {
            $this->load_field_scripts();
            WPA::enqueue_scripts();

            $rendered = array();
            $attr     = array(
                'href'          => '#',
                'class'         => 'button wpa-shortcode-button',
                'data-modal-id' => $this->unique,
            );
            if (!empty($editor_id)) {
                $attr['data-editor-id'] = $editor_id;
            }
            foreach ($attr as $name => $value) {
                if (is_array($value)) {
                    $value = implode(' ', $value);
                }
                $rendered[] = sprintf('%1$s="%2$s"', $name, esc_attr($value));
            }
            ob_start();
            ?>
            <a <?php echo implode(' ', $rendered); ?>>
                <span class="wp-media-buttons-icon"></span>
                <?php echo esc_html($this->args['button_title']); ?>
            </a>
            <?php
            echo ob_get_clean();
        }

        public function shortcode_modal_v2()
        {
            if (WPA::disable_scripts()) {
                return;
            }
            $html        = "";
            $modal_id    = "wpa-modal-{$this->unique}";
            $modal_class = "wp-core-ui wpa-modal-v2 wpa-shortcode";
            foreach ($this->sections as $option) {
                $html .= (!empty($option['title'])) ? '<optgroup label="'.$option['title'].'">' : '';
                foreach ($option['sections'] as $shortcode) {
                    $view = (isset($shortcode['view'])) ? $shortcode['view'] : 'normal';

                    $html .= '<option value="'.$shortcode['name'].'" ';
                    $html .= 'data-view="'.$view.'" ';
                    $html .= 'data-shortcode="'.$shortcode['name'].'" ';
                    if ($view == 'group') {
                        $clone_id = (isset($shortcode['clone_id'])) ? $shortcode['clone_id'] : 'nested_'.$shortcode['name'];

                        $html .= 'data-group="'.$clone_id.'" ';
                    }
                    $html .= '>';
                    $html .= $shortcode['title'];
                    $html .= '</option>';
                }
                $html .= (!empty($option['title'])) ? '</optgroup>' : '';
            }
            // Config _WP_Editors
            if (wpa_wp_editor_api() && class_exists('_WP_Editors')) {
                $defaults = apply_filters('wpa_wp_editor', array(
                    'tinymce' => array(
                        'wp_skip_init' => true,
                    ),
                ));

                $setup = _WP_Editors::parse_settings('wpa_wp_editor', $defaults);

                _WP_Editors::editor_settings('wpa_wp_editor', $setup);
            }
            ?>
            <div id="<?php echo esc_attr($modal_id); ?>" class="<?php echo esc_attr($modal_class); ?>"
                 data-modal-id="<?php echo esc_attr($this->unique); ?>">
                <div class="wpa-modal-table">
                    <div class="wpa-modal-table-cell">
                        <div class="wpa-modal-overlay"></div>
                        <div class="wpa-modal-inner wpa wpa-theme-dark">
                            <div class="wpa-header">
                                <div class="wpa-header-inner">
                                    <div class="wpa-header-left">
                                        <h1><?php echo esc_html($this->args['title']); ?>
                                            <small>by
                                                <a href="#" target="_blank">
                                                    Name
                                                </a>
                                            </small>
                                        </h1>
                                    </div>
                                    <div class="wpa-header-right">
                                        <div class="wpa-buttons">
                                            <select>
                                                <option value="">
                                                    <?php echo esc_html($this->args['select_title']); ?>
                                                </option>
                                                <?php echo wp_specialchars_decode($html); ?>
                                            </select>
                                            <a href="#"
                                               class="button button-primary wpa-top-save wpa-modal-insert">
                                                <?php echo esc_html($this->args['insert_title']); ?>
                                            </a>
                                            <input class="button button-secondary wpa-warning-primary wpa-modal-close"
                                                   type="button"
                                                   value="<?php echo esc_html($this->args['close_title']); ?>">
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div class="wpa-modal-content">
                                <div class="wpa-modal-loading">
                                    <div class="wpa-loading"></div>
                                </div>
                                <div class="wpa-modal-load"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        public function shortcode_modal()
        {
            ?>
            <div id="wpa-modal-<?php echo esc_attr($this->unique); ?>"
                 class="wp-core-ui wpa-modal wpa-shortcode"
                 data-modal-id="<?php echo esc_attr($this->unique); ?>">
                <div class="wpa-modal-table">
                    <div class="wpa-modal-table-cell">
                        <div class="wpa-modal-overlay"></div>
                        <div class="wpa-modal-inner">
                            <div class="wpa-modal-title">
                                <?php echo esc_html($this->args['button_title']); ?>
                                <div class="wpa-modal-close"></div>
                            </div>
                            <div class="wpa-modal-header">
                                <select>
                                    <option value=""><?php echo esc_html($this->args['select_title']); ?></option>
                                    <?php
                                    $html = '';
                                    foreach ($this->sections as $option) {
                                        $html .= (!empty($option['title'])) ? '<optgroup label="'.$option['title'].'">' : '';
                                        foreach ($option['sections'] as $shortcode) {
                                            $view = (isset($shortcode['view'])) ? $shortcode['view'] : 'normal';

                                            $html .= '<option value="'.$shortcode['name'].'" ';
                                            $html .= 'data-view="'.$view.'" ';
                                            $html .= 'data-shortcode="'.$shortcode['name'].'" ';
                                            if ($view == 'group') {
                                                $clone_id = (isset($shortcode['clone_id'])) ? $shortcode['clone_id'] : 'nested_'.$shortcode['name'];

                                                $html .= 'data-group="'.$clone_id.'" ';
                                            }
                                            $html .= '>';
                                            $html .= $shortcode['title'];
                                            $html .= '</option>';
                                        }
                                        $html .= (!empty($option['title'])) ? '</optgroup>' : '';
                                    }
                                    echo $html;
                                    ?>
                                </select>
                            </div>
                            <div class="wpa-modal-content">
                                <div class="wpa-modal-loading">
                                    <div class="wpa-loading"></div>
                                </div>
                                <div class="wpa-modal-load"></div>
                            </div>
                            <div class="wpa-modal-insert-wrapper hidden">
                                <a href="#" class="button button-primary wpa-modal-insert">
                                    <?php echo esc_html($this->args['insert_title']); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        public function get_shortcode()
        {
            $html     = '';
            $unallows = array('group', 'repeater');
            $request  = wpa_get_var('shortcode_key');

            if (empty($request)) {
                wp_send_json_error(
                    array(
                        'error' => esc_html__('Error: Shortcode content load failed. Please try again.', 'nutrail')
                    )
                );
            }

            $shortcode = wpa_array_search($this->sections, 'name', $request);
            $shortcode = array_pop($shortcode);

            if (!empty($shortcode['fields'])) {

                $html .= '<div class="wpa-fields">';

                foreach ($shortcode['fields'] as $field) {
                    if (in_array($field['type'], $unallows)) {
                        $field['_notice'] = true;
                    }

                    $field['name'] = "{$shortcode['name']}[{$field['id']}]";
                    $field_default = (!empty($field['default'])) ? $field['default'] : '';

                    $html .= WPA::field($field, $field_default, 'shortcode', 'shortcode');
                }

                $html .= '</div>';
            }

            if (!empty($shortcode['clone_fields'])) {

                $html .= '<div class="wpa--repeatable">';
                $html .= '<div class="wpa--repeat-shortcode">';

                $html .= '<div class="wpa-repeat-remove fa fa-times"></div>';

                $html .= '<div class="wpa-fields">';

                foreach ($shortcode['clone_fields'] as $field) {
                    if (in_array($field['type'], $unallows)) {
                        $field['_notice'] = true;
                    }

                    $name          = ($shortcode['view'] == 'group') ? $shortcode['clone_id'] : $shortcode['name'];
                    $field['sub']  = true;
                    $field['name'] = "{$name}[0][{$field['id']}]";
                    $field_default = (!empty($field['default'])) ? $field['default'] : '';

                    $html .= WPA::field($field, $field_default, $shortcode['name'], 'shortcode');
                }

                $html .= '</div>'; // .wpa-fields
                $html .= '</div>'; // .wpa--repeat-shortcode
                $html .= '</div>'; // .wpa--repeatable

                $html .= '<div class="wpa--repeat-button-block">';
                $html .= '    <a class="button wpa--repeat-button" href="#">';
                $html .= '        <i class="fa fa-plus-circle"></i> '.$shortcode['clone_title'];
                $html .= '    </a>';
                $html .= '</div>';

            }

            wp_send_json_success(
                array('content' => $html)
            );
        }
    }
}
