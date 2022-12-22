<?php
$config_options_company = array(
    'name'        => 'section1',
    'title'       => esc_html__('Company information', 'nutrail'),
    'description' => esc_html__('Describe the contents of corporate information. It will be displayed on the company profile page, phone number, etc. displayed on the menu bar.', 'nutrail'),
    'icon'        => 'fas fa-building',
    'fields'      => array(
        array(
            'id'   => 'config-company',
            'type' => 'tabbed',
            'tabs' => array(
                array(
                    'title'  => esc_html__('Company basic information', 'nutrail'),
                    'fields' => array(
                        array(
                            'id'    => 'company_name',
                            'type'  => 'text',
                            'title' => esc_html__('Company name', 'nutrail')
                        ),
                        array(
                            'id'    => 'company_name-kana',
                            'type'  => 'text',
                            'title' => esc_html__('Company name(Kana)', 'nutrail')
                        ),
                        array(
                            'id'    => 'company_name-eng',
                            'type'  => 'text',
                            'title' => esc_html__('Company name(English)', 'nutrail')
                        ),
                        array(
                            'id'    => 'company_president-name',
                            'type'  => 'text',
                            'title' => esc_html__('Representatives name', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_president-post',
                            'type'  => 'text',
                            'title' => esc_html__('Representatives title', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_officer',
                            'type'  => 'textarea',
                            'title' => esc_html__('Officer', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_businesscontent',
                            'type'  => 'textarea',
                            'title' => esc_html__('Business contents', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_license',
                            'type'  => 'textarea',
                            'title' => esc_html__('Qualification / authorization', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_bank',
                            'type'  => 'textarea',
                            'title' => esc_html__('Bank', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_customer',
                            'type'  => 'textarea',
                            'title' => esc_html__('Major customers', 'nutrail'),
                        ),
                    ),
                ),
                array(
                    'title'  => esc_html__('Headquarters location', 'nutrail'),
                    'fields' => array(
                        array(
                            'id'    => 'company_postnum',
                            'type'  => 'text',
                            'title' => esc_html__('post code', 'nutrail')
                        ),
                        array(
                            'id'          => 'company_pref',
                            'type'        => 'select',
                            'title'       => esc_html__('prefectures', 'nutrail'),
                            'placeholder' => esc_html__('Select a prefecture', 'nutrail'),
                            'options'     => load_pref()
                        ),
                        array(
                            'id'    => 'company_city',
                            'type'  => 'text',
                            'title' => esc_html__('municipalities', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_street',
                            'type'  => 'text',
                            'title' => esc_html__('Ding / address', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_build',
                            'type'  => 'text',
                            'title' => esc_html__('Building / floor / room number', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_map_link',
                            'type'  => 'link',
                            'title' => esc_html__('Link to map', 'nutrail'),
                        ),
                    ),
                ),
                array(
                    'title'  => esc_html__('Headquarters contact', 'nutrail'),
                    'fields' => array(
                        array(
                            'id'    => 'company_contact_tel',
                            'type'  => 'text',
                            'title' => esc_html__('Inquiry reception phone number', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_contact_email',
                            'type'  => 'text',
                            'title' => esc_html__('Inquiry reception email address', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_tel',
                            'type'  => 'text',
                            'title' => esc_html__('Headquarters phone number', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_fax',
                            'type'  => 'text',
                            'title' => esc_html__('Headquarters fax number', 'nutrail'),
                        ),
                        array(
                            'id'       => 'company_geo',
                            'type'     => 'map',
                            'title'    => esc_html__('Headquarters Map', 'nutrail'),
                            'settings' => [
                                'zoom' => 10
                            ],
                        ),
                    ),
                ),
                array(
                    'title'  => esc_html__('Business days / hours', 'nutrail'),
                    'fields' => array(
                        array(
                            'id'    => 'company_open_day_monday',
                            'type'  => 'switcher',
                            'title' => esc_html__('Monday', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_open_day_tuesday',
                            'type'  => 'switcher',
                            'title' => esc_html__('Tuesday', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_open_day_wednesday',
                            'type'  => 'switcher',
                            'title' => esc_html__('Wednesday', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_open_day_thursday',
                            'type'  => 'switcher',
                            'title' => esc_html__('Thursday', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_open_day_friday',
                            'type'  => 'switcher',
                            'title' => esc_html__('Friday', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_open_day_saturday',
                            'type'  => 'switcher',
                            'title' => esc_html__('Saturday', 'nutrail'),
                        ),
                        array(
                            'id'    => 'company_open_day_sunday',
                            'type'  => 'switcher',
                            'title' => esc_html__('Sunday', 'nutrail'),
                        ),
                        array(
                            'id'         => 'company_open_time_opens',
                            'type'       => 'text',
                            'attributes' => [
                                'type' => 'time',
                            ],
                            'title'      => esc_html__('Business start time', 'nutrail'),
                        ),
                        array(
                            'id'         => 'company_open_time_closes',
                            'type'       => 'text',
                            'attributes' => [
                                'type' => 'time',
                            ],
                            'title'      => esc_html__('Closing time', 'nutrail'),
                        ),
                        array(
                            'id'         => 'company_open_time_sutur_sun_opens',
                            'type'       => 'text',
                            'attributes' => [
                                'type' => 'time',
                            ],
                            'title'      => esc_html__('Business start time (Saturday and Sunday)', 'nutrail'),
                        ),
                        array(
                            'id'         => 'company_open_time_sutur_sun_closes',
                            'type'       => 'text',
                            'attributes' => [
                                'type' => 'time',
                            ],
                            'title'      => esc_html__('Business closing time (Saturday and Sunday)', 'nutrail'),
                        ),
                    ),
                ),
                array(
                    'title'  => esc_html__('Company image','nutrail'),
                    'fields' => array(
                        array(
                            'id'    => 'company_image1',
                            'type'  => 'upload',
                            'title' => esc_html__('Company image1','nutrail'),
                        ),
                        array(
                            'id'    => 'company_image2',
                            'type'  => 'upload',
                            'title' => esc_html__('Company image2','nutrail'),
                        ),
                        array(
                            'id'    => 'company_image3',
                            'type'  => 'upload',
                            'title' => esc_html__('Company image3','nutrail'),
                        ),
                    ),
                ),
            )
        ),
    )
);