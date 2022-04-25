<?php
include get_template_directory().'/array_common.php';
if(!empty($_POST['submit'])){
    $insert_url = null;
    if($_POST['shokushu']){
        $insert_url .= '&shokushu='.$_POST['shokushu'];
    }
    if($_POST['pref']){
        $insert_url .= '&pref='.$_POST['pref'];
    }
    wp_redirect( site_url('/?pagetype=estimate_result'.$insert_url) );
    exit;
}
else{
    include locate_template('parts/header.php');
    include locate_template('parts/navbar.php');

    // Contents
    echo '<main class="main">';
    include locate_template('contents/toppage_contents.php');
    include locate_template('parts/cta.php');
    echo '</main>';

    include locate_template('parts/footermenu.php');
    include locate_template('parts/footer.php');   
}