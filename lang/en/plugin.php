<?php

return [
    'name' => 'Universal breadcrumbs.',
    'description' => 'Manage breadcrumbs on site pages.',
    'tab' => 'UniCrumbs',
    'permissions' => [
        'crumbs' => 'Breadcrumb management',
        'templates' => 'Template management'
    ],
    'settings' => [
        'crumbs' => [
            'label' => 'Breadcrumbs',
            'description' => 'Breadcrumb management.'
        ],
        'templates' => [
            'label' => 'Templates',
            'description' => 'Display template management.'
        ]
    ]
];
