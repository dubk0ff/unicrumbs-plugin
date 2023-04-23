<?php namespace Dubk0ff\UniCrumbs\Components;

use Cache;
use Cms\Classes\ComponentBase;
use Dubk0ff\UniCrumbs\Classes\Helpers\CacheHelper;
use Dubk0ff\UniCrumbs\Classes\Helpers\JsonLdHelper;
use Dubk0ff\UniCrumbs\Classes\Managers\BreadcrumbsManager;
use Dubk0ff\UniCrumbs\Classes\Managers\ParametersManager;
use Dubk0ff\UniCrumbs\Models\Crumb as CrumbModel;
use Dubk0ff\UniCrumbs\Models\Template as TemplateModel;
use Ramsey\Uuid\Uuid;
use Twig;

class UniCrumbs extends ComponentBase
{
    const PARAMETERS_NAME = 'unicrumbs_parameters';

    protected string $templateCode;

    public array $crumbsList = [];

    public array $breadcrumbs = [];

    protected array $parametersTwig = [];

    public function componentDetails(): array
    {
        return [
            'name' => 'dubk0ff.unicrumbs::components.unicrumbs.name',
            'description' => 'dubk0ff.unicrumbs::components.unicrumbs.description'
        ];
    }

    public function defineProperties(): array
    {
        return [
            'breadcrumbs' => [
                'title' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.breadcrumbs.title',
                'description' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.breadcrumbs.description',
                'type' => 'dropdown',
            ],
            'template' => [
                'title' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.template.title',
                'description' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.template.description',
                'type' => 'dropdown',
            ],
            'isJsonLd' => [
                'title' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.isJsonLd.title',
                'description' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.isJsonLd.description',
                'type' => 'checkbox',
                'default' => false
            ],
            'isCache' => [
                'title' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.isCache.title',
                'description' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.isCache.description',
                'type' => 'checkbox',
                'default' => false
            ],
            'cacheTime' => [
                'title' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.cacheTime.title',
                'description' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.cacheTime.description',
                'type' => 'string',
                'default' => 24
            ],
            'uuid' => [
                'title' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.uuid.title',
                'description' => 'dubk0ff.unicrumbs::components.unicrumbs.properties.uuid.description',
                'type' => 'string',
                'default' => Uuid::uuid7()
            ]
        ];
    }

    public function getBreadcrumbsOptions(): array
    {
        return CrumbModel::query()
            ->lists('name', 'id');
    }

    public function getTemplateOptions(): array
    {
        return TemplateModel::query()
            ->whereIsActive(true)
            ->lists('title', 'id');
    }

    public function onRender(): void
    {
        $this->getTemplateAndCrumbsData();
        (new BreadcrumbsManager($this))->make();
    }

    protected function getTemplateAndCrumbsData(): void
    {
        if ($this->property('isCache')) {
            [$this->templateCode, $this->crumbsList] = Cache::remember(
                CacheHelper::getCacheKey($this->property('uuid')),
                now()->hours($this->property('cacheTime')),
                function () {
                    return [
                        $this->getTemplateCode(),
                        $this->getCrumbsList()
                    ];
                });
        } else {
            $this->templateCode = $this->getTemplateCode();
            $this->crumbsList = $this->getCrumbsList();
        }
    }

    protected function getTemplateCode(): string
    {
        return TemplateModel::query()
            ->whereIsActive(true)
            ->whereId($this->property('template'))
            ->first()->code;
    }

    protected function getCrumbsList(): array
    {
        return CrumbModel::query()
            ->whereId($this->property('breadcrumbs'))
            ->first()
            ->getParentsAndSelf()
            ->mapWithKeys(function (CrumbModel $crumb) {
                return [
                    $crumb->id => [
                        'title' => $crumb->title,
                        'type' => $crumb->type,
                        'type_value' => $crumb->type_value
                    ]
                ];
            })
            ->toArray();
    }

    public function renderJsonLd(): string
    {
        return JsonLdHelper::render($this->breadcrumbs);
    }

    public function renderBreadcrumbs(): string
    {
        return Twig::parse(
            $this->templateCode,
            ['breadcrumbs' => $this->breadcrumbs]
        );
    }

    public function getParametersManager(): ParametersManager
    {
        return new ParametersManager(
            array_get($this->controller->vars, self::PARAMETERS_NAME, []),
            $this->controller->getRouter()->getParameters(),
            $this->parametersTwig
        );
    }

    public function setParameters(string $key, array $data): void
    {
        $this->parametersTwig[$key] = $data;
    }
}
