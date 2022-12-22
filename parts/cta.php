<section class="cta section section_blue">
    <div class="container_s">
        <div class="form card card_padding_l">
            <h2 class="title">その場でマッチング</h2>
            <p class="subtitle">登録なしで特定技能外国人とのマッチングが簡単に行えます。<br />しかも、紹介料は0円です。</p>
            <form id="contact-form" action="<?php echo site_url('/?pagetype=estimate_result'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="wpnonce" value="<?php echo wp_create_nonce( get_bloginfo('name').'nonce_'.date('Ymd') ); ?>" />
                <div class="form_wrap">
                    <div class="form1">
                        <select name="shokushu" id="shokushu" class="form-control">
                            <option value="">職種を選択</option>
                            <?php
                            foreach ($array_shokushu_group as $group_title => $group_opt) {
                                echo '<optgroup label="'.$group_title.'">';
                                    foreach ($group_opt as $opt_value) {
                                        echo '<option value="'.$opt_value[0].'">'.$opt_value[1].'</option>';
                                    }
                                echo '</optgroup>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form2">
                        <select name="pref" id="pref" class="form-control">
                            <option value="">都道府県を選択</option>
                            <?php
                            foreach ($array_pref_group as $group_title => $group_opt) {
                                echo '<optgroup label="'.$group_title.'">';
                                    foreach ($group_opt as $opt_value) {
                                        echo '<option value="'.$opt_value.'">'.$opt_value.'</option>';
                                    }
                                echo '</optgroup>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="submit">
                    <button type="submit" name="submit" value="sending">その場で簡単マッチング</button>
                </div>
            </form>
        </div>
    </div>
</section>