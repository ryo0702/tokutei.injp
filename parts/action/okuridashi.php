<?php
$page_honbun = null;

// Description(Honbun)
if(!empty($okuridashidata['nation'])){
    if(!empty($okuridashidata['okuridashi_eng_name'])){
        $page_honbun .= @$page_title.'(正式名：'.@$okuridashidata['okuridashi_eng_name'].')は、'.$okuridashidata['nation'].'の日本への技能実習生の送り出しライセンスを持った送り出し機関です。';
    }
    else{
        $page_honbun .= @$page_title.'は、'.$okuridashidata['nation'].'の日本への技能実習生の送り出しライセンスを持った送り出し機関です。';
    }
}
if(!empty($okuridashidata['city'])){
    if($okuridashidata['city'] == 'ハノイ'){
        $page_honbun .= 'ベトナムの首都「'.$okuridashidata['city'].'」に本社があります。';
    }
    elseif($okuridashidata['city'] == 'ホーチミン'){
        $page_honbun .= '本社所在地は、ベトナムの大都市「'.$okuridashidata['city'].'」にあります。';
    }
    elseif($okuridashidata['city'] == 'ジャカルタ'){
        $page_honbun .= '本社所在地は、インドネシアの首都「'.$okuridashidata['city'].'」に本社があります。';
    }
    elseif($okuridashidata['city'] == 'マニラ'){
        $page_honbun .= '本社所在地は、フィリピンの首都「'.$okuridashidata['city'].'」に本社が存在します。';
    }
    elseif($okuridashidata['city'] == 'ネピドー'){
        $page_honbun .= '本社所在地は、ミャンマーの首都「'.$okuridashidata['city'].'」が本社所在地です。';
    }
    else{
        $page_honbun .= '本社所在地は'.$okuridashidata['city'].'にあります。';
    }
}
$okuridashi_type_text = null;
if(!empty($okuridashidata['type']) and is_array($okuridashidata['type'])){
    foreach ($okuridashidata['type'] as $type_key => $type_value) {
        if ($type_key === array_key_last($okuridashidata['type'])) {$okuridashi_type_text .= @$array_okuridasi_zairyushikaku[$type_value];}
        else{$okuridashi_type_text .= @$array_okuridasi_zairyushikaku[$type_value].'、';}
    }
}
if(!empty($okuridashi_type_text)){
    $page_honbun .= '現在、'.$page_title.'では、'.$okuridashi_type_text.'の在留資格の送り出しを行なっています。<br />';
    if(!empty($okuridashidata['tokutaiginou_taiou'])){
        $page_honbun .= '特定技能の送り出しでは、これまで送り出しをした豊富な技能実習生の帰国後のキャリアについても、特定技能として再度出国できるように、たくさんの候補者を集めています。<br />';
    }
}
if(!empty($okuridashidata['kaigojissusei_taiou'])){
    $page_honbun .= 'また、介護実習生の送り出しも行っております。<br />';
}

if(!empty($okuridashidata['feature_point1'])){
    $page_honbun .= w_point_text($okuridashidata['feature_point1'],$okuridashidata,$page_title);
}
if(!empty($okuridashidata['feature_point2'])){
    $page_honbun .= w_point_text($okuridashidata['feature_point2'],$okuridashidata,$page_title);
}
if(!empty($okuridashidata['feature_point3'])){
    $page_honbun .= w_point_text($okuridashidata['feature_point3'],$okuridashidata,$page_title);
}

// Kyoiku
$kyoiku_text = null;
if(!empty($okuridashidata['kyoikuhoushin'])){
    if($okuridashidata['kyoikuhoushin'] == 'ノビノビとした自由な教育'){
        $kyoiku_text .= $page_title.'の教育方針は、生徒(実習生候補者)が自由な発想で楽しくノビノビと学習できるようにしています。実習生同士の協力する心を育みながら、一丸となって技能実習や日本の生活に適応できるような柔軟な考えを勉強してもらっています。';
    }
    elseif($okuridashidata['kyoikuhoushin'] == '徹底した詰め込み学習'){
        $kyoiku_text .= $page_title.'の教育方針は「日本語第一」学習で、とにかく詰め込み勉強を厳しく行っています。面接から日本へ入国するまでの期間は長くて6ヶ月。そんなに長い期間ではないがとても重要な期間、どう学習するかというこtが今後の3年以上の日本での生活を大きく左右します。実習生が日本に入ってから不自由しないために、できる限りのことを行います。';
    }
    elseif($okuridashidata['kyoikuhoushin'] == '独自の教科書を用意'){
        $kyoiku_text .= $page_title.'が独自に開発した教材を使い学習をしています。通常であれば、みんなの日本語を使った授業をするのですが、時代に則した教材を自社で作り、勉強の効率アップを図っています。';
    }
    elseif($okuridashidata['kyoikuhoushin'] == '日本語教育よりも専門教育'){
        $kyoiku_text .= '実習生にとって日本語教育はとても大事です。しかしながら、最低限の日本語を学ぶのは当然ですが、実習先には先輩実習生や特定技能生がいる可能性もあります。より日本語を深く学ぶよりも、専門的な技術を勉強して、すぐに会社に入って働けるようにすることこそが、実習生のためになると考えています。';
    }
}

