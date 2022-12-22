<?php if (!defined('ABSPATH')) {
    die;
}

$message = null;

if(!empty($_POST['setup_color']) and !empty($array_colors[$_POST['setup_color']])){
    $data_themeoption = null;
    $data_themeoption = get_option(WPOPTIONKEY);
    $data_themeoption['config-common']['colors'] = $array_colors[$_POST['setup_color']];
    update_option( WPOPTIONKEY, $data_themeoption);
    $message .= '<p>カラーの設定が行われました。<a href="'.site_url('/wp-admin/admin.php?page=admin_options').'">こちら</a>からセットアップした情報を確認・編集することができます。</p>';
}

if(!empty($_POST['create_toppage']) and !empty($array_lp[$_POST['create_toppage']])){
    $postid = null;
    $array_post = array(
        'page_template' => 'templates/template-lp.php',
        'post_title' => 'トップページ',
        'post_status' => 'publish',
        'post_type' => 'page'
    );
    $postid = wp_insert_post( $array_post );
    $array_lp[$_POST['create_toppage']];
    if(!empty($postid) and is_numeric(@$postid)){
        update_post_meta($postid, 'page-lp', $array_lp[$_POST['create_toppage']]);
    }
    $message .= '<p>新しいトップページが設定されました。<a href="'.get_the_permalink( $postid ).'">'.get_the_title($postid).'を確認</a> / <a href="'.site_url('/wp-admin/post.php?post='.$postid.'&action=edit').'">'.get_the_title($postid).'を確認</a>。</p>';
    if(!empty($_POST['setting_toppage'])){
        update_option( 'page_on_front', $postid);
    }
}

if(!empty($message)){
    echo '<div class="wrap">';
    echo '<h2>セットアップが完了しました</h2>';
    echo $message;
    echo '</div>';
}
else{
    echo '<div class="wrap">';
    echo '<h2>セットアップは行われませんでした</h2>';
    echo '<p>有効な設定がなかったため、セットアップは行われませんでした。<a href="'.site_url('/wp-admin/admin.php?page=themesetup').'">セットアップ</a>に戻り、もう一度項目選択をしてセットアップを実行してください。</p>';
    echo '</div>';
}