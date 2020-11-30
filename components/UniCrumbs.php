<?php namespace Dubk0ff\UniCrumbs\Components;

use Cache;
use Cms\Classes\ComponentBase;
use Dubk0ff\UniCrumbs\Classes\Helpers\BaseHelper;
use Dubk0ff\UniCrumbs\Classes\Managers\CrumbManager;
use Dubk0ff\UniCrumbs\Classes\Managers\JsonLdManager;
use Dubk0ff\UniCrumbs\Models\Crumb as CrumbModel;
use Dubk0ff\UniCrumbs\Models\Settings;
use Dubk0ff\UniCrumbs\Models\Template as TemplateModel;
use October\Rain\Exception\ExceptionBase;
use Twig;

/**
 * Class UniCrumbs
 * @package Dubk0ff\UniCrumbs\Components
 */
class UniCrumbs extends ComponentBase
{
    /** @var string */
    const PARAMETERS_NAME = 'unicrumbs_parameters';

    /** @var array */
    protected $parameters = [];

    /** @var array */
    protected $baseCrumbsList = [];

    /** @var string */
    protected $templateCode = '';

    /** @var array */
    protected  $crumbsList = [];

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'dubk0ff.unicrumbs::components.unicrumbs.name',
            'description' => 'dubk0ff.unicrumbs::components.unicrumbs.description'
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [
            'template' => [
                'title'       => 'dubk0ff.unicrumbs::components.unicrumbs.properties.template.title',
                'description' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.template.description',
                'type'        => 'dropdown',
            ],
            'jsonld' => [
                'title'       => 'dubk0ff.unicrumbs::components.unicrumbs.properties.jsonld.title',
                'description' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.jsonld.description',
                'type'        => 'checkbox',
                'default'     => false
            ],
            'cache' => [
                'title'       => 'dubk0ff.unicrumbs::components.unicrumbs.properties.cache.title',
                'description' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.cache.description',
                'type'        => 'checkbox',
                'default'     => false
            ],
            'key' => [
                'title'       => 'dubk0ff.unicrumbs::components.unicrumbs.properties.key.title',
                'description' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.key.description',
                'type'        => 'string',
                'default'     => md5(str_random(16))
            ]
        ];
    }

    /**
    * @return void
    */
    public function onRender()
    {
        if (!array_key_exists(self::PARAMETERS_NAME, $this->controller->vars)){
            throw new ExceptionBase(sprintf(trans('dubk0ff.unicrumbs::plugin.exceptions.parameters_not_found'), self::PARAMETERS_NAME));
        }

        $this->parameters = $this->controller->vars[self::PARAMETERS_NAME];

        if ($this->property('cache')) {
            $cache = Cache::remember(BaseHelper::getCacheKey($this->property('key')), now()->hours(Settings::instance()->cache_expire), function () {
                return (object) [
                    'templateCode' => $this->getTemplateCode(),
                    'baseCrumbsList' => $this->getBaseCrumbsList()
                ];
            });

            $this->templateCode = $cache->templateCode;
            $this->baseCrumbsList = $cache->baseCrumbsList;
        } else {
            $this->templateCode = $this->getTemplateCode();
            $this->baseCrumbsList = $this->getBaseCrumbsList();
        }

        $this->createCrumbsList();
    }

    /**
     * @return array
     */
    public function getTemplateOptions()
    {
        return TemplateModel::isActive()->get()->lists('title', 'id');
    }

    /**
     * @return string
     */
    protected function getTemplateCode()
    {
        return TemplateModel::isActive()->whereId((int) $this->property('template'))->firstOrFail()->code;
    }

    /**
     * @return string
     */
    public function renderJsonLd()
    {
        return (new JsonLdManager($this->crumbsList))->render();
    }

    /**
     * @return string
     */
    public function renderCrumbsList()
    {
        return Twig::parse($this->templateCode, ['crumbsList' => $this->crumbsList]);
    }

    /**
     * @return \October\Rain\Database\Collection
     */
    protected function getBaseCrumbsList()
    {
        $crumb = CrumbModel::whereId((int) $this->parameters['id'])->firstOrFail();

        return (new CrumbManager($crumb))->getBaseCrumbsList();
    }

    /**
    * @return void
    */
    public function createCrumbsList()
    {
        foreach ($this->baseCrumbsList as $key => $item) {
            if (in_array($key, $this->parameters['invisible'])) {
                continue;
            }

            $this->crumbsList[] = [
                'title' => $this->getCrumbTitle($item['title'], $key),
                'url' => $this->getCrumbUrl($item['type'], $item['value'], $key)
            ];
        }
    }

    /**
     * @param string $title
     * @param int $key
     * @return string
     */
    protected function getCrumbTitle(string $title, int $key)
    {
        if (!array_key_exists($key, $this->parameters['titles'])) {
            return $title;
        }

        return is_array($this->parameters['titles'][$key])
            ? sprintf($title, ...$this->parameters['titles'][$key])
            : $this->parameters['titles'][$key];
    }

    /**
     * @param string $type
     * @param string $value
     * @param string $key
     * @return string
     */
    protected function getCrumbUrl(string $type, string $value, string $key)
    {
        $localeSegment = BaseHelper::getLocaleSegment();

        switch ($type) {
            case 'link':
                $url = url($localeSegment . DIRECTORY_SEPARATOR . $value);
                break;

            case 'segment':
                $url = ($lastCrumb = end($this->crumbsList))
                    ? $lastCrumb['url'] . DIRECTORY_SEPARATOR . $value
                    : url($localeSegment . DIRECTORY_SEPARATOR . $value);
                break;

            case 'page':
                $url = $this->controller->pageUrl($value, $this->parameters['slugs']);
                break;

            default:
                throw new ExceptionBase(trans('dubk0ff.unicrumbs::plugin.exceptions.unsupported_crumb_type'));
        }

        if (
            array_key_exists($key, $this->parameters['slugs'])
            && array_key_exists('queries', $this->parameters['slugs'][$key])
        ) {
            $url .= '?' . http_build_query($this->parameters['slugs'][$key]['queries']);
        }

        return $url;
    }
}