<?php
$insert_email_content = $insert_array_postmeta = $insert_id = null;
$insert_email_content .= esc_attr($_POST['com_name'])." ".esc_attr(@$_POST['tantousha'])."様\n\n";
$insert_email_content .= "この度はinJP 技能実習へのお問合せ 誠にありがとうございました。\n";
$insert_email_content .= "本メールはinJP 技能実習からお見積りの詳細確認・お申し込みをされたお客様にのみお送りしております。\n";
$insert_email_content .= "==============================================\n\n";
$insert_email_content .= "以下のようにお問合せ承りました。\n\n";
if(!empty($_POST['id'])){
    $insert_email_content .= "■ お見積りID\n".esc_attr($_POST['id'])."\n\n";
    $insert_email_content .= "■ お見積りID URL\n".site_url('/?pagetype=estimate_contact&id='.@$_POST['id'])."\n\n";
    $insert_array_postmeta['id'] = esc_attr($_POST['id']);
}

if(!empty($_POST['okuridashi_name'])){
    $insert_email_content .= "■ 送り出し機関\n".esc_attr($_POST['okuridashi_name'])."\n\n";
}

$insert_email_content .= "==============================================\n\n";

if(!empty($_POST['com_name'])){
    $insert_email_content .= "■ 会社名\n".esc_attr($_POST['com_name'])."\n\n";
    $insert_array_postmeta['com_name'] = esc_attr($_POST['com_name']);
}
if(!empty($_POST['tel'])){
    $insert_email_content .= "■ お電話番号\n".esc_attr($_POST['tel'])."\n\n";
    $insert_array_postmeta['tel'] = esc_attr($_POST['tel']);
}
if(!empty($_POST['email'])){
    $insert_email_content .= "■ メールアドレス\n".esc_attr($_POST['email'])."\n\n";
    $insert_array_postmeta['email'] = esc_attr($_POST['email']);
}
if(!empty($_POST['tantousha'])){
    $insert_email_content .= "■ 担当者様のお名前\n".esc_attr($_POST['tantousha'])."\n\n";
    $insert_array_postmeta['tantousha'] = esc_attr($_POST['tantousha']);
}
if(!empty($_POST['shokushu'])){
    $shokushu_text = null;
    foreach ($array_shokushu_group as $shokushu_grp) {
        foreach ($shokushu_grp as $shokushu_values) {
            if(!empty($shokushu_values[0]) and $shokushu_values[0] == $_POST['shokushu']){
                $shokushu_text = $shokushu_values[1];
                break;
            }
        }
    }
    $insert_email_content .= "■ 職種\n".esc_attr($shokushu_text)."\n\n";
    $insert_array_postmeta['shokushu'] = esc_attr($_POST['shokushu']);
}
if(!empty($_POST['pref'])){
    $insert_email_content .= "■ 都道府県\n".esc_attr($_POST['pref'])."\n\n";
    $insert_array_postmeta['pref'] = esc_attr($_POST['pref']);
}
if(!empty($_POST['jissusei_koyou'])){
    $insert_email_content .= "■ 技能実習生の雇用経験\n".esc_attr($_POST['jissusei_koyou'])."\n\n";
    $insert_array_postmeta['jissusei_koyou'] = esc_attr($_POST['jissusei_koyou']);
}
if(!empty($_POST['jissusei_subject'])){
    $insert_email_content .= "■ お問合せ内容\n".esc_attr($_POST['jissusei_subject'])."\n\n";
    $insert_array_postmeta['jissusei_subject'] = esc_attr($_POST['jissusei_subject']);
}
if(!empty($_POST['mendan_kibo_type'])){
    $insert_email_content .= "■ 面談方法\n".esc_attr($_POST['mendan_kibo_type'])."\n\n";
    $insert_array_postmeta['mendan_kibo_type'] = esc_attr($_POST['mendan_kibo_type']);
}
if(!empty($_POST['mendan_kibo_nichiji_1'])){
    $insert_email_content .= "■ 面談ご希望日①\n".esc_attr($_POST['mendan_kibo_nichiji_1'])."\n\n";
    $insert_array_postmeta['mendan_kibo_nichiji_1'] = esc_attr($_POST['mendan_kibo_nichiji_1']);
}
if(!empty($_POST['mendan_kibo_jikan_1'])){
    $insert_email_content .= "■ 面談ご希望時間①\n".esc_attr($_POST['mendan_kibo_jikan_1'])."\n\n";
    $insert_array_postmeta['mendan_kibo_jikan_1'] = esc_attr($_POST['mendan_kibo_jikan_1']);
}
if(!empty($_POST['mendan_kibo_nichiji_2'])){
    $insert_email_content .= "■ 面談ご希望日②\n".esc_attr($_POST['mendan_kibo_nichiji_2'])."\n\n";
    $insert_array_postmeta['mendan_kibo_nichiji_2'] = esc_attr($_POST['mendan_kibo_nichiji_2']);
}
if(!empty($_POST['mendan_kibo_jikan_2'])){
    $insert_email_content .= "■ 面談ご希望時間②\n".esc_attr($_POST['mendan_kibo_jikan_2'])."\n\n";
    $insert_array_postmeta['mendan_kibo_jikan_2'] = esc_attr($_POST['mendan_kibo_jikan_2']);
}
if(!empty($_POST['mendan_kibo_nichiji_3'])){
    $insert_email_content .= "■ 面談ご希望日③\n".esc_attr($_POST['mendan_kibo_nichiji_3'])."\n\n";
    $insert_array_postmeta['mendan_kibo_nichiji_3'] = esc_attr($_POST['mendan_kibo_nichiji_3']);
}
if(!empty($_POST['mendan_kibo_jikan_3'])){
    $insert_email_content .= "■ 面談ご希望時間③\n".esc_attr($_POST['mendan_kibo_jikan_3'])."\n\n";
    $insert_array_postmeta['mendan_kibo_jikan_3'] = esc_attr($_POST['mendan_kibo_jikan_3']);
}
$insert_email_content .= "==============================================\n\n";
$insert_email_content .= "■ お問合せ後の流れ(本メールの後の手続き)\n";
$insert_email_content .= "本メール到着後、inJPから該当の監理団体(協同組合)に連絡をします。その後、監理団体から直接連絡がいく流れとなります。\n";
$insert_email_content .= "お問合せいただいた監理団体以外からは連絡がいくことはありません。海外の送り出し機関からの営業電話やメールなど非常に多くなっておりますが、当方から海外の送り出し機関に連絡先を開示することはありません。\n";
$insert_email_content .= "「inJPからお問合せいただいた◯◯という監理団体です」と必ず名乗って電話がありますので、お電話をお待ちください。\n\n";
$insert_email_content .= "==============================================\n\n";
$insert_email_content .= "■ inJP技能実習\n\n";
$insert_email_content .= "メール：jisshuusei@injp.work\n";
$insert_email_content .= "URL：https://ginoujissu.injp.work\n";
$insert_email_content .= "運営：合同会社ＮＩＣＨＥＲＳ\n\n";
$insert_email_content .= "==============================================\n\n";

// SendEmail
$to = @$_POST['email'];
$subject = 'inJP技能実習へのお問合せ';
$headers[] = 'From: inJP技能実習生 <jisshuusei@injp.work>';
$headers[] = 'Bcc: inJP技能実習生 <jisshuusei@injp.work>';
wp_mail( $to, $subject, $insert_email_content, $headers );

// Insert Post
$my_post = array(
    'post_title'    => @$_POST['id'].' - '.@$_POST['jissusei_subject'],
    'post_status'   => 'private',
    'post_type'   => 'inquiries'
);
$insert_id = wp_insert_post( $my_post );
if(!empty($insert_id) and is_numeric($insert_id)){
    update_post_meta( $insert_id, 'inquiries', $insert_array_postmeta );
}

// Redirect
wp_redirect( site_url('/?pagetype=thankyou') );
exit;