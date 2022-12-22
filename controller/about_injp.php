<?php
include get_template_directory().'/array_common.php';
$page_title = 'inJP特定技能について';
$page_description = 'inJP特定技能は制度上の問題点を利用した監理団体の既得権益などをなくし、公平にするために運営しています。監理団体同士が既得権を守り、競争をしないため、価格やサービス、またクローズドな環境で、特定技能への不当な監理が行われてしまいます。inJP技能実習は本来は堅牢な制度の外国人技能実習制度を、自由競争をもってこれらのイシューを改善する第一歩だと考え、ポリシーを持って取り組んでいます。';

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