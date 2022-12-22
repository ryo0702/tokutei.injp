<?php
/**
 * Load plugins.
 */
if (!class_exists('TGM_Plugin_Activation')) {
    require_once NUTRAIL_CORE_PATH.'classes/class-tgm-plugin-activation.php';
}

function nutrail_register_load_plugins()
{
    $file = '/config/array/plugins.php';

    if (file_exists(get_stylesheet_directory().$file)) {
        include_once get_stylesheet_directory().$file;
    } elseif (file_exists(get_template_directory().$file)) {
        include_once get_template_directory().$file;
    }

    if (!empty($plugins)) {
        /*
         * Array of configuration settings. Amend each line as needed.
         *
         * TGMPA will start providing localized text strings soon. If you already have translations of our standard
         * strings available, please help us make TGMPA even better by giving us access to these translations or by
         * sending in a pull-request with .po file(s) with the translations.
         *
         * Only uncomment the strings in the config array if you want to customize the strings.
         */
        $config = array(
            'id'           => 'wpa_plugins',
            'default_path' => '',
            'menu'         => 'wpa-install-plugins',
            'parent_slug'  => 'themes.php',
            'capability'   => 'edit_theme_options',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => true,
            'message'      => '',
        );
        tgmpa($plugins, $config);
    }
}
