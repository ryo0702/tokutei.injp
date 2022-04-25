<?php
$config_options_common_color = array(
    'title'  => esc_html__('Color settings', 'nutrail'),
    'fields' => array(
        array(
            'id'     => 'colors',
            'type'   => 'fieldset',
            'fields' => array(
                array(
                    'id'      => 'body',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Body color', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Default', 'nutrail'),
                        'section_bg1'  => esc_html__('Section bg1', 'nutrail'),
                        'section_bg1_text'  => esc_html__('Section bg1 text', 'nutrail'),
                        'section_bg2'  => esc_html__('Section bg2', 'nutrail'),
                        'section_bg2_text'  => esc_html__('Section bg1 text', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#fff',
                        'section_bg1'  => '#fff',
                        'section_bg1_text'  => '#505050',
                        'section_bg2'  => '#f3f3f3',
                        'section_bg2_text'  => '#505050',
                    )
                ),
                array(
                    'id'      => 'text',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Text color', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Default', 'nutrail'),
                        'title_lg'  => esc_html__('Title(large)', 'nutrail'),
                        'title_lg2'  => esc_html__('Title(large)2', 'nutrail'),
                        'link'  => esc_html__('Link', 'nutrail'),
                        'link_hover'  => esc_html__('Link(hover)', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#505050',
                        'title_lg'  => '#dadada',
                        'link'  => '#505050',
                        'link_hover'  => '#383838',
                    )
                ),
                array(
                    'id'      => 'posts',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Posts color', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Text', 'nutrail'),
                        'h1h2_text'  => esc_html__('H1&H2 text color', 'nutrail'),
                        'h1h2_bg'  => esc_html__('H1&H2 background', 'nutrail'),
                        'h1h2_border'  => esc_html__('H1&H2 background', 'nutrail'),
                        'h3_text'  => esc_html__('H3 text color', 'nutrail'),
                        'h3_bg'  => esc_html__('H3 background', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#505050',
                        'h1h2_text'  => '#505050',
                        'h1h2_bg'  => '#f3f3f3',
                        'h1h2_border'  => '#aaaaaa',
                        'h3_text'  => '#505050',
                        'h3_bg'  => '#f3f3f3',
                    )
                ),
                array(
                    'id'      => 'card',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Card color', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Background', 'nutrail'),
                        'text'  => esc_html__('text color', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#fff',
                        'text'  => '#505050',
                    )
                ),
                array(
                    'id'      => 'form',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Form input color', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Text', 'nutrail'),
                        'line'  => esc_html__('line color', 'nutrail'),
                        'placeholder'  => esc_html__('Placeholder text', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#fff',
                        'line'  => '#505050',
                        'placeholder'  => '#b3b3b3',
                    )
                ),
                array(
                    'id'      => 'line',
                    'type'    => 'color',
                    'title'   => esc_html__('Line color', 'nutrail'),
                    'default' => '#aaaaaa',
                ),
                array(
                    'id'      => 'table',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Table', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Background', 'nutrail'),
                        'text'  => esc_html__('Text', 'nutrail'),
                        'th_bg'  => esc_html__('Titile background', 'nutrail'),
                        'border'  => esc_html__('Border', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#fff',
                        'text'  => '#505050',
                        'th_bg'  => '#dddddd',
                        'border'  => '#c4c4c4',
                    )
                ),
                array(
                    'id'      => 'navbar',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Color navbar', 'nutrail'),
                    'options' => array(
                        'top-bg'    => esc_html__('Top background', 'nutrail'),
                        'top-bg_hover'    => esc_html__('Top background(hover)', 'nutrail'),
                        'top-text'    => esc_html__('Top text', 'nutrail'),
                        'bottom-bg' => esc_html__('Bottom background', 'nutrail'),
                        'bottom-bg_hover'    => esc_html__('Bottom background(hover)', 'nutrail'),
                        'bottom-text' => esc_html__('Bottom text', 'nutrail'),
                        'line' => esc_html__('Line color', 'nutrail'),
                    ),
                    'default' => array(
                        'top-bg'    => '#fff',
                        'top-bg_hover'    => '#f5f5f5',
                        'top-text'    => '#4d4d4d',
                        'bottom-bg' => '#f3f3f3',
                        'bottom-bg_hover' => '#e7e7e7',
                        'bottom-text' => '#4d4d4d',
                        'line' => '#f3f3f3',
                    )
                ),
                array(
                    'id'      => 'primary',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Color(primary)', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Default', 'nutrail'),
                        'text' => esc_html__('Text', 'nutrail'),
                        'hover'  => esc_html__('Hover', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#2677E5',
                        'text' => '#fff',
                        'hover'  => '#1f62be',
                    )
                ),
                array(
                    'id'      => 'danger',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Color(danger)', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Default', 'nutrail'),
                        'text' => esc_html__('Text', 'nutrail'),
                        'hover'  => esc_html__('Hover', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#E52626',
                        'text' => '#fff',
                        'hover'  => '#b81f1f',
                    )
                ),
                array(
                    'id'      => 'warning',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Color(warning)', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Default', 'nutrail'),
                        'text' => esc_html__('Text', 'nutrail'),
                        'hover'  => esc_html__('Hover', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#FF8900',
                        'text' => '#fff',
                        'hover'  => '#bb6400',
                    )
                ),
                array(
                    'id'      => 'success',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Color(success)', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Default', 'nutrail'),
                        'text' => esc_html__('Text', 'nutrail'),
                        'hover'  => esc_html__('Hover', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#09D347',
                        'text' => '#fff',
                        'hover'  => '#06a736',
                    )
                ),
                array(
                    'id'      => 'info',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Color(info)', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Default', 'nutrail'),
                        'text' => esc_html__('Text', 'nutrail'),
                        'hover'  => esc_html__('Hover', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#12C6F0',
                        'text' => '#fff',
                        'hover'  => '#0d9ab9',
                    )
                ),
                array(
                    'id'      => 'keyvisual',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Keyvisual', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Text', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#ffffff',
                    )
                ),
                array(
                    'id'      => 'keyvisual_btn',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Color(Key visual button)', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Default', 'nutrail'),
                        'darken'  => esc_html__('Darken', 'nutrail'),
                        'text'  => esc_html__('Text', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#ffffff',
                        'darken'  => '#f7f7f7',
                        'text'  => '#E52626',
                    )
                ),
                array(
                    'id'      => 'footer',
                    'type'    => 'color_group',
                    'title'   => esc_html__('Footer', 'nutrail'),
                    'options' => array(
                        'default' => esc_html__('Background', 'nutrail'),
                        'text'  => esc_html__('Text', 'nutrail'),
                    ),
                    'default' => array(
                        'default' => '#dfdfdf',
                        'text'  => '#8b8b8b',
                    )
                ),
            )
        ),
    ),
);