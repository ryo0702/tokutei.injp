<?php
$insert_email_content = $insert_array_postmeta = $insert_id = null;
$insert_email_content .= @$_POST['com_name']." ".@$_POST['tantousha']."様\n\n";
$insert_email_content .= "==============================================\n";
$insert_email_content .= "この度はinJP 技能実習へのお問合せ 誠にありがとうございました。\n";
$insert_email_content .= "本メールはinJP 技能実習からお見積りの詳細確認・お申し込みをされたお客様にのみお送りしております。\n";
$insert_email_content .= "==============================================\n\n";
$insert_email_content .= "以下のようにお問合せ承りました。\n\n";
if(!empty($_POST['id'])){
    $insert_email_content .= "■ お見積りID\n".@$_POST['id']."\n\n";
    $insert_array_postmeta['id'] = @$_POST['id'];
}
if(!empty($_POST['com_name'])){
    $insert_email_content .= "■ 会社名\n".@$_POST['com_name']."\n\n";
    $insert_array_postmeta['com_name'] = @$_POST['com_name'];
}
if(!empty($_POST['tel'])){
    $insert_email_content .= "■ お電話番号\n".@$_POST['tel']."\n\n";
    $insert_array_postmeta['tel'] = @$_POST['tel'];
}
if(!empty($_POST['email'])){
    $insert_email_content .= "■ メールアドレス\n".@$_POST['email']."\n\n";
    $insert_array_postmeta['email'] = @$_POST['email'];
}
if(!empty($_POST['tantousha'])){
    $insert_email_content .= "■ 担当者様のお名前\n".@$_POST['tantousha']."\n\n";
    $insert_array_postmeta['tantousha'] = @$_POST['tantousha'];
}
if(!empty($_POST['shokushu'])){
    $insert_email_content .= "■ 職種\n".@$_POST['shokushu']."\n\n";
    $insert_array_postmeta['shokushu'] = @$_POST['shokushu'];
}
if(!empty($_POST['pref'])){
    $insert_email_content .= "■ 都道府県\n".@$_POST['pref']."\n\n";
    $insert_array_postmeta['pref'] = @$_POST['pref'];
}
if(!empty($_POST['jissusei_koyou'])){
    $insert_email_content .= "■ 技能実習生の雇用経験\n".@$_POST['jissusei_koyou']."\n\n";
    $insert_array_postmeta['jissusei_koyou'] = @$_POST['jissusei_koyou'];
}
if(!empty($_POST['jissusei_subject'])){
    $insert_email_content .= "■ お問合せ内容\n".@$_POST['jissusei_subject']."\n\n";
    $insert_array_postmeta['jissusei_subject'] = @$_POST['jissusei_subject'];
}
$insert_email_content .= "==============================================\n\n";
$insert_email_content .= "■ お問合せ後の流れ(本メールの後の手続き)\n";
$insert_email_content .= "本メール到着後、inJPから該当の監理団体(協同組合)に連絡がいきます。その後、監理団体から直接連絡がいく流れとなります。\n";
$insert_email_content .= "お問合せいただいた監理団体以外からは連絡がいくことはありません。海外の送り出し機関からの営業電話やメールなど非常に多くなっております。\n";
$insert_email_content .= "「inJPからお問合せいただいた◯◯という監理団体です」と必ず名乗って電話がありますのでお電話をお待ちください。\n\n";
$insert_email_content .= "==============================================\n\n";
$insert_email_content .= "inJP技能実習\n";
$insert_email_content .= "運営：合同会社ＮＩＣＨＥＲＳ";

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