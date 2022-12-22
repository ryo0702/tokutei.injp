<?php
// load array
include get_template_directory().'/array_common.php';

$array_feature_point = array(
    '日本語教育' => '日本語教育',
    '職業教育' => '職業教育',
    '日本の生活知識' => '日本の生活知識',
    '体力作り' => '体力作り',
    '実習生の負担軽減' => '実習生の負担軽減',
    '入国後のサポート' => '入国後のサポート',
);

$array_feature_kyoiku = array(
    'ノビノビとした自由な教育' => 'ノビノビとした自由な教育',
    '徹底した詰め込み学習' => '徹底した詰め込み学習',
    '独自の教科書を用意' => '独自の教科書を用意',
    '日本語教育よりも専門教育' => '日本語教育よりも専門教育',
);

$array_metabox_okuridashi = array(
    'id'        => 'okuridashi',
    'title'     => '送り出し機関',
    'post_type' => 'okuridashi',
    'context'   => 'normal',
    'priority'  => 'high',
    'sections'  => array(
        array(
            'name'   => 'basicinfo',
            'title'  => '基本情報',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'logo',
                    'type'  => 'media',
                    'title' => 'ロゴ',
                ),
                array(
                    'id'    => 'okuridashi_eng_name',
                    'type'  => 'text',
                    'title' => '送り出し機関の正式名(英語もしくは所在地の言語)',
                ),
                array(
                    'id'    => 'okuridashi_eng_daihyo_name',
                    'type'  => 'text',
                    'title' => '代表者名(英語もしくは所在地の言語)',
                ),
                array(
                    'id'    => 'okuridashi_kana_daihyo_name',
                    'type'  => 'text',
                    'title' => '代表者名(カタカナ)',
                ),
                array(
                    'id'    => 'type',
                    'type'  => 'checkbox',
                    'options' => $array_okuridasi_zairyushikaku,
                    'title' => '送り出し在留資格',
                ),
                array(
                    'id'    => 'nation',
                    'type'  => 'radio',
                    'options'  => $array_nation_group,
                    'title' => '送り出し国',
                ),
                array(
                    'id'    => 'city',
                    'type'  => 'text',
                    'title' => '本社の都市名(カタカナ)',
                ),
                array(
                    'id'    => 'okuridashi_detail_page_view',
                    'type'  => 'radio',
                    'options'  => array(
                        '' => '非表示',
                        'okuridashi_detail_page_view_on' => '表示',
                    ),
                    'title' => '送り出し機関詳細ページ表示',
                ),
            ),
        ),
        array(
            'name'   => 'addr',
            'title'  => '所在地',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'addr',
                    'type'  => 'text',
                    'title' => '住所',
                ),
                array(
                    'id'    => 'map',
                    'type'  => 'text',
                    'title' => 'マップ',
                ),
            ),
        ),
        array(
            'name'   => 'detail',
            'title'  => '対応・実績',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'okuridashi_ninzu',
                    'type'  => 'number',
                    'title' => '年間送り出し人数',
                ),
                array(
                    'id'    => 'nihonjin_staff',
                    'type'  => 'switcher',
                    'title' => '日本人教師および日本人スタッフの有無',
                ),
                array(
                    'id'    => 'nihonkokunai_staff',
                    'type'  => 'switcher',
                    'title' => '日本国内のスタッフの有無',
                ),
                array(
                    'id'    => 'tokutaiginou_taiou',
                    'type'  => 'switcher',
                    'title' => '特定技能 送り出し',
                ),
                array(
                    'id'    => 'kaigojissusei_taiou',
                    'type'  => 'switcher',
                    'title' => '介護実習生 送り出し',
                ),
                array(
                    'id'    => 'ginokentei',
                    'type'  => 'switcher',
                    'title' => '技能検定対策',
                ),
            ),
        ),
        array(
            'name'   => 'setsubi',
            'title'  => '設備・施設',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'setsubi_gomi',
                    'type'  => 'switcher',
                    'title' => 'ごみ分別訓練',
                ),
                array(
                    'id'    => 'setsubi_sports',
                    'type'  => 'switcher',
                    'title' => '運動施設',
                ),
                array(
                    'id'    => 'setsubi_guntai',
                    'type'  => 'switcher',
                    'title' => '軍隊式訓練',
                ),
                array(
                    'id'    => 'setsubi_jidosha',
                    'type'  => 'switcher',
                    'title' => '自動車整備訓練設備',
                ),
                array(
                    'id'    => 'setsubi_seiso',
                    'type'  => 'switcher',
                    'title' => '清掃(ビルメンテ)訓練設備',
                ),
                array(
                    'id'    => 'setsubi_bedmake',
                    'type'  => 'switcher',
                    'title' => 'ベットメイク訓練設備',
                ),
                array(
                    'id'    => 'setsubi_shokuhinkakou',
                    'type'  => 'switcher',
                    'title' => '食品加工訓練設備',
                ),
                array(
                    'id'    => 'setsubi_nougyo',
                    'type'  => 'switcher',
                    'title' => '農業訓練設備',
                ),
                array(
                    'id'    => 'setsubi_yousetsu',
                    'type'  => 'switcher',
                    'title' => '溶接訓練設備',
                ),
                array(
                    'id'    => 'setsubi_kensetsukikai',
                    'type'  => 'switcher',
                    'title' => '建設機械',
                ),
                array(
                    'id'    => 'setsubi_sakan',
                    'type'  => 'switcher',
                    'title' => '左官訓練設備',
                ),
                array(
                    'id'    => 'setsubi_ashiba',
                    'type'  => 'switcher',
                    'title' => '足場訓練設備',
                ),
            ),
        ),
        array(
            'name'   => 'main_contents',
            'title'  => 'メインコンテンツ',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'photo_main',
                    'type'  => 'media',
                    'title' => 'メイン写真(横写真)',
                ),
                array(
                    'id'    => 'photo_kyoiku',
                    'type'  => 'media',
                    'title' => '教育風景写真(横写真)',
                ),
                array(
                    'id'    => 'photo_daihyosha',
                    'type'  => 'media',
                    'title' => '代表者写真(縦写真)',
                ),
                array(
                    'id'    => 'daihyosha_name',
                    'type'  => 'text',
                    'title' => '代表者名(カタカナ表記)',
                ),
                array(
                    'id'    => 'daihyosha_post',
                    'type'  => 'text',
                    'title' => '代表者役職',
                ),
                array(
                    'id'    => 'text_daihyosha_greeting',
                    'type'  => 'textarea',
                    'title' => '代表者挨拶文',
                ),
                array(
                    'id'    => 'text_teikeisaki',
                    'type'  => 'textarea',
                    'title' => '提携先教育機関等',
                ),
            ),
        ),
        array(
            'name'   => 'tokushoku',
            'title'  => '特色',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'feature_point1',
                    'type'  => 'radio',
                    'options'  => $array_feature_point,
                    'default' => '',
                    'title' => '力を入れているのは(1番目)',
                ),
                array(
                    'id'    => 'feature_point2',
                    'type'  => 'radio',
                    'options'  => $array_feature_point,
                    'title' => '力を入れているのは(2番目)',
                ),
                array(
                    'id'    => 'feature_point3',
                    'type'  => 'radio',
                    'options'  => $array_feature_point,
                    'title' => '力を入れているのは(3番目)',
                ),
                array(
                    'id'    => 'kyoikuhoushin',
                    'type'  => 'radio',
                    'options'  => $array_feature_kyoiku,
                    'title' => '教育方針',
                ),
                array(
                    'id'    => 'n3seito',
                    'type'  => 'number',
                    'title' => 'N3相当の生徒の年間輩出量',
                ),
            ),
        ),
        array(
            'name'   => 'data',
            'title'  => 'データ',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'kyokashou',
                    'type'  => 'media',
                    'title' => '許可証',
                ),
                array(
                    'id'    => 'pamphlet',
                    'type'  => 'media',
                    'title' => 'パンフレット',
                ),
            ),
        ),
    ),
);