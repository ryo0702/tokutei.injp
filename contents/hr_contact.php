<div class="result_contact">
    <div class="container_s">
        <?php
        $estdata = null;
        $estdata = get_post_meta( esc_attr($_GET['id']), 'estimates', true );
        // Title
        if(!empty($estdata['name_pub'])){
            $this_title = '氏名非公開';
        }
        elseif(empty($estdata['name_katakana'])){
            $this_title = '氏名非公開';
        }
        else{
            $this_title = $estdata['name_katakana'];
        }
        // Title
        echo '<div class="result_title"><h1>人材ID '.@esc_attr($_GET['id']).' / '.$this_title.'の面接問い合わせ</h1></div>';
        ?>
        <div class="card card_padding_l">
            <form id="contact-form" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo @esc_attr($_GET['id']); ?>" />
                <ul class="form_list">
                    <li>
                        <h3>面接のお問い合わせ</h3>
                        <p class="description">この人材への面接のお問合せされる方は以下のフォームより必要事項をご記載いただいて「お問合せを送信」ボタンを押して送信してください。<br>また、お見積もり後の流れは以下の通りです。</p>
                        <div class="form_flow">
                            <ul>
                                <li>
                                    <h3>フォームを送信</h3>
                                    <p>入力項目をご入力いただき、フォームを送信してください。</p>
                                    <div class="number">1</div>
                                </li>
                                <li>
                                    <h3>人材との面接予定日を調整</h3>
                                    <p>担当者(登録支援機関等)から人材との面接予定日を調整します。</p>
                                    <div class="number">2</div>
                                </li>
                                <li>
                                    <h3>面接</h3>
                                    <p>現地面接もしくはスカイプ等オンライン面接を行います。</p>
                                    <div class="number">3</div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <label for="pref">都道府県<span class="req">必須</span></label>
                        <select name="pref" id="pref" class="form-control" required>
                            <option value="">都道府県を選択</option>
                            <?php
                            foreach ($array_pref_group as $group_title => $group_opt) {
                                echo '<optgroup label="'.$group_title.'">';
                                    foreach ($group_opt as $opt_value) {
                                        $selected = null;
                                        if(!empty($_GET['pref']) and $_GET['pref'] == $opt_value){
                                            $selected = ' selected';
                                        }
                                        echo '<option value="'.$opt_value.'"'.$selected.'>'.$opt_value.'</option>';
                                    }
                                echo '</optgroup>';
                            }
                            ?>
                        </select>
                    </li>
                    <li>
                        <label for="com_name">会社名<span class="req">必須</span></label>
                        <div><input type="text" name="com_name" value="" required /></div>
                    </li>
                    <li>
                        <label for="tel">お電話番号<span class="req">必須</span></label>
                        <div><input type="text" name="tel" value="" required /></div>
                    </li>
                    <li>
                        <label for="email">メールアドレス<span class="req">必須</span></label>
                        <div><input type="text" name="email" value="" required /></div>
                    </li>
                    <li>
                        <label for="tantousha">担当者様のお名前<span class="req">必須</span></label>
                        <div><input type="text" name="tantousha" value="" required /></div>
                    </li>
                    <li>
                        <label for="tokutei_subject">お問合せ内容<span class="req">必須</span></label>
                        <select name="tokutei_subject" id="tokutei_subject" class="form-control" required>
                            <option value="面接依頼">面接依頼</option>
                            <option value="この人材に関する詳細希望">この人材に関する詳細希望</option>
                            <option value="その他ご相談">その他ご相談</option>
                        </select>
                    </li>
                    <li>
                        <label for="mendan_kibo_type">面談方法<span class="req">必須</span></label>
                        <select name="mendan_kibo_type" id="mendan_kibo_type" class="form-control" required>
                            <option value="オンライン面談(Zoom)" checked>オンライン面談(Zoom)</option>
                            <option value="オンライン面談(Line)">オンライン面談(Line)</option>
                            <option value="オンライン面談(その他)">オンライン面談(その他)</option>
                            <option value="お電話">お電話</option>
                            <option value="直接打ち合わせ">直接打ち合わせ</option>
                        </select>
                    </li>
                    <li>
                        <label for="mendan_kibo_nichiji_1">面談ご希望日(第一希望)<span class="req">必須</span></label>
                        <div><input type="date" name="mendan_kibo_nichiji_1" value="" required /></div>
                    </li>
                    <li>
                        <label for="mendan_kibo_jikan_1">面談ご希望時間(第一希望)<span class="req">必須</span></label>
                        <div><input type="time" name="mendan_kibo_jikan_1" value="" required /></div>
                    </li>
                    <li>
                        <label for="mendan_kibo_nichiji_2">面談ご希望日(第二希望日)</label>
                        <div><input type="date" name="mendan_kibo_nichiji_2" value="" /></div>
                    </li>
                    <li>
                        <label for="mendan_kibo_jikan_2">面談ご希望時間(第二希望)</label>
                        <div><input type="time" name="mendan_kibo_jikan_2" value="" /></div>
                    </li>
                    <li>
                        <label for="mendan_kibo_nichiji_3">面談ご希望日(第三希望日)</label>
                        <div><input type="date" name="mendan_kibo_nichiji_3" value="" /></div>
                    </li>
                    <li>
                        <label for="mendan_kibo_jikan_3">面談ご希望時間(第三希望)</label>
                        <div><input type="time" name="mendan_kibo_jikan_3" value="" /></div>
                    </li>
                </ul>
                <div class="rule"><label><input type="checkbox" name="check" value="check" required /> <a href="<?php echo site_url('/?pagetype=rule'); ?>" target="_blank">利用規約</a>に同意してフォームを送信する</label></div>
                <div class="area_button submit"><button type="submit" name="submit" value="sending">お問合せを送信</button></div>
            </form>
        </div>
    </div>
</div>