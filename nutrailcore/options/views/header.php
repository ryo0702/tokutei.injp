<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access directly.

$theme   = wp_get_theme(get_template());
$section = (!empty($_GET['section'])) ? sanitize_text_field(wp_unslash($_GET['section'])) : 'about';
$links   = array(
    'manual' => esc_html__('Manual', 'nutrail'),
);

?>
<div class="wpa-welcome wpa-welcome-wrap">
    <h1><?php echo esc_html__('Manual', 'nutrail') ?></h1>
    <p class="wpa-about-text"><?php echo esc_html__('This page explains how to use the WP theme "NUTRAIL".', 'nutrail') ?></p>
