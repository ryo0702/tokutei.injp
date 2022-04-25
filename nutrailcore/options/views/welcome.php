<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

if (!class_exists('WPA_Welcome')) {
    class WPA_Welcome
    {
        private static $instance = null;

        // instance
        public static function instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function __construct()
        {
            add_action('admin_menu', array($this, 'add_about_menu'), 30);
            add_action('admin_print_styles', array($this, 'fix_icon_display'));

            // enqueue core scripts
            add_filter('wpa_admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        }

        public function add_about_menu()
        {
            add_submenu_page(
                'admin_options',
                esc_html__('Manual', 'nutrail'),
                esc_html__('Manual', 'nutrail'),
                'manage_options',
                'wpa-welcome',
                array($this, 'add_page_manual'),
            );
        }

        public function enqueue_scripts()
        {
            $page = (!empty($_GET['page'])) ? sanitize_text_field(wp_unslash($_GET['page'])) : '';

            if (is_admin() && !empty($page) && ($page == 'wpa-welcome' || $page == 'wpa-import')) {
                return true;
            }

            return false;
        }

        public function fix_icon_display()
        {
            echo '<style type="text/css">.toplevel_page_wpa-welcome img { width: 18px; }</style>';
        }

        public function add_page_manual()
        {
            WPA::include_plugin_file('views/header.php');

            // safely include pages
            WPA::include_plugin_file('views/documentation.php');

            WPA::include_plugin_file('views/footer.php');
        }

    }

    WPA_Welcome::instance();
}
