<?php namespace Dubk0ff\UniCrumbs\Classes\Helpers;

use App;
use Cache;

final class CacheHelper
{
    const CACHE_KEY_FORMAT = 'dubk0ff.unicrumbs::page.%s.%s';

    public static function getCacheKey(string $uuid): string
    {
        return sprintf(self::CACHE_KEY_FORMAT, $uuid, App::getLocale());
    }

    public static function clearCache(string $uuid): void
    {
        Cache::forget(self::getCacheKey($uuid));
    }
}
