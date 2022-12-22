<?php
// load array
include get_template_directory().'/array_common.php';

// okuridashi
$inser_array_okuridashi = null;
$inser_array_okuridashi[] = 'なし';
$the_query_okuridasi = new WP_Query( array( 'post_type' => 'okuridashi','posts_per_page' => -1 ) );
if ( $the_query_okuridasi->have_posts() ) {
    while ( $the_query_okuridasi->have_posts() ) {
        $the_query_okuridasi->the_post();
        $inser_array_okuridashi[get_the_ID()] = get_the_title();
    }
    wp_reset_postdata();
}

// pref
$inser_array_pref = null;
foreach ($array_pref_group2 as $area) {
    foreach ($area as $pref) {
        $inser_array_pref[$pref[1]] = $pref[1];
    }
}

// shokushu
$inser_array_shokushu = null;
foreach ($array_shokushu_group as $shokushu_array) {
    foreach ($shokushu_array as $shokushu) {
        $inser_array_shokushu[$shokushu[0]] = $shokushu[1];
    }
}


$array_metabox_estimates = array(
    'id'        => 'estimates',
    'title'     => 'お見積り',
    'post_type' => 'estimates',
    'context'   => 'normal',
    'priority'  => 'high',
    'sections'  => array(
        array(
            'name'   => 'contents',
            'title'  => 'お見積り',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'kanridantai_name',
                    'type'  => 'text',
                    'title' => '監理団体の名前',
                ),  
                array(
                    'id'    => 'pref',
                    'type'  => 'select',
                    'multiple' => true,
                    'options'  => $inser_array_pref,
                    'title' => '対応エリア',
                ),
                array(
                    'id'    => 'pref_zenkoku',
                    'type'  => 'switcher',
                    'title' => '全国選択しましたか？',
                ),
                array(
                    'id'    => 'kanrihi_25',
                    'type'  => 'switcher',
                    'title' => '監理費2.5万円以下',
                ),
                array(
                    'id'    => 'shokushu',
                    'type'  => 'select',
                    'multiple' => true,
                    'options'  => $inser_array_shokushu,
                    'title' => '職種',
                ),
                array(
                    'id'    => 'kanrihi',
                    'type'  => 'number',
                    'title' => '監理費(送り出し機関管理費含める)',
                ),
                array(
                    'id'    => 'okuridashi_kanrihi',
                    'type'  => 'number',
                    'title' => '送り出し機関管理費',
                ),
                array(
                    'id'    => 'discount_description',
                    'type'  => 'textarea',
                    'title' => '監理費減額の条件',
                ),
                array(
                    'id'    => 'mitsumori_tekiou',
                    'type'  => 'select',
                    'options'  => array(
                        '' => '実例確認なし',
                        'on' => '実例確認あり'
                    ),
                    'title' => '組合の見積もり適応の確認',
                ),
                array(
                    'id'    => 'okuridashi',
                    'type'  => 'select',
                    'options'  => $inser_array_okuridashi,
                    'title' => '送り出し機関',
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
                array(
                    'id'    => 'ichijikin_nyukokugokoushu',
                    'type'  => 'number',
                    'title' => '法定講習費用(入国前講習センター)',
                ),
                array(
                    'id'    => 'ichijikin_nyukokugokoshu',
                    'type'  => 'number',
                    'title' => '法定講習費用(入国後講習センター)',
                ),
                array(
                    'id'    => 'kumiainyukai',
                    'type'  => 'number',
                    'title' => '組合入会金・出資金',
                ),
                array(
                    'id'    => 'kumiaihi',
                    'type'  => 'number',
                    'title' => '組合費/月',
                ),
                array(
                    'id'    => 'tantosha',
                    'type'  => 'text',
                    'title' => '担当者名(見積もりの提供者)',
                ),  
            ),
        ),
    ),
);