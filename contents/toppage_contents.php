<section class="mainvisual toppage_mainvisual">
    <div class="container mainvisual_content form">
        <form id="contact-form" action="<?php echo site_url('/?pagetype=estimate_result'); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="wpnonce" value="<?php echo wp_create_nonce( get_bloginfo('name').'nonce_'.date('Ymd') ); ?>" />
            <div class="card">
                <h2>外国人技能実習生<br />比較見積もり</h2>
                <p>外国人技能実習生受け入れするなら、<strong>監理費が安い監理団体</strong>に依頼しましょう。inJP技能実習生なら、<strong>30,000円以下の監理費</strong>でお見積りが取れることを保証します。また、すでに実習生を受け入れている企業様も切り替え可能です。</p>
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
                <div class="area_button submit"><button type="submit" name="submit" value="sending"><span class="line1">今すぐに簡単</span><span class="line2">比較お見積り</span></button></div>
                <p class="form-message"></p>
            </div>
            <div class="balloon">
                <div class="line1">監理費</div>
                <div class="line2">3<span>万円以下</span></div>
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
            <h2 class="title">技能実習生の雇用で<br />こんなお悩みはありませんか？</h2>
            <p class="lead container_xs">技能実習制度を導入されている企業様や、初めて制度を導入される企業様から、以下のようなお悩みをよくお聞きします。</p>
        </div>
    </div>
    <div class="container_s">
        <div class="problems card card_padding_l">
            <ul>
                <li><span>はじめて</span>で、制度についてよくわからない</li>
                <li>監理団体を<span>選びたい</span>のに情報が少なすぎる</li>
                <li>監理費が高い！<span>監理費を安く</span>したい</li>
                <li>監理団体がぜんぜん<span>監査に来ない</span></li>
            </ul>
        </div>
    </div>
</section>

<section class="toppage_overview section section_bgc_grey">
    <div class="titleset">
        <div class="container">
            <h2 class="title">inJP技能実習なら<br />安い監理団体が選べる</h2>
            <p class="lead container_xs">日本にはおおよそ5,000もの監理団体があるにも関わらず、監理費の公開に関しては消極的な組合が多く、企業やエリアによって価格を変えることもあったり、公開できないこともあるようです。また、エリアや職種を限定している組合も多く、1つ1つ問い合わせして見積もりをとっていくには無理があります。</p>
        </div>
    </div>
    <div class="container_s">
        <div class="card card_padding_l card_blue">
            <h3 class="card_title">該当エリア・職種の監理団体に見積もりできる</h3>
            <p>inJP技能実習生なら、該当エリア・職種の監理団体から見積もりが取ることができます。また、掲載されているすべての見積もりは3万円(送り出し機関監理費含める)以下になっております。</p>
        </div>
        <div class="card card_padding_l card_blue margin_top_m">
            <h3 class="card_title">既に技能実習生を受け入れている企業様もOK</h3>
            <p>既に技能実習生を受け入れてみえる企業さんも、監理団体の切り替えは不可能ではありません。監理団体を変更したい理由などをより具体的に教えていただけるとスムーズな変更が可能になります。</p>
        </div>
        <div class="card card_padding_l card_blue margin_top_m">
            <h3 class="card_title">監理団体・送り出し機関には情報は公開されません</h3>
            <p>企業様が契約・面談をご希望されない限り、送り出し機関や監理団体に問い合わせ情報や企業情報を教えることはありません。しつこい営業電話やメールがかかってくることはありません。</p>
        </div>
    </div>
</section>

<section class="toppage_overview section">
    <div class="titleset">
        <div class="container">
            <h2 class="title">サービスの特徴</h2>
            <p class="lead container_xs">当サービスの特徴はとてもシンプルです。<br />公開非公開問わず、各方面から入手した監理団体の本当の監理費を公開しています。また、監理費の公開以外にもさまざまな特徴があります。</p>
            <p class="container_xs text_s">※組合から許可をもらっている見積もりのみ名前を公開。</p>
        </div>
    </div>
    <div class="container">
        <div class="column_3">
            <div class="c_content">
                <h3>すべて監理費が3万円以下</h3>
                <p>ここで公開されている見積もりは<strong>3万円(送り出し機関監理費含む)以下の監理費の見積もりのみ</strong>が公開されています。安いことが一番大事ではありませんが、監理費が安ければ実習生の住環境の補助に使うこともできます。</p>
            </div>
            <div class="c_content">
                <h3>通常では公開されない見積もり</h3>
                <p><strong>通常では公開されない見積もり</strong>も公開しています。契約している送り出し機関から入手したものや、組合名非公開を条件に掲載許可を得た見積もりを公開しています。通常では提示されない1万円代の見積もりも中には存在します。</p>
            </div>
            <div class="c_content">
                <h3>安かろう悪かろうは許されない</h3>
                <p>監理団体には、1号実習生は毎月の訪問指導・3ヶ月に1回の監査、2号実習生は3ヶ月に1回の監査が義務付けられています。安い監理費ではありますが、<strong>法令に基づいた指導・監査を行なっている監理団体のみ</strong>掲載しています。</p>
            </div>
        </div>
    </div>
