<?php
include get_template_directory().'/array_common.php';
if(!empty($_POST['submit'])){
    include get_template_directory().'/controller/estimate_contact_sendemail.php';
}
else{

    $page_title = 'ID'.@esc_attr($_GET['id']).'のお見積り問い合わせ';

    $array_pankuzu = array(
        array(site_url(),'トップページ'),
        array('none',$page_title),
    );

    include locate_template('parts/header.php');
    include locate_template('parts/navbar.php');
    
    // Contents
    echo '<main class="main">';
    include locate_template('contents/estimate_contact.php');
    echo '</main>';
    
    include locate_template('parts/footermenu.php');
    include locate_template('parts/footer.php');
}