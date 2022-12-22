<?php
$page_title = 'inJP技能実習 ご利用規約';
$page_description = 'inJP技能実習のご利用規約について。';

$array_pankuzu = array(
    array(site_url(),'トップページ'),
    array('none',$page_title),
);

include get_template_directory().'/array_common.php';

include locate_template('parts/header.php');
include locate_template('parts/navbar.php');

// Contents
echo '<main class="main">';
include locate_template('contents/rule.php');
echo '</main>';

include locate_template('parts/footermenu.php');
include locate_template('parts/footer.php');