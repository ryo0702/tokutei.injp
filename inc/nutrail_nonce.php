<?php
$theme_options        = get_option(WPOPTIONKEY);
$array_config_company = !empty($theme_options['config-company']) ? $theme_options['config-company'] : null;
$array_post           = wp_unslash($_POST);

if (empty(@$array_config_company['company_contact_email'])) {
    wp_send_json_success([
        'message' => esc_html__('Missing email from theme options.', 'nutrail')
    ]);
}

$email_content = [];
$recipient     = @$array_config_company['company_contact_email'];

foreach ($array_post as $key => $field) {
    if ($key == 'agree') {
        continue;
    }
    if (strpos($key, 'input_textarea') !== false) {
        $field_val = sanitize_textarea_field($field[1]);
    } else {
        $field_val = sanitize_text_field($field[1]);
    }
    $email_content[$key] = [
        'text'  => sanitize_text_field($field[0]),
        'value' => $field_val,
    ];
}

// Set the email subject.
$subject = esc_html__('New contact from', 'nutrail');

ob_start();
get_template_part('template_parts/emails/contact', 'form', [
    'content' => $email_content,
]);
$message = ob_get_clean();

add_filter('wp_mail_content_type', function () {
    return 'text/html';
});

// Send the email.
if (wp_mail($recipient, $subject, $message)) {
    wp_send_json_success([
        'message'  => esc_html__('Thank You! Your message has been sent.', 'nutrail'),
        'redirect' => '',
    ]);
} else {
    wp_send_json_error([
        'message' => esc_html__('Oops! Something went wrong and we couldn\'t send your message.', 'nutrail')
    ]);
}
?>