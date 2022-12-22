<?php
$action = add_query_arg(
    [
        'action' => 'nutrail_ajax_inquery',
        'nonce'  => wp_create_nonce('nutrail_nonce'),
    ],
    admin_url('admin-ajax.php')
);

function nutrail_form_input($contact = null, $key = null)
{
    $return    = $required = $placeholder = $id = $title_label = $title_name = null;
    $form_type = @$contact['contact_list_type'];
    $id = "field-".$key;
    $title_name = "title-".$key;
    $label_id  = 'for="'.esc_attr($id).'"';

    if (@$contact['contact_list_required'] == true) {
        $required = 'required';
    }
    if (@$contact['contact_list_title']) {
        $title_label = esc_html(@$contact['contact_list_title']);
        if (!empty($required)) {
            $title_label .= '<span class="required">'.esc_html__('required', 'nutrail').'</span>';
        }
    }
    if (@$contact['contact_list_description']) {
        $placeholder = $contact['contact_list_description'];
    }

    // $title_label .= '<input type="hidden" name="'.$title_name.'" value="'.esc_attr(@$contact['contact_list_title']).'">';

    if ($form_type == 'input_textarea') {
        $return = '<textarea class="form-control" name="'.$id.'" id="'.$id.'" rows="5" placeholder="'.$placeholder.'" '.$required.'></textarea>';
    } elseif ($form_type == 'input_select') {
        $options = $input_option = null;
        if (!empty(@$contact['contact_list_option'])) {
            $input_option = explode("\n", @$contact['contact_list_option']);
            $input_option = array_map('trim', $input_option);
            $input_option = array_filter($input_option, 'strlen');
            $input_option = array_values($input_option);
            if (is_array(@$input_option)) {
                foreach ($input_option as $opt_label) {
                    $options .= '<option value="'.$opt_label.'">'.$opt_label.'</option>';
                }
            }
            $return = '<select name="'.$id.'" id="'.$id.'">'.$options.'</select>';
        }
    } elseif ($form_type == 'input_radio_yesno') {
        $label_id = '';
        $return   = '<div class="form-check form-check-inline">
                <input type="radio" name="'.$id.'" id="'.$id.'-yes" value="'.esc_html__('Yes', 'nutrail').'" checked>
                <label class="form-check-label" for="'.$id.'-yes">'.esc_html__('Yes', 'nutrail').'</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="'.$id.'" id="'.$id.'-no" value="'.esc_html__('No', 'nutrail').'">
                <label class="form-check-label" for="'.$id.'-no">'.esc_html__('No', 'nutrail').'</label>
            </div>';
    } else {
        $type   = ($form_type == 'input_email') ? 'email' : 'text';
        $return = '<input type="'.$type.'" name="'.$id.'" placeholder="'.$placeholder.'" class="form-control" id="'.$id.'" '.$required.'>';
    }

    if (!empty($return)) {
        return '<div class="row form-group">
            <label '.$label_id.' class="col-md-6 form-label">'.$title_label.'</label><div class="col-md-6">'.$return.'</div>
        </div>';
    }

    return $return;
}