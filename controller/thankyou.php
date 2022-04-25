<?php
$page_title = 'お問合せありがとうございました';
$page_description = 'inJP技能実習へのお問合せ誠にありがとうございました。';

include locate_template('parts/header.php');
include locate_template('parts/navbar.php');

// Contents
echo '<main class="main">';
include locate_template('contents/thankyou.php');
echo '</main>';

include locate_template('parts/footermenu.php');
include locate_template('parts/footer.php');