<?php namespace Dubk0ff\UniCrumbs\Classes\Helpers;

use Cms\Classes\Page;
use Dubk0ff\UniCrumbs\Components\UniCrumbs;
use Dubk0ff\UniCrumbs\Models\Crumb;
use October\Rain\Database\Collection;
use October\Rain\Router\Rule;
use Twig;

final class BreadcrumbsConnectionCodeHelper
{
    public static array $prepareData = [
        'parameters_name' => UniCrumbs::PARAMETERS_NAME
    ];

    public static function renderConnectionCode(Collection $crumbs): string
    {
        return Twig::parse(
            StubHelper::getStub('crumbs'),
            self::prepareCrumbs($crumbs)
        );
    }

    public static function prepareCrumbs(Collection $crumbs): array
    {
        $crumbs->each(function (Crumb $crumb) {
            // Search title modifiers
            $titleModifiers = self::getCrumbTitleModifiers($crumb);
            if ($titleModifiers) {
                self::$prepareData['titles'][$crumb->id] = $titleModifiers;
            }

            // Search cms dynamic slugs
            if ($crumb->type === 'cms') {
                $slugs = self::getCmsDynamicSlugs($crumb->type_value);
                if ($slugs) {
                    self::$prepareData['slugs'][$crumb->id] = $slugs;
                }
            }
        });

        return self::$prepareData;
    }

    public static function getCrumbTitleModifiers(Crumb $crumb): array|null
    {
        $modifiersCount = substr_count($crumb->title, '%s');

        return $modifiersCount > 0
            ? array_fill(0, $modifiersCount, 'param_title')
            : null;
    }

    public static function getCmsDynamicSlugs(string $fileName): array|null
    {
        $page = Page::whereFileName($fileName)->first();
        $rule = Rule::fromPattern($page->fileName, $page->url);

        if ($rule->dynamicSegmentCount === 0) {
            return null;
        }

        return collect($rule->segments)
            ->transform(function ($segment) {
                return (str_contains($segment, ':'))
                    ? ltrim($segment, ':')
                    : null;
            })
            ->filter()
            ->toArray();
    }
}
