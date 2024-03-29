<?php
// load array
include get_template_directory().'/array_common.php';

$inser_array_pref = null;
foreach ($array_pref_group2 as $area) {
    foreach ($area as $pref) {
        $inser_array_pref[$pref[1]] = $pref[1];
    }
}

$array_metabox_hr = array(
    'id'        => 'hr',
    'title'     => '外国人人材',
    'post_type' => 'hr',
    'context'   => 'normal',
    'priority'  => 'high',
    'sections'  => array(
        array(
            'name'   => 'basicinfo',
            'title'  => '基本情報',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'name_katakana',
                    'type'  => 'text',
                    'title' => '氏名(カタカナ)',
                ),
                array(
                    'id'    => 'name_pub',
                    'type'  => 'select',
                    'title' => '名前の公開',
                    'options' => array(
                        '' => '公開',
                        'off' => '非公開'
                    )
                ),
                array(
                    'id'    => 'name_eiji',
                    'type'  => 'text',
                    'title' => '英字',
                ),
                array(
                    'id'    => 'nation',
                    'type'  => 'select',
                    'options'  => $array_nation_group,
                    'title' => '出身国',
                ),
                array(
                    'id'    => 'visa',
                    'type'  => 'select',
                    'options'  => $array_zairyushikaku,
                    'title' => '現在の在留資格',
                ),
                array(
                    'id'    => 'birth_y',
                    'type'  => 'number',
                    'title' => '生まれ年(西暦)',
                ),
                array(
                    'id'    => 'birth_m',
                    'type'  => 'number',
                    'title' => '生まれ月',
                ),
                array(
                    'id'    => 'birth_d',
                    'type'  => 'number',
                    'title' => '生まれ日',
                ),
                array(
                    'id'    => 'jlpt',
                    'type'  => 'select',
                    'options'  => $array_jlpt,
                    'title' => '日本語検定',
                ),
                array(
                    'id'    => 'salary',
                    'type'  => 'number',
                    'options'  => $array_jlpt,
                    'title' => '希望手取り給料(円)',
                ),
                array(
                    'id'    => 'pref',
                    'type'  => 'select',
                    'multiple' => true,
                    'options'  => $inser_array_pref,
                    'title' => '就労可能地域',
                ),
                array(
                    'id'    => 'toppageview',
                    'type'  => 'select',
                    'options'  => array(
                        '' => 'トップページに非表示',
                        'viewtoppage_on' => 'トップページに表示'
                    ),
                    'title' => 'トップページへの表示',
                ),
            ),
        ),
        array(
            'name'   => 'history',
            'title'  => '経歴',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'jissusei_shokushu',
                    'type'  => 'select',
                    'options'  => $array_shokushu_group2,
                    'title' => '(元・現)技能実習生の場合の職種',
                ),
                array(
                    'id'    => 'daigaku_japan',
                    'type'  => 'text',
                    'title' => '大学名(日本)',
                ),
                array(
                    'id'    => 'daigaku_bokoku',
                    'type'  => 'text',
                    'title' => '大学名(母国)',
                ),
                array(
                    'id'     => 'history',
                    'type'   => 'group',
                    'title'  => '職歴',
                    'fields' => array(
                        array(
                            'id'    => 'title',
                            'type'  => 'text',
                            'title' => '会社名',
                        ),
                        array(
                            'id'    => 'content',
                            'type'  => 'textarea',
                            'title' => '仕事内容',
                        ),
                        array(
                            'id'    => 'start_ym',
                            'type'  => 'date',
                            'title' => '開始年月',
                        ),
                        array(
                            'id'    => 'end_ym',
                            'type'  => 'date',
                            'title' => '修了年月',
                        ),
                    )
                ),
            ),
        ),
        array(
            'name'   => 'evaluation',
            'title'  => '評価',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'evaluation_seikaku',
                    'type'  => 'select',
                    'options'  => $array_seikaku,
                    'title' => '性格',
                ),
                array(
                    'id'    => 'consultant_comment',
                    'type'  => 'text',
                    'title' => 'コンサルタントのコメント',
                ),
                array(
                    'id'    => 'consultant',
                    'type'  => 'text',
                    'title' => 'コンサルタント・登録支援機関',
                ),
            ),
        ),
    ),
);