<?php
/**
 * Custom Post Type & Custom Field
 */

function nutrail_config_register_cpt()
{
    $file = '/config/array/post-type.php';

    if (file_exists(get_stylesheet_directory().$file)) {
        include_once get_stylesheet_directory().$file;
    } elseif (file_exists(get_template_directory().$file)) {
        include_once get_template_directory().$file;
    }

    if (!empty($array_cpt) && is_array(@$array_cpt)) {
        foreach ($array_cpt as $cpt_name => $cpt_value) {
            if ($cpt_name !== 'post' and $cpt_name !== 'page') {
                $cpt_config = [
                    'labels'              => [
                        'name'          => @$cpt_value['title'],
                        'singular_name' => @$cpt_value['titles'],
                    ],
                    'public'              => @$cpt_value['public'],
                    'exclude_from_search' => @$cpt_value['search'],
                    'has_archive'         => @$cpt_value['archive'],
                    'show_in_menu'        => @$cpt_value['adminmenu'],
                    'show_in_rest'        => @$cpt_value['restapi'],
                    'supports'            => @$cpt_value['supports'],
                    'hierarchical'        => true,
                ];
                call_user_func('register'.'_post_type', $cpt_name, $cpt_config);
            }
        }
    }
}