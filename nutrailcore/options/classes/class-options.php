<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.
/**
 *
 * Options class
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if (!class_exists('WPA_Options')) {
    class WPA_Options extends WPA_Abstract
    {
        // constants
        public $unique       = '';
        public $abstract     = 'options';
        public $notice       = false;
        public $errors       = array();
        public $sections     = array();
        public $options      = array();
        public $pre_tabs     = array();
        public $pre_fields   = array();
        public $pre_sections = array();
        // default args
        public $args = array(
            'option_name'             => '_wpa_admin_options',

            // framework title
            'framework_title'         => 'WPA Framework',
            'framework_class'         => '',

            // menu settings
            'menu_title'              => 'Framework',
            'menu_type'               => 'menu',                             // menu, submenu, options, theme, etc.
            'menu_slug'               => 'wpa_theme_options',
            'menu_icon'               => '',
            'menu_capability'         => 'manage_options',
            'menu_hidden'             => false,
            'menu_position'           => null,
            'menu_priority'           => 0,

            // menu extras
            'admin_bar_menu_icon'     => 'dashicons-admin-appearance',
            'admin_bar_menu_priority' => 80,
            'show_bar_menu'           => true,
            'show_network_menu'       => false,

            'show_search'             => true,
            'show_reset'              => true,
            'show_reset_all'          => true,
            'show_footer'             => true,
            'show_all_options'        => true,
            'show_form_warning'       => true,
            'ajax_save'               => true,
            'sticky_header'           => true,
            'save_defaults'           => true,
            'form_action'             => '',

            // footer
            'footer_text'             => '',
            'footer_after'            => '',

            // database model
            'database'                => 'options',

            // options, transient, theme_mod, network
            'transient_time'          => 0,

            // contextual help
            'contextual_help'         => array(),
            'contextual_help_sidebar' => '',

            // typography options
            'enqueue_webfont'         => false,
            'async_webfont'           => false,

            // theme
            'nav'                     => 'normal',
            'theme'                   => 'dark',
            'class'                   => '',

            // others
            'output_css'              => false,

            // external default values
            'defaults'                => array(),
        );

        public function __construct($args = array(), $params = array())
        {
            $this->args     = apply_filters("wpa_admin_{$this->unique}_settings", wp_parse_args($args, $this->args), $this);
            $this->sections = apply_filters("wpa_admin_{$this->unique}_options", $params, $this);
            $this->unique   = $this->args['option_name'];

            // framework init
            add_action('admin_init', array(&$this, 'setup'));

            // Actions framework
            add_action('admin_menu', array(&$this, 'add_admin_menu'), $this->args['menu_priority']);
            add_action('admin_bar_menu', array(&$this, 'add_admin_bar_menu'), $this->args['admin_bar_menu_priority']);

            // Ajax save
            add_action('wp_ajax_wpa_'.$this->unique.'_ajax_save', array(&$this, 'ajax_save'));

            // wp enqueue for typography and output css
            parent::__construct();
        }

        // instance of framework
        public static function instance($args = array(), $params = array())
        {
            return new self($args, $params);
        }

        public function setup()
        {
            // run only is admin panel options, avoid performance loss
            $this->pre_tabs     = $this->get_tabs($this->sections);
            $this->pre_fields   = $this->get_fields($this->sections);
            $this->pre_sections = $this->get_sections($this->sections);

            // Default framework
            $this->get_options();
            $this->set_options();
            $this->save_defaults();
        }

        public function ajax_save()
        {
            $result = $this->set_options(true);

            if (!$result) {
                wp_send_json_error(array('error' => esc_html__('Error while saving.', 'nutrail')));
            } else {
                wp_send_json_success(array('notice' => $this->notice, 'errors' => $this->errors));
            }
        }

        // set options
        public function set_options($ajax = false)
        {

            // XSS ok.
            // No worries, This "POST" requests is sanitizing in the below foreach. see #L337 - #L341
            $response = ($ajax && !empty($_POST['data'])) ? json_decode(wp_unslash(trim($_POST['data'])), true) : $_POST;

            // Set variables.
            $data      = array();
            $noncekey  = 'wpa_options_nonce'.$this->unique;
            $nonce     = (!empty($response[$noncekey])) ? $response[$noncekey] : '';
            $options   = (!empty($response[$this->unique])) ? $response[$this->unique] : array();
            $transient = (!empty($response['wpa_transient'])) ? $response['wpa_transient'] : array();

            if (wp_verify_nonce($nonce, 'wpa_options_nonce')) {

                $importing  = false;
                $section_id = (!empty($transient['section'])) ? $transient['section'] : '';

                if (!$ajax && !empty($response['wpa_import_data'])) {

                    // XSS ok.
                    // No worries, This "POST" requests is sanitizing in the below foreach. see #L337 - #L341
                    $import_data  = json_decode(wp_unslash(trim($response['wpa_import_data'])), true);
                    $options      = (is_array($import_data) && !empty($import_data)) ? $import_data : array();
                    $importing    = true;
                    $this->notice = esc_html__('Success. Imported backup options.', 'nutrail');

                }

                if (!empty($transient['reset'])) {

                    foreach ($this->pre_fields as $field) {
                        if (!empty($field['id']) && !isset($field['ignore'])) {
                            $data[$field['id']] = $this->get_default($field);
                        }
                    }

                    $this->notice = esc_html__('Default options restored.', 'nutrail');

                } elseif (!empty($transient['reset_section']) && !empty($section_id)) {

                    if (!empty($this->pre_sections[$section_id - 1]['fields'])) {

                        foreach ($this->pre_sections[$section_id - 1]['fields'] as $field) {
                            if (!empty($field['id']) && !isset($field['ignore'])) {
                                $data[$field['id']] = $this->get_default($field);
                            }
                        }

                    }

                    $data = wp_parse_args($data, $this->options);

                    $this->notice = esc_html__('Default options restored for only this section.', 'nutrail');

                } else {

                    // sanitize and validate
                    foreach ($this->pre_fields as $field) {

                        if (!empty($field['id']) && !isset($field['ignore'])) {

                            $field_id    = $field['id'];
                            $field_value = isset($options[$field_id]) ? $options[$field_id] : '';

                            // Ajax and Importing doing wp_unslash already.
                            if (!$ajax && !$importing) {
                                $field_value = wp_unslash($field_value);
                            }

                            // Sanitize "post" request of field.
                            if (!isset($field['sanitize'])) {

                                if (is_array($field_value)) {

                                    $data[$field_id] = wp_kses_post_deep($field_value);

                                } else {

                                    $data[$field_id] = wp_kses_post($field_value);

                                }

                            } elseif (isset($field['sanitize']) && function_exists($field['sanitize'])) {

                                $data[$field_id] = call_user_func($field['sanitize'], $field_value);

                            } else {

                                $data[$field_id] = $field_value;

                            }

                            // Validate "post" request of field.
                            if (isset($field['validate']) && function_exists($field['validate'])) {

                                $has_validated = call_user_func($field['validate'], $field_value);

                                if (!empty($has_validated)) {

                                    $data[$field_id]         = (isset($this->options[$field_id])) ? $this->options[$field_id] : '';
                                    $this->errors[$field_id] = $has_validated;

                                }

                            }

                        }

                    }

                }

                $data = apply_filters("wpa_{$this->unique}_save", $data, $this);

                do_action("wpa_{$this->unique}_save_before", $data, $this);

                $this->options = $data;

                $this->save_options($data);

                do_action("wpa_{$this->unique}_save_after", $data, $this);

                if (empty($this->notice)) {
                    $this->notice = esc_html__('Settings saved.', 'nutrail');
                }

                return true;

            }

            return false;

        }

        // add admin bar menu
        public function add_admin_bar_menu($wp_admin_bar)
        {
            if (!is_super_admin() || !is_admin_bar_showing() || is_network_admin()) {
                return;
            }
            if (!empty($this->args['show_bar_menu']) && empty($this->args['menu_hidden'])) {
                $menu_slug = $this->args['menu_slug'];
                $menu_icon = (!empty($this->args['admin_bar_menu_icon'])) ? '<span style="top:2px;" class="wpa-ab-icon ab-icon '.esc_attr($this->args['admin_bar_menu_icon']).'"></span>' : '';
                $menu_args = array(
                    'id'    => $menu_slug,
                    'title' => $menu_icon.esc_attr($this->args['menu_title']),
                    'href'  => esc_url((is_network_admin()) ? network_admin_url('admin.php?page='.$menu_slug) : admin_url('admin.php?page='.$menu_slug)),
                );
                if (!empty($this->args['menu_parent'])) {
                    $menu_args['parent'] = $this->args['menu_parent'];
                    $menu_args['title']  = esc_attr($this->args['menu_title']);
                }
                $wp_admin_bar->add_node($menu_args);

                if (!empty($this->args['show_network_menu'])) {
                    $wp_admin_bar->add_node(array(
                            'parent' => 'network-admin',
                            'id'     => $menu_slug.'-network-admin',
                            'title'  => $menu_icon.esc_attr($this->args['menu_title']),
                            'href'   => esc_url(network_admin_url('admin.php?page='.$menu_slug)),
                        )
                    );
                }
            }
        }

        // wp api: admin menu
        public function add_admin_menu()
        {
            $defaults = array(
                'menu_parent'     => '',
                'menu_title'      => '',
                'menu_type'       => '',
                'menu_slug'       => '',
                'menu_icon'       => '',
                'menu_capability' => 'manage_options',
                'menu_position'   => null,
            );
            $args     = wp_parse_args($this->args, $defaults);
            if ($args['menu_type'] == 'submenu') {
                $menu_page = call_user_func('add_'.$args['menu_type'].'_page',
                    $args['menu_parent'],
                    $args['menu_title'],
                    $args['menu_title'],
                    $args['menu_capability'],
                    $args['menu_slug'],
                    array(&$this, 'add_options_html')
                );
            } else {
                $menu_page = call_user_func('add_'.$args['menu_type'].'_page',
                    $args['menu_title'],
                    $args['menu_title'],
                    $args['menu_capability'],
                    $args['menu_slug'],
                    array(&$this, 'add_options_html'),
                    $args['menu_icon'],
                    $args['menu_position']
                );
            }

            add_action('load-'.$menu_page, array(&$this, 'add_page_on_load'));
        }

        public function add_page_on_load()
        {
            if (!empty($this->args['contextual_help'])) {
                $screen = get_current_screen();

                foreach ($this->args['contextual_help'] as $tab) {
                    $screen->add_help_tab($tab);
                }

                if (!empty($this->args['contextual_help_sidebar'])) {
                    $screen->set_help_sidebar($this->args['contextual_help_sidebar']);
                }
            }
        }

        // option page html output
        public function add_options_html()
        {
            $has_nav       = (count($this->pre_tabs) > 1) ? true : false;
            $show_all      = (!$has_nav) ? ' wpa-show-all' : '';
            $ajax_class    = ($this->args['ajax_save']) ? ' wpa-save-ajax' : '';
            $sticky_class  = ($this->args['sticky_header']) ? ' wpa-sticky-header' : '';
            $wrapper_class = ($this->args['framework_class']) ? ' '.$this->args['framework_class'] : '';
            $theme         = ($this->args['theme']) ? ' wpa-theme-'.$this->args['theme'] : '';
            $class         = ($this->args['class']) ? ' '.$this->args['class'] : '';
            $nav_type      = ($this->args['nav'] === 'inline') ? 'inline' : 'normal';
            $form_action   = ($this->args['form_action']) ? $this->args['form_action'] : '';

            do_action('wpa_html_options_before');

            echo '<div class="wpa wpa-options'.esc_attr($theme.$class.$wrapper_class).'" data-slug="'.esc_attr($this->args['menu_slug']).'" data-unique="'.esc_attr($this->unique).'">';

            echo '<div class="wpa-container">';

            echo '<form method="post" action="'.esc_attr($form_action).'" enctype="multipart/form-data" id="wpa-form" autocomplete="off">';

            echo '<input type="hidden" class="wpa-section-id" name="wpa_transient[section]" value="1">';

            wp_nonce_field('wpa_options_nonce', 'wpa_options_nonce'.$this->unique);

            echo '<div class="wpa-header'.esc_attr($sticky_class).'">';

            echo '<div class="wpa-header-inner">';

            echo '<div class="wpa-header-left">';
            echo '<h1>'.$this->args['framework_title'].'</h1>';
            echo '</div>';

            echo '<div class="wpa-header-right">';

            $notice_class = (!empty($this->notice)) ? ' wpa-form-show' : '';
            $notice_text  = (!empty($this->notice)) ? $this->notice : '';

            echo '<div class="wpa-form-result wpa-form-success'.esc_attr($notice_class).'">'.wp_kses_post($notice_text).'</div>';

            echo ($this->args['show_form_warning']) ? '<div class="wpa-form-result wpa-form-warning">'.esc_html__('You have unsaved changes, save your changes!', 'nutrail').'</div>' : '';

            echo ($has_nav && $this->args['show_all_options']) ? '<div class="wpa-expand-all" title="'.esc_html__('show all settings', 'nutrail').'"><i class="fa fa-outdent"></i></div>' : '';

            echo ($this->args['show_search']) ? '<div class="wpa-search"><input type="text" name="wpa-search" placeholder="'.esc_html__('Search...', 'nutrail').'" autocomplete="off" /></div>' : '';

            echo '<div class="wpa-buttons">';
            echo '<input type="submit" name="'.esc_attr($this->unique).'[_nonce][save]" class="button button-primary wpa-top-save wpa-save'.esc_attr($ajax_class).'" value="'.esc_html__('Save', 'nutrail').'" data-save="'.esc_html__('Saving...', 'nutrail').'">';
            echo ($this->args['show_reset']) ? '<input type="submit" name="wpa_transient[reset_section]" class="button button-secondary wpa-reset-section wpa-confirm" value="'.esc_html__('Reset Section', 'nutrail').'"  data-confirm="'.esc_html__('Are you sure to reset this section options?', 'nutrail').'">' : '';
            echo ($this->args['show_reset_all']) ? '<input type="submit" name="wpa_transient[reset]" class="button button-secondary wpa-warning-primary wpa-reset-all wpa-confirm" value="'.esc_html__('Reset All', 'nutrail').'" data-confirm="'.esc_html__('Are you sure to reset all options?', 'nutrail').'">' : '';
            echo '</div>';

            echo '</div>';

            echo '<div class="clear"></div>';
            echo '</div>';
            echo '</div>';

            echo '<div class="wpa-wrapper'.esc_attr($show_all).'">';

            if ($has_nav) {
                echo '<div class="wpa-nav wpa-nav-'.esc_attr($nav_type).' wpa-nav-options">';

                echo '<ul>';

                $tab_key = 1;

                foreach ($this->pre_tabs as $tab) {

                    $tab_error = $this->error_check($tab);
                    $tab_icon  = (!empty($tab['icon'])) ? '<i class="wpa-tab-icon '.esc_attr($tab['icon']).'"></i>' : '';

                    if (!empty($tab['sections'])) {
                        echo '<li class="wpa-tab-depth-0">';

                        echo '<a href="#tab='.esc_attr($tab_key).'" class="wpa-arrow">'.wp_kses_post($tab_icon.$tab['title'].$tab_error).'</a>';

                        echo '<ul>';

                        foreach ($tab['sections'] as $sub) {
                            $sub_error = $this->error_check($sub);
                            $sub_icon  = (!empty($sub['icon'])) ? '<i class="wpa-tab-icon '.esc_attr($sub['icon']).'"></i>' : '';

                            echo '<li class="wpa-tab-depth-1"><a id="wpa-tab-link-'.esc_attr($tab_key).'" href="#tab='.esc_attr($tab_key).'">'.wp_kses_post($sub_icon.$sub['title'].$sub_error).'</a></li>';

                            $tab_key++;
                        }

                        echo '</ul>';

                        echo '</li>';
                    } else {
                        echo '<li class="wpa-tab-depth-0"><a id="wpa-tab-link-'.esc_attr($tab_key).'" href="#tab='.esc_attr($tab_key).'">'.wp_kses_post($tab_icon.$tab['title'].$tab_error).'</a></li>';

                        $tab_key++;
                    }
                }

                echo '</ul>';

                echo '</div>';
            }

            echo '<div class="wpa-content">';

            echo '<div class="wpa-sections">';

            $section_key = 1;

            if (!empty($this->pre_sections)) {
                foreach ($this->pre_sections as $section) {
                    $onload       = (!$has_nav) ? ' wpa-onload' : '';
                    $section_icon = (!empty($section['icon'])) ? '<i class="wpa-section-icon '.esc_attr($section['icon']).'"></i>' : '';

                    echo '<div id="wpa-section-'.esc_attr($section_key).'" class="wpa-section'.esc_attr($onload).'">';
                    echo ($has_nav) ? '<div class="wpa-section-title"><h3>'.wp_kses_post($section_icon.$section['title']).'</h3></div>' : '';
                    echo (!empty($section['description'])) ? '<div class="wpa-field wpa-section-description">'.wp_kses_post($section['description']).'</div>' : '';

                    if (!empty($section['fields'])) {
                        foreach ($section['fields'] as $field) {
                            $is_field_error = $this->error_check($field);

                            if (!empty($is_field_error)) {
                                $field['_error'] = $is_field_error;
                            }

                            $value = (!empty($field['id']) && isset($this->options[$field['id']])) ? $this->options[$field['id']] : '';

                            echo WPA::field($field, $value, $this->unique, 'options');
                        }
                    } else {
                        echo '<div class="wpa-no-option wpa-text-muted">'.esc_html__('No option provided by developer.', 'nutrail').'</div>';
                    }

                    echo '</div>';

                    $section_key++;
                }
            }

            echo '</div>';

            echo '<div class="clear"></div>';

            echo '</div>';

            echo ($has_nav && $nav_type === 'normal') ? '<div class="wpa-nav-background"></div>' : '';

            echo '</div>';

            if (!empty($this->args['show_footer'])) {
                echo '<div class="wpa-footer">';

                echo '<div class="wpa-buttons">';
                echo '<input type="submit" name="wpa_transient[save]" class="button button-primary wpa-save'.esc_attr($ajax_class).'" value="'.esc_html__('Save', 'nutrail').'" data-save="'.esc_html__('Saving...', 'nutrail').'">';
                echo ($this->args['show_reset']) ? '<input type="submit" name="wpa_transient[reset_section]" class="button button-secondary wpa-reset-section wpa-confirm" value="'.esc_html__('Reset Section', 'nutrail').'" data-confirm="'.esc_html__('Are you sure to reset this section options?', 'nutrail').'">' : '';
                echo ($this->args['show_reset_all']) ? '<input type="submit" name="wpa_transient[reset]" class="button button-secondary wpa-warning-primary wpa-reset-all wpa-confirm" value="'.esc_html__('Reset All', 'nutrail').'" data-confirm="'.esc_html__('Are you sure to reset all options?', 'nutrail').'">' : '';
                echo '</div>';

                if (!empty($this->args['footer_text'])) {
                    echo '<div class="wpa-copyright">'.wp_kses_post($this->args['footer_text']).'</div>';
                }

                echo '<div class="clear"></div>';
                echo '</div>';
            }

            echo '</form>';

            echo '</div>';

            echo '<div class="clear"></div>';

            echo (!empty($this->args['footer_after'])) ? wp_kses_post($this->args['footer_after']) : '';

            echo '</div>';

            do_action('wpa_html_options_after');
        }
    }
}