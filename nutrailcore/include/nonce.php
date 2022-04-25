<?php
/*
 * Send email
 * */
if (!function_exists('nutrail_ajax_contact_form')) {
    function nutrail_ajax_contact_form()
    {
        check_ajax_referer('nutrail_nonce', 'nonce');

        // Only process POST reqeusts.
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {

            // Action contact
            include locate_template('inc/nutrail_nonce.php');

        } else {
            wp_send_json_error([
                'message' => esc_html__('There was a problem with your submission, please try again.', 'nutrail'),
            ]);
        }

        wp_send_json_error([
            'message' => esc_html__('Oops! Something went wrong and we couldn\'t send your message.', 'nutrail'),
        ]);
    }
}
add_action('wp_ajax_nutrail_ajax_contact_form', 'nutrail_ajax_contact_form');
add_action('wp_ajax_nopriv_nutrail_ajax_contact_form', 'nutrail_ajax_contact_form');