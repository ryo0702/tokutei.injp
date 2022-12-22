<?php if (!defined('ABSPATH')) {
    die;
}
// Include Child array
include locate_template('/config/array/options-common-color.php');
// Include Parents array
include locate_template('/config/array/options-common.php');
include locate_template('/config/array/options-company.php');

$array_options = array(
    $config_options_common,
    $config_options_company,
);