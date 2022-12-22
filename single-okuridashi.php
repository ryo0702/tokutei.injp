<?php
$thisid = null;
$thisid = get_the_ID();
if(!empty($thisid)){
    wp_redirect( site_url('/?pagetype=okuridashi&id='.$thisid) );exit;
}