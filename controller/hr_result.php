<?php
if(!empty($_POST['submit'])){
    $result_url = site_url('/?pagetype=hr_result');
    if(!empty($_POST['shokushu'])){
        $result_url .= '&shokushu='.$_POST['shokushu'];
    }
    if(!empty($_POST['pref'])){
        $result_url .= '&pref='.$_POST['pref'];
    }
    wp_redirect( $result_url );exit;
}
else{
    // Config
    $page_title = null;
    include get_template_directory().'/array_common.php';

    $result_title_shokushu = null;
    if(!empty($_GET['shokushu'])){
        foreach ($array_shokushu_group as $shokushu_values) {
            foreach ($shokushu_values as $shokushu_value) {
                if($shokushu_value[0] == $_GET['shokushu']){
                    $result_title_shokushu = $shokushu_value[1];
                    break;
                }
            }
        }
    }
    // PageTitle
    if(!empty($_GET['pref']) and !empty($result_title_shokushu)){
        $page_title = $_GET['pref'].'対応の'.$result_title_shokushu.'の外国人人材';
    }
    elseif(!empty($_GET['pref'])){
        $page_title = $_GET['pref'].'のの外国人人材';
    }
    elseif(!empty($result_title_shokushu)){
        $page_title = $result_title_shokushu.'のの外国人人材';
    }
    else{
        $page_title = '特定技能可能な外国人人材一覧';
    }
    // Page Description
    $page_description = null;
    if(!empty($_GET['pref']) and !empty($result_title_shokushu)){
        $page_description = $_GET['pref'].'エリアに対応した職種「'.$result_title_shokushu.'」外国人技能実習生監理団体のお見積り(非公開お見積りもあり)。'.$_GET['pref'].'で外国人技能実習生を雇用するならやはり監理費は安くしておきたい...しかし、なかなか料金を公開している組合がなく、しかも地域や職種も限定的で探せないとお悩みの企業様のための、非公開お見積りも含めた監理団体のお見積り一括比較システムです。';
    }
    elseif(!empty($_GET['pref'])){
        $page_description = $_GET['pref'].'で外国人技能実習生を雇用をお考えならばやはり安い監理費の監理団体が良いとお考えの企業様に、最適な組合をご紹介する非公開お見積りを含めた監理団体お見積り比較システムです。';
    }
    elseif(!empty($result_title_shokushu)){
        $page_description = $result_title_shokushu.'に対応した組合でかつ、監理費も安い組合を探すのは至難の業。技能実習生を雇用するなら、inJP技能実習で監理団体のお見積りを一括比較。安い監理団体への乗り換えも可能。';
    }
    else{
        $page_description = '外国人技能実習生を雇用するなら、当然ながら安い監理費の監理団体で実習を行いたい。inJP技能実習生では、地域ごと、職種ごとに監理費の安い監理団体を一括比較しています。25,000円以下保証ありで、どこの地域で見積もりを比較しても25,000円以下のお見積りが取れます。';
    }

    if(!empty($_GET['shokushu']) or !empty($_GET['pref'])){
        $array_pankuzu = array(
            array(site_url(),'トップページ'),
            array(site_url('/?pagetype=hr_result'),'お見積り一覧'),
            array('none',$page_title),
        );
    }
    else{
        $array_pankuzu = array(
            array(site_url(),'トップページ'),
            array('none',$page_title),
        );
    }

    // Result query
    $post_ids = $post_ids2 = $pagination_url = null;
    $args = array(
        'post_type' => 'hr',
        'posts_per_page' => -1,
    );
    $pagination_url = site_url('/?pagetype=hr_result');
    if(!empty(@$_GET['pref'])){
        $args['meta_query'][] = array(
            'key' => 'hr',
            'value' => serialize(esc_attr($_GET['pref'])),
            'compare' => 'Like'
        );
        $pagination_url .= '&pref='.$_GET['pref'];
    }
    if(!empty(@$_GET['shokushu'])){
        $args['meta_query'][] = array(
            'key' => 'hr',
            'value' => serialize(esc_attr($_GET['shokushu'])),
            'compare' => 'Like'
        );
        $pagination_url .= '&shokushu='.$_GET['shokushu'];
    }
    if(!empty(@$_GET['paged'])){
        $paged = @$_GET['paged'];
    }
    else{
        $paged = 0;
    }

    $the_query1 = new WP_Query( $args );
    if ( $the_query1->have_posts() ) {
        while ( $the_query1->have_posts() ) {
            $the_query1->the_post();
            $estdata = null;
            $estdata = get_post_meta( get_the_ID(), 'hr', true );
            if(!empty($estdata['kanrihi']) and is_numeric($estdata['kanrihi'])){
                $post_ids[get_the_ID()] = esc_attr($estdata['kanrihi']);
            }
        }
        wp_reset_postdata();
    }

    if(!empty($post_ids)){
        asort($post_ids);
        foreach ($post_ids as $key => $value) {
            $post_ids2[] = $key;
        }
    }

    include locate_template('parts/header.php');
    include locate_template('parts/navbar.php');

    // Contents
    echo '<main class="main">';
    include locate_template('contents/hr_result.php');
    echo '</main>';

    include locate_template('parts/footermenu.php');
    include locate_template('parts/footer.php');
}