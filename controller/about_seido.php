<?php
include get_template_directory().'/array_common.php';
$page_title = '技能実習制度について';
$page_description = '技能実習制度は技能実習および研修を行う目的で日本に在留する外国人のための制度です。このページでは、外国人技能実習生がどのように成り立っているかをご説明いたします。';

$array_pankuzu = array(
    array(site_url(),'トップページ'),
    array('none',$page_title),
);

include locate_template('parts/header.php');
include locate_template('parts/navbar.php');

// Contents
echo '<main class="main">';
include locate_template('contents/about_seido.php');
// include locate_template('parts/cta.php');
echo '</main>';

include locate_template('parts/footermenu.php');
include locate_template('parts/footer.php');