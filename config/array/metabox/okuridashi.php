<?php
// load array
include get_template_directory().'/array_common.php';


$array_metabox_okuridashi = array(
    'id'        => 'okuridashi',
    'title'     => '送り出し機関',
    'post_type' => 'okuridashi',
    'context'   => 'normal',
    'priority'  => 'high',
    'sections'  => array(
        array(
            'name'   => 'contents',
            'title'  => '送り出し機関',
            'icon'   => 'fas fa-heading',
            'fields' => array(
                array(
                    'id'    => 'okuridashi_eng_name',
                    'type'  => 'text',
                    'title' => '送り出し機関の正式名(英語)',
                ),
                array(
                    'id'    => 'nation',
                    'type'  => 'radio',
                    'options'  => $array_nation_group,
                    'title' => '送り出し国',
                ),
            ),
        ),
    ),
);