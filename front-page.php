<?php
$page_type = $theme_uri = null;
$theme_uri = get_theme_file_uri();

if(empty($_GET['pagetype'])){
    include locate_template('controller/toppage.php');
}
elseif($_GET['pagetype'] == 'hr_result'){
    include locate_template('controller/hr_result.php');
}
elseif($_GET['pagetype'] == 'hr_contact' and is_numeric(@$_GET['id'])){
    include locate_template('controller/hr_contact.php');
}
elseif($_GET['pagetype'] == 'about_injp'){
    include locate_template('controller/about_injp.php');
}
elseif($_GET['pagetype'] == 'about_seido'){
    include locate_template('controller/about_seido.php');
}
elseif($_GET['pagetype'] == 'about_kanridantai'){
    include locate_template('controller/about_kanridantai.php');
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