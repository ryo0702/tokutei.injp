<?php
function widget_config_class($name = null)
{
    return array(
        'id'    => $name,
        'type'  => 'text',
        'title' => 'Class',
    );
}

function widget_config_bg($name = null, $output = null)
{
    $field = array(
        'id'      => $name,
        'type'    => 'background',
        'title'   => esc_html__('Background image', 'nutrail'),
        'default' => array(
            'background-color'      => '',
            'background-position'   => 'center center',
            'background-repeat'     => 'repeat-x',
            'background-attachment' => 'fixed',
            'background-size'       => 'cover',
        )
    );

    if ($output != null) {
        $field['output'] = $output;
    }

    return $field;
}

function widget_config_padding($name = null)
{
    return array(
        'id'      => $name,
        'type'    => 'select',
        'title'   => esc_html__('Padding', 'nutrail'),
        'options' => load_size('pad-y-'),
        'default' => ''
    );
}

function widget_config_showanimation($name = null)
{
    return array(
        'id'      => 'showanimation',
        'type'    => 'select',
        'title'   => esc_html__('Scroll animation', 'nutrail'),
        'options' => array(
            ''                           => esc_html__('none', 'nutrail'),
            'animate__fadeIn'            => esc_html__('fade in', 'nutrail'),
            'animate__zoomIn'            => esc_html__('zoom in', 'nutrail'),
            'animate__bounce'            => esc_html__('bounce', 'nutrail'),
            'animate__bounceIn'          => esc_html__('bounce in', 'nutrail'),
            'animate__pulse'             => esc_html__('pulse', 'nutrail'),
            'animate__flash'             => esc_html__('flash', 'nutrail'),
            'animate__flipInX'           => esc_html__('flip X', 'nutrail'),
            'animate__flipInY'           => esc_html__('flip Y', 'nutrail'),
            'animate__lightSpeedInRight' => esc_html__('speed in right', 'nutrail'),
            'animate__lightSpeedInLeft'  => esc_html__('speed in left', 'nutrail'),
            'animate__slideInDown'       => esc_html__('slide in donwn', 'nutrail'),
            'animate__slideInUp'         => esc_html__('slide in up', 'nutrail'),
        ),
        'default' => '',
    );
}

function load_pref()
{
    return array(
        '北海道'  => '北海道',
        '青森県'  => '青森県',
        '岩手県'  => '岩手県',
        '宮城県'  => '宮城県',
        '秋田県'  => '秋田県',
        '山形県'  => '山形県',
        '福島県'  => '福島県',
        '茨城県'  => '茨城県',
        '栃木県'  => '栃木県',
        '群馬県'  => '群馬県',
        '埼玉県'  => '埼玉県',
        '千葉県'  => '千葉県',
        '東京都'  => '東京都',
        '神奈川県' => '神奈川県',
        '新潟県'  => '新潟県',
        '富山県'  => '富山県',
        '石川県'  => '石川県',
        '福井県'  => '福井県',
        '山梨県'  => '山梨県',
        '長野県'  => '長野県',
        '岐阜県'  => '岐阜県',
        '静岡県'  => '静岡県',
        '愛知県'  => '愛知県',
        '三重県'  => '三重県',
        '滋賀県'  => '滋賀県',
        '京都府'  => '京都府',
        '大阪府'  => '大阪府',
        '兵庫県'  => '兵庫県',
        '奈良県'  => '奈良県',
        '和歌山県' => '和歌山県',
        '鳥取県'  => '鳥取県',
        '島根県'  => '島根県',
        '岡山県'  => '岡山県',
        '広島県'  => '広島県',
        '山口県'  => '山口県',
        '徳島県'  => '徳島県',
        '香川県'  => '香川県',
        '愛媛県'  => '愛媛県',
        '高知県'  => '高知県',
        '福岡県'  => '福岡県',
        '佐賀県'  => '佐賀県',
        '長崎県'  => '長崎県',
        '熊本県'  => '熊本県',
        '大分県'  => '大分県',
        '宮崎県'  => '宮崎県',
        '鹿児島県' => '鹿児島県',
        '沖縄県'  => '沖縄県',
    );
}

function load_contactform_input_type()
{
    return array(
        'input_name'            => esc_html__('name', 'nutrail'),
        'input_email'           => esc_html__('email', 'nutrail'),
        'input_phone_number'    => esc_html__('phone number', 'nutrail'),
        'input_sp_phone_number' => esc_html__('mobile phone number', 'nutrail'),
        'input_text'            => esc_html__('text', 'nutrail'),
        'input_textarea'        => esc_html__('textarea', 'nutrail'),
        'input_radio_yesno'     => esc_html__('select yes no', 'nutrail'),
        'input_select'          => esc_html__('select', 'nutrail'),
    );
}

function load_size($size = null)
{
    return array(
        '' => esc_html__('none', 'nutrail'),
        @$size.'xs' => 'XS',
        @$size.'s'  => 'S',
        @$size.'m'  => 'M',
        @$size.'l'  => 'L',
        @$size.'xl' => 'XL',
    );
}

function widget_config_link($name = null, $title = null)
{
    return array(
        'id'    => $name,
        'type'  => 'link',
        'title' => $title,
    );
}