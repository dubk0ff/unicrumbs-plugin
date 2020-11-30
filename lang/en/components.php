<?php

return [
    'unicrumbs' => [
        'name' => 'List of crumbs',
        'description' => 'Displays a list of crumbs per page.',
        'properties' => [
            'template' => [
                'title' => 'Template',
                'description' => 'Choose a template to be used for showing the crumbs.',
            ],
            'jsonld' => [
                'title' => 'JSON-LD',
                'description' => 'Include JSON-LD markup for the list of crumbs.',
            ],
            'cache' => [
                'title' => 'Caching',
                'description' => 'Cache template and list of crumbs.',
            ],
            'key' => [
                'title' => 'Key',
                'description' => 'The unique key for the list of crumbs.',
            ]
        ]
    ]
];