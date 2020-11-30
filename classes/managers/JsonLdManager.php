<?php namespace Dubk0ff\UniCrumbs\Classes\Managers;

/**
 * Class JsonLdManager
 * @package Dubk0ff\UniCrumbs\Classes\Managers
 */
class JsonLdManager
{
    /** @var array */
    protected $json = [
        '@context' => 'http://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [],
    ];

    /** @var array */
    protected $crumbsList = [];

    /**
     * JsonLdManager constructor.
     * @param array $crumbsList
     */
    public function __construct(array $crumbsList)
    {
        $this->crumbsList = $crumbsList;
    }

    /**
    * @return void
    */
    protected function createOutputJson()
    {
        foreach ($this->crumbsList as $i => $crumb) {
            $this->json['itemListElement'][] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'item' => [
                    '@id' => $crumb['url'] ?: request()->fullUrl(),
                    'name' => $crumb['title'],
                    'image' => $crumb['image'] ?? null,
                ],
            ];
        }
    }

    /**
     * @return string
     */
    public function render()
    {
        $this->createOutputJson();

        return json_encode($this->json);
    }
}