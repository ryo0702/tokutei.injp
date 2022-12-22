<header class="navbar">
    <div class="container">
        <div class="flexbox_navbar wrap">
            <h1 class="logo flexbox_center">
                <div class="logo_image"><a href="<?php echo site_url(); ?>"><img src="<?php echo $theme_uri.'/dist/images/injp-tokutei.png'; ?>" alt="inJP特定技能"></a></div>
            </h1>
            <nav class="menu flexbox">
                <ul class="flexbox">
                    <?php
                    if ( is_user_logged_in() ) {
                        echo '<li class="spnone"><a href="'.site_url('/wp-admin/').'" class="flexbox_center"><div>管理画面</div></a></li>';
                        if(@$_GET['pagetype'] == 'okuridashi' && !empty(@$_GET['id'])){
                            echo '<li class="spnone"><a href="'.site_url('/wp-admin/post.php?post='.@$_GET['id'].'&action=edit').'" class="flexbox_center"><div>送り出し機関編集</div></a></li>';
                        }
                    }
                    ?>
                </ul>
                <div class="drawermenu_button_area">
                    <div class="drawermenu_button">
                        <span class="line1"></span>
                        <span class="line2"></span>
                        <span class="line3"></span>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>

<div class="drawermenu">
    <div class="inner">
        <div class="logo_image"><a href="<?php echo site_url(); ?>"><img src="<?php echo $theme_uri.'/dist/images/injp-tokutei.png'; ?>" alt="inJP特定技能"></a></div>
        <ul>
            <li><a href="<?php echo site_url(); ?>">ホーム</a></li>
            <li><a href="<?php echo site_url('/?pagetype=estimate_result'); ?>">外国人人材一覧</a></li>
            <li class="smallmenu">技能実習制度について</li>
            <li><a href="<?php echo site_url('/?pagetype=about_seido'); ?>">特定技能外国人について</a></li>
        </ul>
        <div class="drawermenu_close_button">閉じる</div>
    </div>
</div>

<?php
if(is_array(@$array_pankuzu)){
    echo '<div class="pankuzu">';
        echo '<ul class="container">';
            foreach ($array_pankuzu as $pankuzu_data) {
                if($pankuzu_data[0] == 'none'){
                    echo '<li><span>'.$pankuzu_data[1].'</span></li>';
                }
                else{
                    echo '<li><a href="'.$pankuzu_data[0].'">'.$pankuzu_data[1].'</a></li>';
                }
                
            }
        echo '</ul>';
    echo '</div>';
}
?>