<header class="navbar">
    <div class="container">
        <div class="flexbox_navbar wrap">
            <h1 class="logo flexbox_center">
                <div class="logo_image"><a href="<?php echo site_url(); ?>"><img src="<?php echo $theme_uri.'/dist/images/logo.png'; ?>" alt=""></a></div>
            </h1>
            <nav class="menu flexbox">
                <ul class="flexbox">
                    <li><a href="<?php echo site_url('/?pagetype=estimate_result'); ?>" class="flexbox_center"><div>お見積り一覧</div></a></li>
                    <?php
                    if ( is_user_logged_in() ) {
                        echo '<li class="spnone"><a href="'.site_url('/wp-admin/').'" class="flexbox_center"><div>管理画面</div></a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
</header>