<?php

return [
    'name' => 'Универсальный менеджер крошек',
    'description' => 'Настройка и управление крошками на страницах сайта.',
    'tab' => 'UniCrumbs',
    'access' => [
        'crumbs' => 'Управление крошками',
        'templates' => 'Управление шаблонами',
        'settings' => 'Управление настройками'
    ],
    'settings' => [
        'category' => 'UniCrumbs',
        'crumbs' => [
            'label' => 'Крошки',
            'description' => 'Раздел управления крошками.'
        ],
        'templates' => [
            'label' => 'Шаблоны',
            'description' => 'Раздел управления шаблонами отображения.'
        ],
        'settings' => [
            'label' => 'Настройки',
            'description' => 'Настройки менеджера крошек.'
        ]
    ],
    'types' => [
        'static'        => 'Статические',
        'static_plus'   => 'Статические +',
        'cms'           => 'CMS'
    ],
    'exceptions' => [
        'parameters_not_found' => 'Переменная `%s` не задана, или задана некорректно!',
        'unsupported_crumb_type' => 'Ошибка! Не поддерживаемый тип крошек.',
        'stub_not_found' => 'Файл заглушки с ключем `%s` не найден!'
    ]
];