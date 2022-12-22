<?php
function admin_inquery()
{
    add_menu_page(
        esc_html__('Inquiries', 'nutrail'),
        esc_html__('Inquiries', 'nutrail'),
        'manage_options',
        'admin_inquery',
        'add_admin_inquery',
        'dashicons-email',
        28
    );
}

add_action('admin_menu', 'admin_inquery');

function add_admin_inquery()
{
    if (empty($_GET['type']) || @$_GET['type'] == 'list') {
        require_once NUTRAIL_CORE_PATH.'include/inquiries/list.php';
    } elseif (@$_GET['type'] == 'view' && !empty(@$_GET['id'])) {
        require_once NUTRAIL_CORE_PATH.'include/inquiries/view.php';
    } elseif (@$_GET['type'] == 'delete' && !empty(@$_GET['id'])) {
        wp_delete_post(@$_GET['id']);
        require_once NUTRAIL_CORE_PATH.'include/inquiries/delete.php';
    }
}

require_once NUTRAIL_CORE_PATH.'include/inquiries/action.php';