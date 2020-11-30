<?php

return [
    'crumb' => [
        'id' => 'ID',
        'name' => 'Crumb name',
        'parent' => 'Parent',
        'parent_placeholder' => '-- select parent --',
        'type' => 'Data type',
        'type_placeholder' => '-- choose a method of obtaining data --',
        'code' => 'Crumbs list connection code',
        'title' => 'Title',
        'title_placeholder' => 'Home',
        'link' => 'Relative link',
        'segment' => 'Link segment',
        'page' => 'Page',
        'page_placeholder' => '-- select page --',
        'hint_information' => [
            'Attention!',
            'The code for connecting breadcrumbs directly depends on the parent elements.',
            'Therefore, after changing the order of the elements, it can significantly change!'
        ]
    ],
    'template' => [
        'id' => 'ID',
        'title' => 'Title',
        'title_comment' => 'Brief description of the template',
        'code' => 'Template code',
        'is_active' => 'Active template',
        'is_active_on' => 'Yes',
        'is_active_off' => 'No'
    ],
    'settings' => [
        'cache_expire' => 'Cache expire',
        'cache_expire_comment' => 'The number of minutes for which the crumbs and the template for the page will be cached'
    ],
    'deleted_at' => 'Delete',
    'created_at' => 'Create',
    'updated_at' => 'Update'
];