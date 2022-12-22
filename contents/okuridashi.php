<?php
// Okuridashi Config
include locate_template('/parts/action/okuridashi.php');
?>
<div class="okuridashi_contact">
    <div class="container_s">
        <?php
        echo '<div class="okuridashi_title">';
        // Title
        if(!empty($okuridashidata['logo']['url'])){
            echo '<div class="logo"><img src="'.$okuridashidata['logo']['url'].'" title="'.@$page_title_in.'" /></div>';
        }
        echo '<h1>'.@$page_title_in.'</h1>';
        if(!empty($okuridashidata['contents_description'])){
            $nation = get_the_title(esc_attr(@$_GET['id']));
        }
        if(!empty($okuridashidata['nation'])){
            echo '<p>'.$okuridashidata['nation'].'</p>';
        }
        echo '</div>';
        ?>
        <div class="card card_padding_l">
            <?php
            // Main Photo Section
            if(!empty($okuridashidata['photo_main']['url'])){
                echo '<section>';
                echo '<div class="photo_main"><img src="'.$okuridashidata['photo_main']['url'].'" title="'.@$page_title_in.'" /></div>';
                echo '</section>';
            }

            // Description Section
            echo '<section>';
            echo '<div class="area_description">';
            if(!empty($page_honbun)){
                echo '<p>'.nl2br($page_honbun).'</p>';
            }
            
            echo '</div>';
            echo '</section>';

            // Greeting
            $data_table = null;
            if(!empty($kyoiku_text)){
                $data_table .= '<div class="greeting_text">'.$kyoiku_text.'</div>';
            }
            if(!empty($okuridashidata['photo_kyoiku']['url']) and !empty($data_table)){
                echo '<section class="daihyosha_greeting">
                <h2 class="subtitle">'.@$page_title_in.'の教育方針</h2>
                <div class="onphoto">
                    <div class="photo"><div class="inner"><img src="'.$okuridashidata['photo_kyoiku']['url'].'" title="'.@$page_title_in.'" /></div></div>
                    <div class="text">'.$data_table.'</div>
                <div>
                </section>';
            }
            elseif(!empty($data_table)){
                echo '<section class="daihyosha_greeting">
                <h2 class="subtitle">'.@$page_title_in.'の教育方針</h2>
                <div class="nophoto">'.$data_table.'</div>
                </section>';
            }

            // Tokushoku Section
            // $data_table = null;
            // for ($i=1; $i <= 3; $i++) {
            //     $this_column = null;
            //     if(!empty($okuridashidata['title_tokushoku'.$i])){
            //         $this_column .= '<h3>'.$okuridashidata['title_tokushoku'.$i].'</h3>';
            //     }
            //     if(!empty($okuridashidata['text_tokushoku'.$i])){
            //         $this_column .= '<p>'.$okuridashidata['text_tokushoku'.$i].'</p>';
            //     }
            //     if(!empty($okuridashidata['photo_tokushoku'.$i]['url']) and !empty($this_column)){
            //         $data_table .= '<li class="onphoto">
            //             <div class="photo_tokushoku"><div class="inner"><img src="'.$okuridashidata['photo_tokushoku'.$i]['url'].'" title="'.@$page_title_in.'" /></div></div>
            //             <div class="text_tokushoku">'.nl2br($this_column).'</div>
            //         <li>';
            //     }
            //     elseif(!empty($this_column)){
            //         $data_table .= '<li class="nophoto">'.nl2br($this_column).'</li>';
            //     }
            // }
            // if(!empty($data_table)){
            //     echo '<section>';
            //     echo '<h2 class="subtitle">'.@$page_title_in.'の特色</h2>';
            //     echo '<ul class="contents_tokushoku">'.$data_table.'</ul>';
            //     echo '</section>';
            // }

            // Detail Section
            $this_column = null;
            if(!empty($okuridashidata['okuridashi_ninzu'])){
                $this_column .= '<li class="content_service">
                    <h3>年間送り出し人数</h3>
                    <div class="cont_group">
                        <span class="cont_l">'.$okuridashidata['okuridashi_ninzu'].'</span><span class="unit">人</span>
                    </div>
                </li>';
            }
            if(!empty($okuridashidata['nihonjin_staff'])){
                $this_column .= '<li class="content_service">
                    <h3>日本人スタッフ</h3>
                    <div class="cont_group">
                        <span class="cont_l">在籍</span>
                    </div>
                </li>';
            }
            if(!empty($okuridashidata['nihonkokunai_staff'])){
                $this_column .= '<li class="content_service">
                    <h3>日本国内スタッフ</h3>
                    <div class="cont_group">
                        <span class="cont_l">在籍</span>
                    </div>
                </li>';
            }
            if(!empty($okuridashidata['ginokentei'])){
                $this_column .= '<li class="content_service">
                    <h3>技能検定試験対策</h3>
                    <div class="cont_group">
                        <span class="cont_l">対応</span>
                    </div>
                </li>';
            }
            if(!empty($okuridashidata['tokutaiginou_taiou'])){
                $this_column .= '<li class="content_service">
                    <h3>特定技能 送り出し</h3>
                    <div class="cont_group">
                        <span class="cont_l">対応</span>
                    </div>
                </li>';
            }
            if(!empty($okuridashidata['kaigojissusei_taiou'])){
                $this_column .= '<li class="content_service">
                    <h3>介護実習生 送り出し</h3>
                    <div class="cont_group">
                        <span class="cont_l">対応</span>
                    </div>
                </li>';
            }
            if(!empty($this_column)){
                echo '<section>';
                echo '<h2 class="subtitle">'.@$page_title_in.'の管理・サービス</h2>';
                echo '<ul class="contents_info_row">
                    '.$this_column.'<li class="blank"></li><li class="blank"></li>
                </ul>';
                echo '</section>';
            }

            // Info Table Setubi Service
            $data_row = null;
            if(!empty($okuridashidata['setsubi_gomi'])){
                $data_row .= '<li class="content_setsubi">
                    <div class="setsubi_icon"></div>
                    <h3>ごみ分類訓練</h3>
                    <p>日本人にとっては当たり前のゴミの分別ですが、日本のような細かい分別が義務付けられていない国から来日するため、ゴミ分別はとても大事です。</p>
                </li>';
            }
            if(!empty($okuridashidata['setsubi_sports'])){
                $data_row .= '<li class="content_setsubi">
                    <div class="setsubi_icon"></div>
                    <h3>運動施設</h3>
                    <p>実習生が体操、ランニング、筋力トレーニングなどを行うための場所、設備があります。毎日もしくは定期的に訓練するようにしています。</p>
                </li>';
            }
            if(!empty($okuridashidata['setsubi_guntai'])){
                $data_row .= '<li class="content_setsubi">
                    <div class="setsubi_icon"></div>
                    <h3>軍隊式訓練</h3>
                    <p>軍隊式の集団行動訓練経験者による、規律・健康を育むための訓練を行います。集団生活や来日後の生活が安定してできるように厳しく訓練しています。</p>
                </li>';
            }
            if(!empty($okuridashidata['setsubi_jidosha'])){
                $data_row .= '<li class="content_setsubi">
                    <div class="setsubi_icon"></div>
                    <h3>自動車整備訓練設備</h3>
                    <p>自動車整備をするための訓練設備を用意しています。自動車整備の実習生、エンジニアの面接時・教育時に使用できます。</p>
                </li>';
            }
            if(!empty($okuridashidata['setsubi_seiso'])){
                $data_row .= '<li class="content_setsubi">
                    <div class="setsubi_icon"></div>
                    <h3>清掃訓練設備</h3>
                    <p>ビルメンテナンスをするための訓練設備を用意しています。ビルメンテナンス・宿泊等の実習生、エンジニアの面接時・教育時に使用できます。</p>
                </li>';
            }
            if(!empty($okuridashidata['setsubi_bedmake'])){
                $data_row .= '<li class="content_setsubi">
                    <div class="setsubi_icon"></div>
                    <h3>ベッドメイク訓練設備</h3>
                    <p>介護・宿泊職種の実習生・エンジニアの訓練設備を用意しています。介護訓練や宿泊の実習生の訓練にも使うことができます。</p>
                </li>';
            }
            if(!empty($okuridashidata['setsubi_shokuhinkakou'])){
                $data_row .= '<li class="content_setsubi">
                    <div class="setsubi_icon"></div>
                    <h3>食品加工訓練設備</h3>
                    <p>食品加工もしくは食品を扱う際の衛生管理の訓練設備を用意しています。食品加工の技能実習生の訓練に使用します。</p>
                </li>';
            }
            if(!empty($okuridashidata['setsubi_nougyo'])){
                $data_row .= '<li class="content_setsubi">
                    <div class="setsubi_icon"></div>
                    <h3>農業訓練設備</h3>
                    <p>農業の職種の実習生の教育のため、農地を用意しています。出国前に農業に少しでも慣れておくために訓練をします。</p>
                </li>';
            }
            if(!empty($okuridashidata['setsubi_yousetsu'])){
                $data_row .= '<li class="content_setsubi">
                    <div class="setsubi_icon"></div>
                    <h3>溶接訓練設備</h3>
                    <p>溶接作業の実習生のための試験・訓練施設を用意しています。面接時や定期的な技能訓練のために使用することができます。</p>
                </li>';
            }
            if(!empty($okuridashidata['setsubi_kensetsukikai'])){
                $data_row .= '<li class="content_setsubi">
                    <div class="setsubi_icon"></div>
                    <h3>建設機械</h3>
                    <p>ユンボーなどの建設機械を保有しています。建設機械施工の実習生が実習前から作業を経験することができます。</p>
                </li>';
            }
            if(!empty($okuridashidata['setsubi_sakan'])){
                $data_row .= '<li class="content_setsubi">
                    <div class="setsubi_icon"></div>
                    <h3>左官訓練設備</h3>
                    <p>左官をすることができる訓練設備をご用意しています。定期的な技能訓練のために使用することができます。</p>
                </li>';
            }
            if(!empty($okuridashidata['setsubi_ashiba'])){
                $data_row .= '<li class="content_setsubi">
                    <div class="setsubi_icon"></div>
                    <h3>足場訓練設備</h3>
                    <p>とび作業をすることができる訓練設備をご用意しています。足場の設置から足場上の安全作業など。</p>
                </li>';
            }
            if(!empty($data_row)){
                echo '<section>';
                echo '<h2 class="subtitle">'.@$page_title_in.'の訓練設備</h2>';
                echo '<ul class="contents_info_row">
                    '.$data_row.'<li class="blank"></li><li class="blank"></li>
                </ul>';
                echo '</section>';
            }

            // Greeting
            $data_table = null;
            if(!empty($okuridashidata['text_daihyosha_greeting'])){
                $data_table = '<div class="greeting_text">'.nl2br($okuridashidata['text_daihyosha_greeting']).'</div>';
            }
            if(!empty($okuridashidata['daihyosha_name'])){
                $daihyosha_post = null;
                if(!empty($okuridashidata['daihyosha_post'])){
                    $daihyosha_post = '<span class="daihyosha_post">'.$okuridashidata['daihyosha_post'].'</span>';
                }
                $data_table .= '<div class="daihyosha_name">'.@$daihyosha_post.'<span class="name">'.$okuridashidata['daihyosha_name'].'</span></div>';
            }
            if(!empty($okuridashidata['photo_daihyosha']['url']) and !empty($data_table)){
                echo '<section class="daihyosha_greeting">
                <h2 class="subtitle">代表者ご挨拶</h2>
                <div class="onphoto">
                    <div class="photo"><div class="inner"><img src="'.$okuridashidata['photo_daihyosha']['url'].'" title="'.@$page_title_in.'" /></div></div>
                    <div class="text">'.@$data_table.'</div>
                <div>
                </section>';
            }
            elseif(!empty($data_table)){
                echo '<section class="daihyosha_greeting">
                <h2 class="subtitle">代表者ご挨拶</h2>
                <div class="nophoto">'.$data_table.'</div>
                </section>';
            }

            // Info Table Section
            $data_table = null;
            if(!empty($okuridashidata['okuridashi_eng_name'])){
                $data_table .= '<li><h3>送り出し機関名</h3>
                    <div class="tbl_content">
                        <div>'.@$page_title_in.'</div>
                        <div class="small">(英語表記：'.$okuridashidata['okuridashi_eng_name'].')</div>
                    </div>
                </li>';
            }
            else{
                $data_table .= '<li><h3>送り出し機関名</h3>
                    <div class="tbl_content">
                        <div>'.@$page_title_in.'</div>
                    </div>
                </li>';
            }
            if(!empty($okuridashidata['nation'])){
                $data_table .= '<li><h3>送り出し国</h3>
                    <div class="tbl_content">
                        <div>'.$okuridashidata['nation'].'</div>
                    </div>
                </li>';
            }
            if(!empty($okuridashidata['city'])){
                $data_table .= '<li><h3>都市</h3>
                    <div class="tbl_content">
                        <div>'.$okuridashidata['city'].'</div>
                    </div>
                </li>';
            }
            if(!empty($okuridashi_type_text)){
                $data_table .= '<li><h3>対応している在留許可の種類</h3>
                    <div class="tbl_content">
                        <div class="cont_type">'.$okuridashi_type_text.'</div>
                    </div>
                </li>';
            }
            if(!empty($okuridashidata['okuridashi_kana_daihyo_name'])){
                $cont = null;
                if(!empty($okuridashidata['okuridashi_eng_daihyo_name'])){
                    $cont = '<div class="small">('.$okuridashidata['okuridashi_eng_daihyo_name'].')</div>';
                }
                $data_table .= '<li><h3>代表者</h3>
                    <div class="tbl_content">
                        <div>'.$okuridashidata['okuridashi_eng_daihyo_name'].'</div>
                        '.$cont.'
                    </div>
                </li>';
            }
            if(!empty($okuridashidata['addr'])){
                $data_table .= '<li><h3>所在地</h3>
                    <div class="tbl_content">
                        <div>'.$okuridashidata['addr'].'</div>
                    </div>
                </li>';
            }
            if(!empty($okuridashidata['text_teikeisaki'])){
                $data_table .= '<li><h3>提携機関</h3>
                    <div class="tbl_content">
                        <div>'.$okuridashidata['text_teikeisaki'].'</div>
                    </div>
                </li>';
            }
            if(!empty($data_table)){
                echo '<section>';
                echo '<h2 class="subtitle">'.@$page_title_in.'の会社情報</h2>';
                echo '<ul class="contents_info_table">'.$data_table.'</ul>';
                echo '</section>';
            }
            $data_table = null;
            echo '<ul class="contents_info_row">'.$data_table.'</ul>';

            // Map
            if(!empty($okuridashidata['map'])){
                echo '<section><div class="gmap">'.$okuridashidata['map'].'</div></section>';
            }

            // Siryo
            $data_table = null;
            if(!empty($okuridashidata['kyokashou']['url'])){
                $data_table .= '<div><a href="'.$okuridashidata['kyokashou']['url'].'" target="_blank">許可証</a></div>';
            }
            if(!empty($okuridashidata['pamphlet']['url'])){
                $data_table .= '<div><a href="'.$okuridashidata['pamphlet']['url'].'" target="_blank">パンフレット</a></div>';
            }
            if(!empty($data_table)){
                echo '<section>';
                echo '<h2 class="subtitle">'.@$page_title_in.'の資料</h2>';
                echo '<p>'.@$page_title_in.'の資料は下記からダウンロードすることができます。</p>';
                echo '<ul class="shiryo">'.$data_table.'</ul>';
                echo '</section>';
            }
            ?>
            
        </div>
    </div>
</div>