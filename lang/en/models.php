<?php

return [
    'crumb' => [
        'id' => 'ID',
        'name' => 'Name',
        'name_placeholder' => 'Main page',
        'parent' => 'Parent',
        'parent_placeholder' => '-- choose a parent crumb --',
        'title' => 'Title',
        'title_placeholder' => 'Home',
        'title_comment' => 'May contain <strong>%s</strong> conversion specifiers that will be replaced with dynamic data.',
        'type' => 'Link type',
        'type_placeholder' => '-- select a link type --',
        'type_options' => [
            'static' => 'Static',
            'segment' => 'Segment',
            'cms' => 'CMS'
        ],
        'type_value' => 'Value',
        'path_placeholder' => 'users',
        'cms_placeholder' => '-- select page --',
        'code' => 'Breadcrumbs connection code',
        'code_comment' => '<span class="text-primary">If there is no dynamic data, the connection code can be ignored.</span>',
        'hint_information' => [
            '<strong>Attention!</strong>',
            'The code for connecting breadcrumbs directly depends on the parent elements.',
            'Therefore, after changing the order of elements, it can change significantly!'
        ]
    ],
    'template' => [
        'id' => 'ID',
        'title' => 'Title',
        'title_placeholder' => 'Main template',
        'code' => 'Template code',
        'is_active' => 'Active'
    ],
    'created_at' => 'Creation',
    'updated_at' => 'Update',
    'deleted_at' => 'Removal'
];
