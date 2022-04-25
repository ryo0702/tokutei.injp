<?php
$page_type = $theme_uri = null;
$theme_uri = get_theme_file_uri();

if(empty($_GET['pagetype'])){
    include locate_template('controller/toppage.php');
}
elseif($_GET['pagetype'] == 'estimate_result'){
    include locate_template('controller/estimate_result.php');
}
elseif($_GET['pagetype'] == 'estimate_contact' and is_numeric(@$_GET['id'])){
    include locate_template('controller/estimate_contact.php');
}
elseif($_GET['pagetype'] == 'thankyou'){
    include locate_template('controller/thankyou.php');
}
elseif($_GET['pagetype'] == 'company'){
    include locate_template('controller/company.php');
}
elseif($_GET['pagetype'] == 'rule'){
    include locate_template('controller/rule.php');
}
elseif($_GET['pagetype'] == 'xmlsitemap'){
    include locate_template('controller/xmlsitemap.php');
}