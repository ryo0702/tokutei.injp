<?php
/*
 * Send email
 * */
if (!function_exists('nutrail_ajax_inquery')) {
    function nutrail_ajax_inquery()
    {
        check_ajax_referer('nutrail_nonce', 'nonce');

        $array_post = $array_contactform = $formname = null;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
            $array_post = wp_unslash($_POST);
            if (!empty(@$_POST['formid']) and is_numeric(@$_POST['formid'])) {
                $template = get_post_meta(@$_POST['formid'], '_wp_page_template', true);

                if ($template == 'templates/template-contact.php') {
                    $array_config_contactform = get_post_meta(@$_POST['formid'], 'page-contactform', true);
                } elseif ($template == 'templates/template-lp.php') {
                    $array_config_contactform = get_post_meta(@$_POST['formid'], 'page-lp', true);
                }
            }

            $insert_postmeta = null;

            if(is_array(@$array_config_contactform['contact_list'])){
                foreach ($array_config_contactform['contact_list'] as $key => $field) {
                    $field_val = $field_label = null;
                    if ($field['contact_list_type'] == 'input_textarea') {
                        $field_val = sanitize_textarea_field(@$_POST['field-'.$key]);
                    } else {
                        $field_val = sanitize_text_field(@$_POST['field-'.$key]);
                    }
                    $field_label = esc_html(@$field['contact_list_title']);
                    $insert_postmeta['content'][] = array(
                        'key'   => 'field-'.@$key,
                        'label' => @$field_label,
                        'value' => $field_val
                    );
                }
            }

            $insert_postmeta['formid']   = @$array_post['formid'];
            $insert_postmeta['formname'] = @$array_post['formname'];

            $insertid = null;
            $my_post  = array(
                'post_title'  => @$array_post['formname'].'-'.@$array_post['formid'].'-'.date('Ymd H:i:s'),
                'post_status' => 'draft',
                'post_author' => 1,
                'post_type'   => 'inquiries',
            );
            $insertid = wp_insert_post($my_post);
            update_post_meta($insertid, 'content', @$insert_postmeta);

            wp_send_json_success([
                'message' => esc_html__('Thank you for sending.The information has been successfully sent.', 'nutrail'),
                'redirect' => site_url('/thank-you'),
            ]);
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
add_action('wp_ajax_nutrail_ajax_inquery', 'nutrail_ajax_inquery');
add_action('wp_ajax_nopriv_nutrail_ajax_inquery', 'nutrail_ajax_inquery');