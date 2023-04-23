<?php

return [
    'unicrumbs' => [
        'name' => 'Breadcrumbs',
        'description' => 'Connecting breadcrumbs to the page.',
        'properties' => [
            'breadcrumbs' => [
                'title' => 'Breadcrumbs',
                'description' => 'Select the breadcrumbs to display on the page.',
            ],
            'template' => [
                'title' => 'Template',
                'description' => 'Select a template for displaying breadcrumbs.',
            ],
            'isJsonLd' => [
                'title' => 'JSON-LD',
                'description' => 'Include JSON-LD markup for breadcrumbs.',
            ],
            'isCache' => [
                'title' => 'Caching',
                'description' => 'Breadcrumb and template caching.',
            ],
            'cacheTime' => [
                'title' => 'Caching time',
                'description' => 'Time for which the data will be cached (specified in hours).',
            ],
            'uuid' => [
                'title' => 'UUID',
                'description' => 'Unique data key.',
            ]
        ]
    ]
];
