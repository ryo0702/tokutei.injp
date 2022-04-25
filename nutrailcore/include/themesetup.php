<?php
add_action('admin_menu', 'add_themesetup');
function add_themesetup(){
    add_submenu_page('admin_options', 'テーマセットアップ', 'テーマセットアップ', 'manage_options', 'themesetup', 'add_themesetup_page', 2);
    add_submenu_page('admin_options', 'テーマエクスポート', 'テーマエクスポート', 'manage_options', 'themeexport', 'add_themeexport_page', 3);
    add_submenu_page('admin_options', 'テーマインポート', 'テーマインポート', 'manage_options', 'themeimport', 'add_themeimport_page', 4);
}

function add_themesetup_page(){
    $array_adminform = null;
    // Load Option
    require locate_template('/config/array/options.php');
    require locate_template('/config/array/setups.php');
    $array_adminform = array(
        array('title' => 'カラー','name' => 'setup_color','type' => 'select','description' => 'カラーセットアップする項目を選択してください','select_novalue' => true,'associative' => true,'options' => $array_select_color),
        array('type' => 'hr'),
        array('title' => 'トップページ作成','name' => 'create_toppage','type' => 'select','description' => 'トップページ(LP)は新規作成されます(選択しなければ作成されません)。','select_novalue' => true,'associative' => true,'lp' => true,'options' => $array_select_lp),
        array('title' => 'トップページに設定','label' => 'トップページに設定','name' => 'setting_toppage','type' => 'check_single','description' => 'チェックすると作成したページをトップページに割り当てます。'),
    );
    if(!empty($_POST['submit'])){
        require_once NUTRAIL_CORE_PATH.'include/themesetup/themesetup-action.php';
    }
    else{
        require_once NUTRAIL_CORE_PATH.'include/themesetup/themesetup-form.php';
    }
}

function add_themeexport_page(){
    $array_adminform = null;
    if(!empty($_POST['submit'])){
        require_once NUTRAIL_CORE_PATH.'include/themesetup/themeexport-action.php';
    }
    else{
        require_once NUTRAIL_CORE_PATH.'include/themesetup/themeexport-form.php';
    }
}

function add_themeimport_page(){
    $array_adminform = null;
    $array_adminform = array(
        array('title' => 'インポートファイル','name' => 'importfile','type' => 'file','description' => 'インポート用のファイル(json形式)を追加してください'),
    );
    if(!empty($_POST['submit'])){
        require_once NUTRAIL_CORE_PATH.'include/themesetup/themeimport-action.php';
    }
    else{
        require_once NUTRAIL_CORE_PATH.'include/themesetup/themeimport-form.php';
    }
}