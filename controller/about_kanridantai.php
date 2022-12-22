<?php
include get_template_directory().'/array_common.php';
$page_title = '監理団体の選び方';
$page_description = '監理団体(組合)選びは「近くにあるから」「友達の社長の紹介だから」という理由ではなく、自社に合った監理団体を選びましょう。';

$array_pankuzu = array(
    array(site_url(),'トップページ'),
    array('none',$page_title),
);

include locate_template('parts/header.php');
include locate_template('parts/navbar.php');

// Contents
echo '<main class="main">';
include locate_template('contents/about_kanridantai.php');
// include locate_template('parts/cta.php');
echo '</main>';

include locate_template('parts/footermenu.php');
include locate_template('parts/footer.php');