<?php if (!defined('ABSPATH')) {
    die;
}
$data_themeoption = null;
$data_themeoption = get_option(WPOPTIONKEY);

// Create dir
if(!file_exists(get_template_directory()."/export_theme_setupfile")){
    mkdir(get_template_directory()."/export_theme_setupfile", 0777);
}
// Create json
$data_themeoption = json_encode($data_themeoption);
file_put_contents(get_template_directory()."/export_theme_setupfile/themefile.json" , $data_themeoption);
// Zip
$zip = new ZipArchive;
$zip->open(get_template_directory().'/export_theme_setupfile/themefile.zip', ZipArchive::CREATE|ZipArchive::OVERWRITE);
$zip->addFile(get_template_directory().'/export_theme_setupfile/themefile.json','themefile.json');
$zip->close();
// Json file delete
unlink(get_template_directory()."/export_theme_setupfile/themefile.json");

echo '<div class="wrap">';
echo '<h2>エクスポート成功</h2>';
echo '<p>テーマファイルのエクスポートが完了しました。以下のファイルをダウンロードして、jsonファイルを<a href="'.site_url('/wp-admin/admin.php?page=themeexport').'">インポート</a>してください。</p>';

echo '<div><a href="'.get_theme_file_uri('/export_theme_setupfile/themefile.zip').' "class="button button-primary">ダウンロード</a></div>';

echo '</div>';