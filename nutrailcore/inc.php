<?php
/**
 * Start Session
 */
session_start();

function nutrailcore(){   
}

/**
 * Define WPC Core
 */
define('WPOPTIONKEY', 'config-theme');
define('NUTRAIL_THEME_DIR', trailingslashit(get_template_directory()));
define('NUTRAIL_THEME_URI', trailingslashit(esc_url(get_template_directory_uri())));
define('NUTRAIL_CORE_PATH', NUTRAIL_THEME_DIR.'nutrailcore/');
define('NUTRAIL_CORE_URL', NUTRAIL_THEME_DIR.'nutrailcore/');
define('WPPRESETPATH', NUTRAIL_CORE_PATH.'preset');
define('WPPRESETURI', NUTRAIL_CORE_URL.'preset');

/**
 * Load Functions
 */
require_once NUTRAIL_CORE_PATH.'include/widget-array.php';
require_once NUTRAIL_CORE_PATH.'include/post-type.php';
require_once NUTRAIL_CORE_PATH.'include/nonce.php';
require_once NUTRAIL_CORE_PATH.'include/theme.php';
// require_once NUTRAIL_CORE_PATH.'include/plugins.php';
require_once NUTRAIL_CORE_PATH.'include/adminform.php';

// Admin Page
require_once NUTRAIL_CORE_PATH.'include/inquiries.php';
require_once NUTRAIL_CORE_PATH.'include/themesetup.php';

/**
 * Load Core
 */
require_once NUTRAIL_CORE_PATH.'options/options.php';

/**
 * Load Config
 */
require_once NUTRAIL_THEME_DIR.'config/system.php';
require_once NUTRAIL_THEME_DIR.'config/admin.php';
