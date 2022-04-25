<div class="result_contact">
    <div class="container_s">
        <?php
        $estdata = null;
        $estdata = get_post_meta( $_GET['id'], 'estimates', true );
        // Title
        if(!empty($estdata['kanridantai_name'])){
            $this_title = $estdata['kanridantai_name'];
        }
        else{
            $this_title = '監理団体名未公開';
        }
        // Title
        echo '<div class="result_title"><h1>お見積りID '.@$_GET['id'].' / '.$this_title.'のお見積り問い合わせ</h1></div>';
        ?>
        <div class="card card_padding_l">
            <form id="contact-form" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo @$_GET['id']; ?>" />
                <ul class="form_list">
                    <li>
                        <p class="description">このお見積り内容でお問合せされる方は以下のフォームより必要事項をご記載いただいて「お問合せを送信」ボタンを押して送信してください。<br>また、お見積もり後の流れは以下の通りです。</p>
                        <div class="form_flow">
                            <ul>
                                <li>
                                    <h3>フォームを送信</h3>
                                    <p>入力項目をご入力いただき、フォームを送信してください。</p>
                                    <div class="number">1</div>
                                </li>
                                <li>
                                    <h3>該当の組合からご連絡</h3>
                                    <p>担当の組合もしくは送り出し機関を経由して該当組合からのみご連絡を致します。お問合せと違うお見積り結果とならないようにしておりますが、万が一かけ離れたお見積り結果の場合はinJPまでご連絡ください。</p>
                                    <div class="number">2</div>
                                </li>
                                <li>
                                    <h3>お見積り内容に同意</h3>
                                    <p>改めて、詳細の入ったお見積り内容や訪問して説明を受けていただき、同意される場合は、求人票を記載の上、面接へ進みます。</p>
                                    <div class="number">3</div>
                                </li>
                                <li>
                                    <h3>面接</h3>
                                    <p>現地面接もしくはスカイプ面接を行います。採用者が決まれば、組合への加入手続き及び、雇用条件書・雇用契約書の作成、実習計画の作成に入ります。</p>
                                    <div class="number">4</div>
                                </li>
                                <li>
                                    <h3>入国・配属</h3>
                                    <p>在留許可が出たらいよいよ日本に入国です。法定講習(おおよそ1ヶ月)後、企業さんに配属になります。</p>
                                    <div class="number">5</div>
                                </li>
                            </ul>
                        </div>
                        <?php
                        $estimatedata = null;
                        $estimatedata = get_post_meta(@$_GET['id'], 'estimates', true );
                        if(!empty($estimatedata['kanridantai_name'])){
                            echo '<input type="hidden" name="kanridantai_name" value="'.$estimatedata['kanridantai_name'].'" />';
                        }
                        else{
                            echo '<p>見積もりID：'.@$_GET['id'].' / 監理団体名非公開</p>';
                            echo '<input type="hidden" name="kanridantai_name" value="監理団体名非公開" />';
                        }
                        if(!empty($estimatedata['kanrihi'])){
                            echo '<input type="hidden" name="kanrihi" value="'.$estimatedata['kanrihi'].'" />';
                        }
                        if(!empty($estimatedata['discount_description'])){
                            echo '<input type="hidden" name="discount_description" value="'.$estimatedata['discount_description'].'" />';
                        }
                        if(!empty($estimatedata['okuridashi'])){
                            echo '<input type="hidden" name="okuridashi" value="'.$estimatedata['okuridashi'].'" />';
                        }
                        ?>
                    </li>
                    <li>
                        <label for="shokushu">職種<span class="req">必須</span></label>
                        <select name="shokushu" id="shokushu" class="form-control" required>
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
                    </li>
                    <li>
                        <label for="pref">都道府県<span class="req">必須</span></label>
                        <select name="pref" id="pref" class="form-control" required>
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
                        <label for="jissusei_koyou">技能実習生の雇用経験<span class="req">必須</span></label>
                        <select name="jissusei_koyou" id="jissusei_koyou" class="form-control" required>
                            <option value="あり">あり</option>
                            <option value="なし">なし</option>
                        </select>
                    </li>
                    <li>
                        <label for="jissusei_subject">お問合せ内容<span class="req">必須</span></label>
                        <select name="jissusei_subject" id="jissusei_subject" class="form-control" required>
                            <option value="新規実習生受け入れ">新規実習生受け入れ</option>
                            <option value="受け入れ中の実習生の監理団体変更">受け入れ中の実習生の監理団体変更</option>
                            <option value="新規受け入れと監理団体の変更">新規受け入れと監理団体の変更</option>
                            <option value="その他ご相談">その他ご相談</option>
                        </select>
                    </li>
                </ul>
                <div class="rule"><label><input type="checkbox" name="check" value="check" required /> <a href="<?php echo site_url('/?pagetype=rule'); ?>" target="_blank">利用規約</a>に同意してフォームを送信する</label></div>
                <div class="area_button submit"><button type="submit" name="submit" value="sending">お問合せを送信</button></div>
            </form>
        </div>
    </div>
</div>