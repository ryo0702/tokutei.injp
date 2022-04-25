<?php if (!defined('ABSPATH')) {
    die;
}
if( @$_FILES['importfile']['type'] == 'application/json' and !empty($_FILES['importfile']['tmp_name'])){
    $json = null;
    $json = file_get_contents($_FILES['importfile']['tmp_name']);
    $json = json_decode($json, true);
    update_option( WPOPTIONKEY, $json);

    echo '<div class="wrap">';
    echo '<h2>インポートが完了しました</h2>';
    echo '<p>インポートが完了しました。<a href="'.site_url('/wp-admin/admin.php?page=admin_options').'">こちら</a>からインポートした情報を確認・編集することができます。</p>';
    echo '</div>';
}