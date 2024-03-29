<?php namespace Dubk0ff\UniCrumbs\Classes\Events;

use Cms\Classes\EditorExtension;
use Cms\Classes\Page;
use Cms\Classes\Partial;
use Dubk0ff\UniCrumbs\Classes\Helpers\CacheHelper;

final class ClearCacheEvent
{
    public function __invoke(EditorExtension $controller, Page|Partial $templateObject, string $type): void
    {
        if ($templateObject->hasComponent('unicrumbs')) {
            CacheHelper::clearCache(array_get($templateObject->unicrumbs, 'uuid', ''));
        }
    }
}
