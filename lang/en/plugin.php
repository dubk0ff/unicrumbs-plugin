<?php

return [
    'name' => 'Universal crumb manager',
    'description' => 'Setting up and managing crumbs on site pages.',
    'tab' => 'UniCrumbs',
    'access' => [
        'crumbs' => 'Crumb management',
        'templates' => 'Managing display templates',
        'settings' => 'Manage plugin settings'
    ],
    'settings' => [
        'category' => 'UniCrumbs',
        'crumbs' => [
            'label' => 'Crumbs',
            'description' => 'Crumbs management section.'
        ],
        'templates' => [
            'label' => 'Templates',
            'description' => 'Section for managing display templates.'
        ],
        'settings' => [
            'label' => 'Settings',
            'description' => 'Crumbs manager settings.'
        ]
    ],
    'types' => [
        'static'        => 'Static',
        'static_plus'   => 'Static +',
        'cms'           => 'CMS'
    ],
    'exceptions' => [
        'parameters_not_found' => 'The variable `%s` is not set, or is set incorrectly!',
        'unsupported_crumb_type' => 'Error! Type of crumbs not supported.',
        'stub_not_found' => 'Stub file with key `%s` not found!'
    ]
];