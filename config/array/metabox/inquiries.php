<?php
// load array
include get_template_directory().'/array_common.php';

// okuridashi
$inser_array_okuridashi = null;
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


$array_metabox_inquiries = array(
    'id'        => 'inquiries',
    'title'     => 'お問合せ',
    'post_type' => 'inquiries',
    'context'   => 'normal',
    'priority'  => 'high',
    'sections'  => array(
        array(
            'name'   => 'contents',
            'title'  => 'お問合せ',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'id',
                    'type'  => 'text',
                    'title' => 'お見積りID',
                ),
                array(
                    'id'    => 'com_name',
                    'type'  => 'text',
                    'title' => '会社名',
                ),
                array(
                    'id'    => 'tel',
                    'type'  => 'text',
                    'title' => '電話番号',
                ),
                array(
                    'id'    => 'email',
                    'type'  => 'text',
                    'title' => 'メールアドレス',
                ),
                array(
                    'id'    => 'tantousha',
                    'type'  => 'text',
                    'title' => '担当者',
                ),
                array(
                    'id'    => 'pref',
                    'type'  => 'select',
                    'multiple' => true,
                    'options'  => $inser_array_pref,
                    'title' => '都道府県',
                ),
                array(
                    'id'    => 'shokushu',
                    'type'  => 'select',
                    'multiple' => true,
                    'options'  => $inser_array_shokushu,
                    'title' => '職種',
                ),
            ),
        ),
    ),
);