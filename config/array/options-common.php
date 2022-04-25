<?php
$config_options_common = array(
    'name'        => 'section0',
    'title'       => esc_html__('Common settings', 'nutrail'),
    'description' => esc_html__('Describes the basic design used for the entire site. You can also use the external API here.', 'nutrail'),
    'icon'        => 'fas fa-cogs',
    'fields'      => array(
        array(
            'id'   => 'config-common',
            'type' => 'tabbed',
            'tabs' => array(
                array(
                    'title'  => esc_html__('Common', 'nutrail'),
                    'fields' => array(
                        array(
                            'id'    => 'sitename',
                            'type'  => 'text',
                            'title' => esc_html__('Site name', 'nutrail'),
                        ),
                        array(
                            'id'    => 'logo',
                            'type'  => 'media',
                            'title' => esc_html__('Logo', 'nutrail'),
                        ),
                        array(
                            'id'    => 'footer-logo',
                            'type'  => 'media',
                            'title' => esc_html__('Logo(footer)', 'nutrail'),
                        ),
                        array(
                            'id'      => 'font',
                            'type'    => 'select',
                            'default' => 'Noto Sans JP',
                            'options' => nutrail_webfont(),
                            'title'   => esc_html__('Font site', 'nutrail'),
                        ),
                        array(
                            'id'    => 'lazyload',
                            'type'  => 'switcher',
                            'title' => esc_html__('Lazyload', 'nutrail'),
                        ),
                    ),
                ),
                array(
                    'title'  => esc_html__('Navbar', 'nutrail'),
                    'fields' => array(
                        array(
                            'id'    => 'navbar_tel_description',
                            'type'  => 'text',
                            'title' => esc_html__('Description below the phone number', 'nutrail'),
                        ),
                        array(
                            'id'    => 'navbar_btn1',
                            'type'  => 'link',
                            'title' => esc_html__('Button(priority)', 'nutrail'),
                        ),
                        array(
                            'id'    => 'navbar_btn2',
                            'type'  => 'link',
                            'title' => esc_html__('Button', 'nutrail'),
                        ),
                    ),
                ),
                array(
                    'title'  => esc_html__('Privacy Policy', 'nutrail'),
                    'fields' => array(
                        array(
                            'id'    => 'privacypolicy_name',
                            'type'  => 'text',
                            'title' => esc_html__('Name', 'nutrail'),
                        ),
                        array(
                            'id'    => 'privacypolicy_staffname',
                            'type'  => 'text',
                            'title' => esc_html__('Responsible party', 'nutrail'),
                        ),
                        array(
                            'id'    => 'privacypolicy_contact',
                            'type'  => 'text',
                            'title' => esc_html__('Contact address', 'nutrail'),
                        ),
                    ),
                ),
                $config_options_common_color
            )
        ),
    ),
);