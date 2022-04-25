<?php
function nutrail_admin_input($inpts = null){
    $return = null;
    if(!empty($inpts) and is_array(@$inpts)){
        $input_return = $description = $input_other = null;
        if(@$inpts['type'] == 'text'){
            $input_return = '<input type="text" name="'.@$inpts['name'].'" id="'.@$inpts['name'].'" value="" class="regular-text"/>';
        }
        elseif(@$inpts['type'] == 'number'){
            $input_return = '<input type="number" name="'.@$inpts['name'].'" id="'.@$inpts['name'].'" value="" class="regular-text"/>';
        }
        elseif(@$inpts['type'] == 'file'){
            $input_return = '<input type="file" name="'.@$inpts['name'].'" id="'.@$inpts['name'].'" value="" />';
        }
        elseif(@$inpts['type'] == 'select'){
            $options = null;
            // Select
            if(@$inpts['associative'] == true){
                if(@is_array(@$inpts['options'])){
                    foreach (@$inpts['options'] as $opt_key => $opt_val) {
                        $options .= '<option value="'.$opt_key.'">'.$opt_val.'</option>';
                    }
                }
            }
            else{
                if(@is_array(@$inpts['options'])){
                    foreach (@$inpts['options'] as $opt_val) {
                        $options .= '<option value="'.$opt_val.'">'.$opt_val.'</option>';
                    }
                }
            }
            if(@$inpts['select_novalue'] == true){$input_return = '<select id="'.@$inpts['name'].'" name="'.@$inpts['name'].'"><option value="">'.@$inpts['title'].'を選択</option>'.$options.'</select>';}
            else{$input_return = '<select id="'.@$inpts['name'].'" name="'.@$inpts['name'].'">'.$options.'</select>';}
        }
        elseif(@$inpts['type'] == 'check_single'){
            $input_return = '<label for="'.@$inpts['name'].'"><input name="'.@$inpts['name'].'" type="checkbox" id="'.@$inpts['name'].'" value="'.@$inpts['value'].'"/>'.@$inpts['label'].'</label>';
        }
        elseif(@$inpts['type'] == 'hr'){
            $input_other = '<hr />';
        }
        elseif(@$inpts['type'] == 'title'){
            $input_other = '<h3 style="margin:0;padding:0;padding-top:20px;">'.@$inpts['title'].'</h3>';
        }
        // Description
        if(!empty(@$inpts['description'])){
            $description = '<p class="description">'.$inpts['description'].'</p>';
        }
        // Wrap
        if(!empty($input_return)){
            $return = '<tr><th scope="row"><label for="'.@$inpts['name'].'">'.@$inpts['title'].'</label></th>
            <td><div>'.$input_return.'</div>'.$description.'</td></tr>';
        }
        elseif(!empty($input_other)){
            $return = '<tr><td colspan="3" style="margin:0;padding:0;"><div>'.$input_other.'</div>'.$description.'</td></label></tr>';
        }
    }
    return $return;
}

function nutrail_admin_action($inpts = null){

}