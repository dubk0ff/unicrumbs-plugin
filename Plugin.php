<?php namespace Dubk0ff\UniCrumbs;

use Backend;
use Cms\Classes\Page;
use Dubk0ff\UniCrumbs\Classes\Helpers\RegisterHelper;
use Event;
use System\Classes\PluginBase;

/**
 * Class Plugin
 * @package Dubk0ff\UniCrumbs
 */
class Plugin extends PluginBase
{
    /**
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'dubk0ff.unicrumbs::plugin.name',
            'description' => 'dubk0ff.unicrumbs::plugin.description',
            'author'      => 'Dubk0ff',
            'icon'        => 'icon-link'
        ];
    }

    /**
     * @return void
     */
    public function register()
    {
        Event::listen('backend.form.extendFields', RegisterHelper::backendFormExtendFields());
        Event::listen('cms.template.save', RegisterHelper::cmsTemplateSave());
        Page::extend(RegisterHelper::cmsPageExtend());
    }

    /**
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Dubk0ff\UniCrumbs\Components\UniCrumbs' => 'unicrumbs',
        ];
    }

    /**
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'dubk0ff.unicrumbs.access.crumbs' => [
                'tab'   => 'dubk0ff.unicrumbs::plugin.tab',
                'label' => 'dubk0ff.unicrumbs::plugin.access.crumbs'
            ],
            'dubk0ff.unicrumbs.access.templates' => [
                'tab'   => 'dubk0ff.unicrumbs::plugin.tab',
                'label' => 'dubk0ff.unicrumbs::plugin.access.templates'
            ],
            'dubk0ff.unicrumbs.access.settings' => [
                'tab'   => 'dubk0ff.unicrumbs::plugin.tab',
                'label' => 'dubk0ff.unicrumbs::plugin.access.settings'
            ]
        ];
    }

    /**
     * @return array
     */
    public function registerSettings()
    {
        return [
            'unicrumbs_crumbs' => [
                'label'       => 'dubk0ff.unicrumbs::plugin.settings.crumbs.label',
                'description' => 'dubk0ff.unicrumbs::plugin.settings.crumbs.description',
                'category'    => 'dubk0ff.unicrumbs::plugin.settings.category',
                'icon'        => 'icon-link',
                'url'         => Backend::url('dubk0ff/unicrumbs/crumbs'),
                'permissions' => ['dubk0ff.unicrumbs.access.crumbs'],
                'order'       => 500,
            ],
            'unicrumbs_templates' => [
                'label'       => 'dubk0ff.unicrumbs::plugin.settings.templates.label',
                'description' => 'dubk0ff.unicrumbs::plugin.settings.templates.description',
                'category'    => 'dubk0ff.unicrumbs::plugin.settings.category',
                'icon'        => 'icon-files-o',
                'url'         => Backend::url('dubk0ff/unicrumbs/templates'),
                'permissions' => ['dubk0ff.unicrumbs.access.templates'],
                'order'       => 600,
            ],
            'unicrumbs_settings' => [
                'label'       => 'dubk0ff.unicrumbs::plugin.settings.settings.label',
                'description' => 'dubk0ff.unicrumbs::plugin.settings.settings.description',
                'category'    => 'dubk0ff.unicrumbs::plugin.settings.category',
                'icon'        => 'icon-cog',
                'class'       => 'Dubk0ff\UniCrumbs\Models\Settings',
                'permissions' => ['dubk0ff.unicrumbs.access.settings'],
                'order'       => 700
            ]
        ];
    }

    /**
     * @return array
     */
    public function registerListColumnTypes()
    {
        return [
            'crumb_type' => RegisterHelper::listTypeColumns()
        ];
    }
}