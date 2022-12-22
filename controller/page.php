<?php
$page_type = $theme_uri = null;
$theme_uri = get_theme_file_uri();

include get_template_directory().'/array_common.php';

include locate_template('parts/header.php');
include locate_template('parts/navbar.php');

// Contents
echo '<main class="main">';
include locate_template('contents/page_content.php');
echo '</main>';

include locate_template('parts/footermenu.php');
include locate_template('parts/footer.php');