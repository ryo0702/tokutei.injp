<?php
$okuridata = $this_title = $kanrihi = $okuridashi_name = $discount_description = $badge = null;
$okuridata = get_post_meta( get_the_ID(), 'okuridashi', true );

// Title
if(!empty(get_the_title(get_the_ID()))){
    $this_title = get_the_title(get_the_ID());
}
else{
    $this_title = '送り出し機関名非公開';
}

// Kanrihi
if(!empty($okuridata['kanrihi']) and is_numeric($okuridata['kanrihi'])){
    $kanrihi = '<span class="small">1名</span><span class="price_number">'.number_format($okuridata['kanrihi']).'</span><span class="small">円/月</span>';
    if(!empty($okuridata['okuridashi_kanrihi']) and is_numeric($okuridata['okuridashi_kanrihi'])){
        $kanrihi .= '<span class="small">(内送り出し監理費'.number_format($okuridata['okuridashi_kanrihi']).'円)</span>';
    }
}
else{
    $kanrihi = '<span class="price_number">未公開</span>';
}
// Okuridashi
if(!empty($okuridata['okuridashi']) and is_numeric($okuridata['okuridashi'])){
    $okuridashi_name = get_the_title($okuridata['okuridashi']);
    $okuridashidata = get_post_meta( $okuridata['okuridashi'], 'okuridashi', true );
    if(!empty(@$okuridashidata['nation'])){
        $okuridashi_name .= '<span class="nation">('.@$okuridashidata['nation'].')</span>';
    }
    if(@$okuridashidata['okuridashi_detail_page_view'] == 'okuridashi_detail_page_view_on'){
        $okuridashi_name = '<a href="'.site_url('/?pagetype=okuridashi&id='.$okuridata['okuridashi']).'">'.$okuridashi_name.'</a>';
    }
    else{
        $okuridashi_name = '<span>'.$okuridashi_name.'</span>';
    }
    
}
else{
    $okuridashi_name = '送り出し機関未設定';
}

// Discount Description
if(!empty($okuridata['discount_description'])){
    $discount_description = '<div class="discount_description">
        <p>'.$okuridata['discount_description'].'</p>
    </div>';
}

// badge
if(!empty($okuridata['pref_zenkoku'])){
    $badge .= '<div class="badge_zenkoku badge"><span>全国<br />対応</span></div>';
}
if(!empty($okuridata['kanrihi']) and is_numeric($okuridata['kanrihi']) and $okuridata['kanrihi'] <= 25000){
    $badge .= '<div class="badge_yasui badge"><span>監理費<br />安い</span></div>';
}
if($count <= 3){
    $badge .= '<div class="badge_count'.$count.' badge"><span>価格<br />'.$count.'位</span></div>';
}

// Link
$link_url = null;
$link_url = site_url('?pagetype=estimate_contact&id='.get_the_ID());
if(!empty($_GET['shokushu'])){
    $link_url .= '&shokushu='.$_GET['shokushu'];
}
if(!empty($_GET['pref'])){
    $link_url .= '&pref='.$_GET['pref'];
}


echo '<li class="card">';
echo '<div class="content_area">';
echo '<div class="title_area"><a href="'.$link_url.'">'.$this_title.'</a></div>';
if(!empty($kanrihi)){
    echo '<div class="kanrihi_area"><div class="area_title">監理費</div><div class="area_content">'.$kanrihi.'</div></div>';
}
if(!empty($okuridashi_name)){
    echo '<div class="kanrihi_area"><div class="area_title">送り出し機関</div><div class="area_content">'.$okuridashi_name.'</div></div>';
}
if(!empty($discount_description)){
    echo $discount_description;
}
echo '</div>';
echo '<div class="button_area"><a href="'.$link_url.'" title="'.get_the_ID().'のお見積りでお問合せ">このお見積りでお問合せ</a></div>';
if(!empty($badge)){
    echo '<div class="badge_area">'.$badge.'</div>';
}
echo '</li>';
$count++;