</section>

<section class="toppage_customersvoice section section_bgi" style="background-image:url('<?php echo $theme_uri.'/dist/images/bgi_blue_grd.png'; ?>');">
    <div class="titleset">
        <div class="container">
            <h2 class="title">当サービスご利用の<br />お客様のお声</h2>
            <p class="lead container_xs">当サービスをご利用になり、技能実習生の受け入れ・監理団体の切り替えをした企業様にインタビューして、ご感想などをお聞きしています。</p>
        </div>
    </div>
    <div class="container">
        <div class="column_3">
            <div class="c_content card">
                <h3>監理費が1名2万円/月も下がりびっくりした</h3>
                <p class="text_s">千葉県 建設/型枠 H社長</p>
                <p>周りからも高い高いと言われ続けていた組合から見積もりで該当エリア・職種にマッチした組合に切り替えをしました。4.5万円からいきなり、3万円になりました。今在籍している実習生の切り替えですが、新しい実習生が入国する時の費用もけっこう安くなりそうです。</p>
            </div>
            <div class="c_content card">
                <h3>同じ送り出し機関なのに監理費年間300万円もダウン</h3>
                <p class="text_s">神奈川県 ビルメンテナンス O部長</p>
                <p>これまで毎年6名の実習生を入れ、18名の実習生を雇用していました。前の組合は監理費が高く、3.5万円でしたが、このサービスで見積もった組合は2万円になり、組合変更と新規の受け入れをしました。送り出しき機関を変えず年間300万円以上もコストダウンしました。</p>
            </div>
            <div class="c_content card">
                <h3>前の組合に不安を感じて監理団体を探しました</h3>
                <p class="text_s">山形県 牛豚食肉処理加 Y社長</p>
                <p>元々監理費は安かったのでよかったが、配属から1回も来てくれない組合に不安を感じて、こちらで見積もりした組合に相談したところ、実際、実習計画に入っている作業ができていなかった。すぐに計画変更をしてもらい不安が解消できた。監理団体変更してよかった。</p>
            </div>
            <div class="c_content card">
                <h3>探しても見つけられなかった安い組合を見つけた</h3>
                <p class="text_s">愛知県 医療・福祉施設給食 K社長</p>
                <p>新しく追加された職種かつ特殊な職種なので、組合が多い愛知県でも見つからなかった。このサイトで見積もったら監理費が安い組合が見つかった。3名はそのまま特定技能で残ってもらい、新規でまた3名を採用した。この職種に関する専門的知識もあり、とても安心。</p>
            </div>
            <div class="c_content card">
                <h3>1名の実習生でも丁寧に対応してくれた</h3>
                <p class="text_s">群馬県 自動車整備 O社長</p>
                <p>1名の採用だとなかなか対応してくれる組合がなく、嫌な顔をされた。これまでは高い組合で言われるがまま支払っていたが、丁寧に対応してくれる組合に変更ができた上に、費用も安くなった。その分実習生に還元してあげて、実習生も喜んでくれた。</p>
            </div>
            <div class="c_content card">
                <h3>初めてだったが適正な価格になったと思う</h3>
                <p class="text_s">千葉県 機械加工 A社長</p>
                <p>技能実習生が初めてで、同業の知り合いからの組合を紹介してもらったが、組合によって違う監理費だと聞いたので相見積もりしてみることに。紹介してもらった組合よりも1万円以上監理費が安くなった。見積もりをとっておいてよかった。</p>
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
            <h2 class="title">監理費お見積り一例</h2>
            <p class="lead container_xs">当サイトに登録してある技能実習生の監理団体の見積りです。ここでしか掲載されていないような非公開情報もあり、個人情報を通知しなくてもここだけで情報を見ることができます。</p>
        </div>
    </div>
    <div class="result_top">
        <div class="container">
        <?php
        $args2 = array(
            'post_type' => 'estimates',
            'posts_per_page' => 6,
            'orderby' => 'post__in',
            'order'   => 'ASC',
        );
        $args2['meta_query'][] = array(
            'key' => 'estimates',
            'value' => serialize('viewtoppage_on'),
            'compare' => 'Like'
        );
        $the_query2 = new WP_Query( $args2 );
        $count = 1;
        if ( $the_query2->have_posts() ) {
            echo '<ul class="list">';
            while ( $the_query2->have_posts() ) {
                $the_query2->the_post();
                include get_template_directory().'/parts/estimate_result_loop.php';
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
            <p class="lead container_xs">inJP技能実習のお知らせ、新しい見積もりの追加、新しい送り出し機関情報の掲載などをお知らせしていきます。</p>
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