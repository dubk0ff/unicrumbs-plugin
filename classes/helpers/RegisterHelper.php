<?php namespace Dubk0ff\UniCrumbs\Classes\Helpers;

use Closure;

/**
 * Class RegisterHelper
 * @package Dubk0ff\UniCrumbs\Classes\Helpers
 */
class RegisterHelper
{
    /**
     * @return Closure
     */
    public static function backendFormExtendFields(): Closure
    {
        return function($widget) {
            if (!$widget->model instanceof \Cms\Classes\Page) {
                return;
            }

            $type = BaseHelper::hasTranslatePlugin()
                ? 'mltext'
                : 'text';

            $widget->addFields(
                [
                    'settings[crumb]' => [
                        'label'   => 'dubk0ff.unicrumbs::cms.crumb.label',
                        'type'    => $type,
                        'tab'     => 'dubk0ff.unicrumbs::plugin.tab',
                        'span'    => 'full',
                        'comment' => 'dubk0ff.unicrumbs::cms.crumb.comment',
                    ],
                ],
                'primary'
            );
        };
    }

    /**
     * @return Closure
     */
    public static function cmsTemplateSave(): Closure
    {
        return function ($controller, $templateObject, $type) {
            if ($unicrumbs = $templateObject->getComponent('unicrumbs')) {
                BaseHelper::clearCache();
            }
        };
    }

    /**
     * @return Closure
     */
    public static function cmsPageExtend(): Closure
    {
        return function($page) {
            if (!$page->propertyExists('translatable')) {
                $page->addDynamicProperty('translatable', []);
            }

            $page->translatable = array_merge($page->translatable, ['crumb']);
        };
    }

    /**
     * @return Closure
     */
    public static function listTypeColumns(): Closure
    {
        return function (string $value) {
            return BaseHelper::transTypeColumns($value);
        };
    }
}