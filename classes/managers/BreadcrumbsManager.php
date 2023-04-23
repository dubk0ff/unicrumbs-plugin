<?php namespace Dubk0ff\UniCrumbs\Classes\Managers;

use Cms;
use Dubk0ff\UniCrumbs\Components\UniCrumbs;

final class BreadcrumbsManager
{
    protected UniCrumbs $uniCrumbs;

    protected ParametersManager $parametersManager;

    public function __construct(UniCrumbs $uniCrumbs)
    {
        $this->uniCrumbs = $uniCrumbs;
        $this->parametersManager = $this->uniCrumbs->getParametersManager();
    }

    public function make(): void
    {
        foreach ($this->uniCrumbs->crumbsList as $crumbKey => $crumbData) {
            if (in_array($crumbKey, $this->parametersManager->getInvisibleIds())) {
                continue;
            }

            $this->uniCrumbs->breadcrumbs[] = [
                'title' => $this->getCrumbTitle($crumbKey, $crumbData),
                'url' => $this->getCrumbUrl($crumbKey, $crumbData)
            ];
        }
    }

    protected function getCrumbTitle(string $crumbKey, array $crumbData): string
    {
        $parametersTitle = $this->parametersManager->getTitles();

        if ($parametersTitle->isEmpty() || !$parametersTitle->has($crumbKey)) {
            return $crumbData['title'];
        }

        $replaceTitle = $parametersTitle->get($crumbKey);

        return is_array($replaceTitle)
            ? sprintf($crumbData['title'], ...$replaceTitle)
            : $replaceTitle;
    }

    public function getCrumbUrl(string $crumbKey, array $crumbData): string
    {
        $url = match ($crumbData['type']) {
            'static' => $this->getStaticUrl($crumbData['type_value']),
            'segment' => $this->getSegmentUrl($crumbData['type_value']),
            'cms' => $this->getPageUrl($crumbKey, $crumbData['type_value'])
        };

        return $this->setQueries($crumbKey, $url);
    }

    protected function getStaticUrl(string $typeValue): string
    {
        return Cms::url($typeValue);
    }

    protected function getSegmentUrl(string $typeValue): string
    {
        $lastCrumb = end($this->uniCrumbs->breadcrumbs);

        if (!$lastCrumb) {
            return $this->getStaticUrl($typeValue);
        }

        return collect(parse_url($lastCrumb['url']))
            ->forget('query')
            ->transform(function ($item, $key) {
                return match ($key) {
                    'scheme' => $item . '://',
                    'host', 'path' => $item
                };
            })
            ->push(DIRECTORY_SEPARATOR . $typeValue)
            ->implode('');
    }

    protected function getPageUrl(int $crumbKey, string $typeValue): string
    {
        $parametersSlugs = $this->parametersManager->getSlugs();

        return Cms::pageUrl(
            $typeValue,
            $parametersSlugs->has($crumbKey)
                ? $parametersSlugs->get($crumbKey)
                : $this->parametersManager->getSlugsRouter()
        );
    }

    protected function setQueries(int $crumbKey, string $url): string
    {
        $parametersQueries = $this->parametersManager->getQueries();

        return $parametersQueries->has($crumbKey)
            ? $url . '?' . http_build_query($parametersQueries->get($crumbKey))
            : $url;
    }
}
