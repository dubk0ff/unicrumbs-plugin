<?php namespace Dubk0ff\UniCrumbs\Classes\Helpers;

final class JsonLdHelper
{
    protected static array $json = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [],
    ];

    public static function render(array $breadcrumbs): string
    {
        foreach ($breadcrumbs as $i => $crumb) {
            self::$json['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'item' => [
                    '@id' => $crumb['url'],
                    'name' => $crumb['title'],
                    'image' => null
                ]
            ];
        }

        return json_encode(self::$json);
    }
}
