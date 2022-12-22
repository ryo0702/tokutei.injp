<?php if (!defined('ABSPATH')) {
    die;
}

require locate_template('/config/array/metabox/hr.php');
require locate_template('/config/array/metabox/okuridashi.php');

$array_metabox = array(
    $array_metabox_hr,
    $array_metabox_inquiries,
);