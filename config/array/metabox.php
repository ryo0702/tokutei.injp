<?php if (!defined('ABSPATH')) {
    die;
}

require locate_template('/config/array/metabox/estimates.php');
require locate_template('/config/array/metabox/okuridashi.php');
require locate_template('/config/array/metabox/inquiries.php');

$array_metabox = array(
    $array_metabox_estimates,
    $array_metabox_okuridashi,
    $array_metabox_inquiries,
);