<?php
$page_title = 'inJP技能実習 運営会社';
$page_description = 'inJP技能実習は合同会社ニッチャーズによって運営されています。';

$array_pankuzu = array(
    array(site_url(),'トップページ'),
    array('none',$page_title),
);

include locate_template('parts/header.php');
include locate_template('parts/navbar.php');

// Contents
echo '<main class="main">';
include locate_template('contents/company.php');
echo '</main>';

include locate_template('parts/footermenu.php');
include locate_template('parts/footer.php');