// Functions
function w_point_text($point_type = null,$okuridashidata = null,$page_title = null){
    $page_honbun = null;
    if(!empty($point_type)){
        if($point_type == '日本語教育'){
            $page_honbun .= @$page_title.'が力を入れているのは、日本語教育で、';
            if(!empty($okuridashidata['n3seito']) and is_numeric($okuridashidata['n3seito'])){
                if($okuridashidata['n3seito'] <= 1){
                    $page_honbun .= '1年間でN3レベル以上の実習生を複数人輩出するなど、日本語教育に関しては実績があります。';
                }
                else{
                    $page_honbun .= 'N3レベル以上の実習生を輩出する実績もあります。';
                }
            }
            elseif(!empty($okuridashidata['nihonjin_staff'])){
                $page_honbun .= '日本人教師・スタッフも在籍しており、日本でも通用する教育を行なっています。';
            }
            else{
                $page_honbun .= '実習生が日本に入国して生活・仕事をする上で、不自由のない日本語を習得するために、熱心に教育を行なっています。';
            }
        }
        elseif($point_type == '職業教育'){
            $page_honbun .= '職業訓練など、日本語教育以外の教育にも積極的で、実習生が来日した際に、仕事に馴染みやすいように基本的な道具の名前や作業内容などを教育しています。';
            $this_honbun_setsubi = null;
            if($okuridashidata['setsubi_jidosha'] == 1){
                $this_honbun_setsubi .= '自動車整備の訓練施設、';
            }
            if($okuridashidata['setsubi_yousetsu'] == 1){
                $this_honbun_setsubi .= '溶接を行うための訓練施設、';
            }
            if(!empty($okuridashidata['setsubi_seiso'])){
                $this_honbun_setsubi .= 'ビルメンテナンスで利用する清掃訓練設備、';
            }
            if(!empty($okuridashidata['setsubi_bedmake'])){
                $this_honbun_setsubi .= 'ベッドメイクなどの練習を行う設備、';
            }
            if(!empty($okuridashidata['setsubi_shokuhinkakou'])){
                $this_honbun_setsubi .= '食品加工における衛生管理や調理の練習を行うキッチン、';
            }
            if(!empty($okuridashidata['setsubi_nougyo'])){
                $this_honbun_setsubi .= '農業訓練のための畑、';
            }
            if(!empty($okuridashidata['setsubi_kensetsukikai'])){
                $this_honbun_setsubi .= '練習のための建設機械、';
            }
            if(!empty($okuridashidata['setsubi_sakan'])){
                $this_honbun_setsubi .= '左官の練習のための設備、';
            }
            if(!empty($okuridashidata['setsubi_ashiba'])){
                $this_honbun_setsubi .= '足場訓練のための設備、';
            }
            if(!empty($this_honbun_setsubi)){
                $this_honbun_setsubi = rtrim($this_honbun_setsubi, "、");
                $page_honbun .= '職業訓練施設は'.$this_honbun_setsubi.'などの設備や施設をご用意しています。';
            }
        }
        elseif($point_type == '日本の生活知識'){
            if(!empty($okuridashidata['setsubi_gomi'])){
                $page_honbun .= '日本風のゴミ出し(ゴミの分別)などもセンターに設置して、実習生がいざ日本に来た時にも適応できるように日頃から訓練しています。';
            }
            if(!empty($okuridashidata['setsubi_guntai'])){
                $page_honbun .= 'センターでは軍隊式の規則正しい生活をおこなっているため、日本で仕事に集中できるようにしています。';
            }
        }
        elseif($point_type == '体力作り'){
            $this_honbun_seikatsu = null;
            if(!empty($okuridashidata['setsubi_sports'])){
                $this_honbun_seikatsu .= '実習生は基本的に体力を使う仕事が多く、日本語の勉強と共に大事なのは体力作りです。当センターでは実習生として配属される前から、基本的な運動を定期的に行うように指導しています。';
            }
            if(!empty($okuridashidata['setsubi_guntai'])){
                $this_honbun_seikatsu .= 'センターでは軍隊式の規則正しい生活をおこなっているため、日本で仕事に集中できるようにしています。';
            }
            if(!empty($this_honbun_seikatsu)){
                $page_honbun .= $this_honbun_seikatsu;
            }
        }
        elseif($point_type == '実習生の負担軽減'){
            $page_honbun .= '実習生の負担軽減のため、'.$page_title.'ではさまざまな取り組みをしています。勉強に打ち込むためには、金銭的な負担を減らすことが大事だと考え、さまざまな工夫を行い、低コストで出国までできるようにシステムを考案しています。';
        }
        elseif($point_type == '入国後のサポート'){
            $page_honbun .= $page_title.'では、入国後のサポートもしっかりしています。監理団体からの連絡でなくても、企業様から直接通訳者にご連絡していただくことができます。';
        }
    }
    return $page_honbun;
}