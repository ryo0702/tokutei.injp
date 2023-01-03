<?php
if(!empty($_POST['submit'])){
    $result_url = site_url('/?pagetype=hr_result');
    if(!empty($_POST['visa'])){
        $result_url .= '&visa='.$_POST['visa'];
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

    $result_title_visa = null;
    if(!empty($_GET['visa'])){
        foreach ($array_visa_group as $visa_values) {
            foreach ($visa_values as $visa_value) {
                if($visa_value[0] == $_GET['visa']){
                    $result_title_visa = $visa_value[1];
                    break;
                }
            }
        }
    }
    // PageTitle
    if(!empty($_GET['pref']) and !empty($result_title_visa)){
        $page_title = $_GET['pref'].'対応の'.$result_title_visa.'の人材';
    }
    elseif(!empty($_GET['pref'])){
        $page_title = $_GET['pref'].'のの人材';
    }
    elseif(!empty($result_title_visa)){
        $page_title = $result_title_visa.'のの人材';
    }
    else{
        $page_title = '人材一覧';
    }
    // Page Description
    $page_description = null;
    if(!empty($_GET['pref']) and !empty($result_title_visa)){
        $page_description = $_GET['pref'].'エリアを希望する'.$result_title_visa.'人材の一覧になります。';
    }
    elseif(!empty($_GET['pref'])){
        $page_description = $_GET['pref'].'エリアを希望する人材の一覧になります。';
    }
    elseif(!empty($result_title_visa)){
        $page_description = $result_title_visa.'人材の一覧になります。';
    }
    else{
        $page_description = '現在、掲載されている人材一覧は以下の通りになります。';
    }

    if(!empty($_GET['visa']) or !empty($_GET['pref'])){
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
    if(!empty(@$_GET['visa'])){
        $args['meta_query'][] = array(
            'key' => 'hr',
            'value' => serialize(esc_attr($_GET['visa'])),
            'compare' => 'Like'
        );
        $pagination_url .= '&visa='.$_GET['visa'];
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
            $post_ids2[] = get_the_ID();
        }
        wp_reset_postdata();
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