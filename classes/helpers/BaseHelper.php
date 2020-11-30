<?php namespace Dubk0ff\UniCrumbs\Classes\Helpers;

/**
 * Class BaseHelper
 * @package Dubk0ff\UniCrumbs\Classes\Helpers
 */
class BaseHelper
{
    /**
     * @param string $key
     * @return string
     */
    public static function transTypeColumns(string $key)
    {
        return trans("dubk0ff.unicrumbs::plugin.types.$key");
    }

    /**
     * @param string $fileName
     * @return mixed
     */
    public static function getPageByFileName(string $fileName)
    {
        return \Cms\Classes\Page::whereFileName($fileName)->first();
    }

    /**
     * @param \Cms\Classes\Page $page
     * @return \October\Rain\Router\Rule
     */
    public static function getRuleFromPage(\Cms\Classes\Page $page)
    {
        return new \October\Rain\Router\Rule($page->fileName, $page->url);
    }

    /**
     * @return bool
     */
    public static function hasTranslatePlugin()
    {
        return \System\Classes\PluginManager::instance()->exists('RainLab.Translate');
    }

    /**
     * @return string
     */
    public static function getLocale()
    {
        return self::hasTranslatePlugin()
            ? \RainLab\Translate\Classes\Translator::instance()->getLocale()
            : config('app.locale');
    }

    /**
     * @return string
     */
    public static function getLocaleSegment()
    {
        $locale = self::getLocale();
        $segments = explode('/', request()->getPathInfo());

        return in_array($locale, $segments)
            ? $locale
            : '';
    }

    /**
     * @param string $key
     * @return string
     */
    public static function getCacheKey(string $key)
    {
        return sprintf('dubk0ff.unicrumbs::page.%s.%s', self::getLocale(), $key);
    }

    /**
    * @return void
    */
    public static function clearCache()
    {
        \Cache::flush();
    }
}