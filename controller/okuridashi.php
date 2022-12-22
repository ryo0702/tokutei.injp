<?php
$page_title = $page_title_in = $okuridashidata = $page_description = $nation = null;
$okuridashidata = get_post_meta( esc_attr($_GET['id']), 'okuridashi', true );

if(!empty(get_the_title(esc_attr(@$_GET['id'])))){
    $page_title = '技能実習生送り出し機関 - '.get_the_title(esc_attr(@$_GET['id']));
    $page_title_in = get_the_title(esc_attr(@$_GET['id']));
}
if(!empty($okuridashidata['contents_description'])){
    $page_description = $okuridashidata['contents_description'];
}

$array_pankuzu = array(
    array(site_url(),'トップページ'),
    array('none',$page_title),
);

include get_template_directory().'/array_common.php';
include locate_template('parts/header.php');
include locate_template('parts/navbar.php');

// Contents
echo '<main class="main">';
include locate_template('contents/okuridashi.php');
echo '</main>';

include locate_template('parts/footermenu.php');
include locate_template('parts/footer.php');