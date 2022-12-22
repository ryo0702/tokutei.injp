<section class="mainvisual toppage_mainvisual">
    <div class="container mainvisual_content form">
        <form id="contact-form" action="<?php echo site_url('/?pagetype=hr_result'); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="wpnonce" value="<?php echo wp_create_nonce( get_bloginfo('name').'nonce_'.date('Ymd') ); ?>" />
            <div class="card">
                <h2>特定技能外国人<br />紹介料0円 直接採用</h2>
                <p>特定技能外国人の採用が、なんと、<strong>紹介料0円でマッチング</strong>可能！採用が決まれば、そのままワンストップで手続き開始。</p>
                <div class="form_wrap">
                    <div class="form1">
                        <select name="shokushu" id="shokushu" class="form-control">
                            <option value="">在留資格を選択</option>
                            <?php
                            foreach ($array_zairyushikaku as $opt_value) {
                                echo '<option value="'.$opt_value.'">'.$opt_value.'</option>';
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
                <div class="area_button submit"><button type="submit" name="submit" value="sending"><span class="line1">今すぐ簡単</span><span class="line2">マッチング</span></button></div>
                <p class="form-message"></p>
            </div>
            <div class="balloon">
                <div class="line1">紹介料</div>
                <div class="line2">0<span>円</span></div>
                <div class="line3">保証</div>
            </div>
            <div class="card_shadow"></div>
        </form>
    </div>
    <div class="bgi" style="background-image:url('<?php echo $theme_uri.'/dist/images/bgi_mainvisual.jpg'; ?>');"></div>
    <div class="bgc"></div>
</section>

<section class="toppage_problem section">
    <div class="titleset">
        <div class="container">
            <h2 class="title">特定技能の雇用で<br />こんなお悩みはありませんか？</h2>
            <p class="lead container_xs">特定技能外国人を導入されている企業様や、初めて制度を導入される企業様から、以下のようなお悩みをよくお聞きします。</p>
        </div>
    </div>
    <div class="container_s">
        <div class="problems card card_padding_l">
            <ul>
                <li><span>はじめて</span>で、制度についてよくわからない</li>
                <li>紹介料が<span>高い</span>ので、雇用できない</li>
                <li>雇用する人材なので<span>選びたい</span></li>
                <li>ちゃんと自社に<span>マッチする</span>人材が欲しい</li>
            </ul>
        </div>
    </div>
</section>

<section class="toppage_overview section section_bgc_grey">
    <div class="titleset">
        <div class="container">
            <h2 class="title">inJP特定技能なら<br />紹介費用は無料</h2>
            <p class="lead container_xs">inJP技能実習生なら紹介費は無料です。なぜ紹介費無料でできるかというと、多くは技能実習生として日本に来ており、その後も日本で働きたい実習生を監理する監理団体が、元技能実習生の雇用先を確保するために、inJP技能実習に参加しているからです。</p>
        </div>
    </div>
    <div class="container_s">
        <div class="card card_padding_l card_blue">
            <h3 class="card_title">紹介費0円の登録支援機関が対応</h3>
            <p></h2>
            <p class="lead container_xs">inJP技能実習生なら紹介費は無料です。なぜ紹介費無料でできるかというと、多くは技能実習生として日本に来ており、その後も日本で働きたい実習生を監理する監理団体が、元技能実習生の雇用先を確保するために、inJP技能実習に参加しているからです。</p>
        </div>
        <div class="card card_padding_l card_blue margin_top_m">
            <h3 class="card_title">外国人人材を選んで雇用</h3>
            <p>ほとんどの登録支援機関では、マッチする人材を探してから、1名づつ面接をするため、選べないのが現状です。inJP特定技能では、人材のデータベースを無料公開しています(プライバシー配慮の上)。そのため、事前にどのような人が集まっているか、誰と面接できるかを予め把握することができます。</p>
        </div>
    </div>
</section>

<section class="toppage_customersvoice section section_bgi" style="background-image:url('<?php echo $theme_uri.'/dist/images/bgi_blue_grd.png'; ?>');">
    <div class="titleset">
        <div class="container">
            <h2 class="title">当サービスご利用の<br />お客様のお声</h2>
            <p class="lead container_xs">当サービスをご利用になり、特定技能外国人を雇用した企業様や監理団体様にインタビューして、ご感想などをお聞きしています。</p>
        </div>
    </div>
    <div class="container">
        <div class="column_3">
            <div class="c_content card">
                <h3>特定技能の紹介料ゼロは正直助かる</h3>
                <p class="text_s">愛知県 建設 K社長</p>
                <p>仕事が忙しく技能実習生だけではなく、特定技能の採用も行いたいと思っていたが、営業に来る業者はほとんど紹介料1名50万円など、本当に高い。そんな中、inJP特定技能なら、紹介料0円なのは本当に助かった。2名の採用ができました。</p>
            </div>
            <div class="c_content card">
                <h3>彼らの「日本での将来」を繋ぐことができた</h3>
                <p class="text_s">愛知県 監理団体 Y理事長</p>
                <p>3年間真面目に頑張ってきた技能実習と特定技能の要件が合わず、同じ会社で特定技能になれなかった彼らを、別の会社でも良いので、なんとかして欲しいという企業さんの想いを、inJP特定技能を使い繋ぐことができました。</p>
            </div>
            <div class="c_content card">
                <h3>本当に「建設業がしたい」特定技能が見つかった</h3>
                <p class="text_s">山口県 建設業/土木 A社長</p>
                <p>前に雇用した際は、とにかく人が足りない状況だったので、未経験者を雇用しました。しかし、特定技能になる前に別の職種に転職してしまいました。今回見つかった特定技能外国人は、前の会社の指導が良かったのか、建設業で働くことに誇りを持っているように見えます。</p>
            </div>
            <div class="c_conetnt_blank"></div>
            <div class="c_conetnt_blank"></div>
        </div>
    </div>
</section>

<section class="toppage_overview section section_bgc_grey">
    <div class="titleset">
        <div class="container">
            <h2 class="title">サービスの流れ</h2>
            <p class="lead container_xs">inJPを利用して、技能実習生を採用・監理団体を変更していただく流れをご紹介します。とても簡単なので、どなたでもすぐに希望の監理団体に連絡ができます。</p>
        </div>
    </div>
    <div class="container_s">
        <div class="card card_padding_l card_blue">
            <h3 class="card_title">1.お見積りをする</h3>
            <p>まずはエリアの選択・職種の選択をしてお見積り検索をしてください。該当するお見積りがその場で表示されます。この際、お見積りした監理団体から一斉に連絡が入るなどということはありませんのでご安心ください。</p>
        </div>
        <div class="card card_padding_l card_blue margin_top_m">
            <h3 class="card_title">2.お問合せ・ご相談</h3>
            <p>良さそうな見積もり内容をもとにinJPにお問合せください。inJPから直接もしくは送り出し機関を通じて監理団体をご紹介します。</p>
        </div>
        <div class="card card_padding_l card_blue margin_top_m">
            <h3 class="card_title">3.新規受け入れ・監理団体変更</h3>
            <p>お問合せした組合でよかった場合、新規受け入れもしくは監理団体の変更を行なってください。inJP技能実習は企業様から費用は一切いただいておりませんので、ご安心ください。</p>
        </div>
    </div>
</section>

<section class="toppage_overview section section_bgc_grey">
    <div class="titleset">
        <div class="container">
            <h2 class="title">外国人人材一覧</h2>
            <p class="lead container_xs">特定技能として在留資格が取れる外国人のみを掲載しています。また、本人の了承の上、プライバシーに配慮して個人情報が特定されないように配慮して掲載を行っています。</p>
        </div>
    </div>
    <div class="result_top">
        <div class="container">
        <?php
        $args2 = array(
            'post_type' => 'hr',
            'posts_per_page' => 6,
            'orderby' => 'post__in',
            'order'   => 'ASC',
        );
        $args2['meta_query'][] = array(
            'key' => 'hr',
            'value' => serialize('viewtoppage_on'),
            'compare' => 'Like'
        );
        $the_query2 = new WP_Query( $args2 );
        $count = 1;
        if ( $the_query2->have_posts() ) {
            echo '<ul class="list">';
            while ( $the_query2->have_posts() ) {
                $the_query2->the_post();
                include get_template_directory().'/parts/hr_result_loop.php';
            }
            echo '</ul>';
            wp_reset_postdata();
        }
        ?>
        </div>
    </div>
</section>
<section class="toppage_news section">
    <div class="titleset">
        <div class="container">
            <h2 class="title">新着情報</h2>
            <p class="lead container_xs">inJP特定技能からのお知らせを掲載しています。</p>
        </div>
    </div>
    <div class="list_news container_s">
        <?php
        $args_news = array('post_type' => 'post','posts_per_page' => 10);
        $the_query_news = new WP_Query( $args_news );
        if ( $the_query_news->have_posts() ) {
            echo '<ul>';
            while ( $the_query_news->have_posts() ) {
                $the_query_news->the_post();
                echo '<li><div class="date">'.get_the_date().'</div><div class="title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></div></li>';
            }
            echo '</ul>';
            wp_reset_postdata();
        }
        ?>
    </div>
</section>