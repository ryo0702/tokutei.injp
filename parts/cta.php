<section class="cta section section_blue">
    <div class="container_s">
        <div class="form card card_padding_l">
            <h2 class="title">その場で比較お見積り</h2>
            <p class="subtitle">簡単、すぐにお見積り結果をお届けいたします。<br />当然、外部(海外の送り出し機関)に情報共有いたしませんので、迷惑な営業電話は行っておりません。</p>
            <form id="contact-form" action="" method="post"　enctype="multipart/form-data">
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
                    <button type="submit" name="submit" value="on">簡単お見積り</button>
                </div>
            </form>
        </div>
    </div>
</section>