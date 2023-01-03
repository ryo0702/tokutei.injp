<?php
$estdata = $this_title = $kanrihi = $okuridashi_name = $discount_description = $badge = null;
$estdata = get_post_meta( get_the_ID(), 'hr', true );

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

// プロフィール
$profile = null;
if(!empty($estdata['nation'])){
    $profile .= '<div class="profile_area"><div class="area_title">出身国</div><div class="area_content"><span class="bold">'.@$estdata['nation'].'</span></div></div>';
}
if(!empty($estdata['visa'])){
    $profile .= '<div class="profile_area"><div class="area_title">現在の在留資格</div><div class="area_content"><span class="bold">'.@$estdata['visa'].'</span></div></div>';
}
if(!empty($estdata['birth_y']) && !empty($estdata['birth_m']) && !empty($estdata['birth_d'])){
    $now = date('Ymd');
    $birthday = $estdata['birth_y']."-".$estdata['birth_m']."-".$estdata['birth_d'];
    $birthday = str_replace("-", "", $birthday);
    $age = floor(($now - $birthday) / 10000);
    $profile .= '<div class="profile_area"><div class="area_title">年齢</div><div class="area_content"><span class="bold">'.@$age.'</span>歳</div></div>';
}
if(!empty($estdata['pref']) && is_array($estdata['pref'])){
    $prefs = null;
    foreach ($estdata['pref'] as $pref) {
        $prefs .= $pref.'、';
    }
    $prefs = rtrim($prefs, "、");
    $profile .= '<div class="profile_area"><div class="area_title">就業希望地域</div><div class="area_content">'.$prefs.'</div></div>';
}

// Discount Description
if(!empty($estdata['discount_description'])){
    $discount_description = '<div class="discount_description">
        <p>'.$estdata['discount_description'].'</p>
    </div>';
}

// Link
$link_url = null;
$link_url = site_url('?pagetype=hr_contact&id='.get_the_ID());

echo '<li class="card">';
echo '<div class="content_area">';
echo '<div class="title_area"><a href="'.$link_url.'" title="'.$this_title.'">'.$this_title.'</a></div>';
echo @$profile;
echo '</div>';
echo '<div class="button_area"><a href="'.$link_url.'" title="'.$this_title.'の面接依頼をする">面接依頼をする</a></div>';
if(!empty($badge)){
    echo '<div class="badge_area">'.$badge.'</div>';
}
echo '</li>';
$count++;