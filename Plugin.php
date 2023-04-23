<?php namespace Dubk0ff\UniCrumbs;

use Backend;
use Dubk0ff\UniCrumbs\Classes\Events\ClearCacheEvent;
use Dubk0ff\UniCrumbs\Components\UniCrumbs;
use Event;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails(): array
    {
        return [
            'name' => 'dubk0ff.unicrumbs::plugin.name',
            'description' => 'dubk0ff.unicrumbs::plugin.description',
            'author' => 'Dubk0ff',
            'icon' => 'icon-link',
            'iconSvg' => 'plugins/dubk0ff/unicrumbs/assets/images/unicrumbs-icon.svg',
            'homepage' => 'https://github.com/dubk0ff/unicrumbs-plugin'
        ];
    }

    public function register(): void
    {
        Event::listen('cms.template.save', ClearCacheEvent::class);
    }

    public function registerComponents(): array
    {
        return [
            UniCrumbs::class => 'unicrumbs',
        ];
    }

    public function registerPermissions(): array
    {
        return [
            'dubk0ff.unicrumbs.crumbs' => [
                'tab' => 'dubk0ff.unicrumbs::plugin.tab',
                'label' => 'dubk0ff.unicrumbs::plugin.permissions.crumbs'
            ],
            'dubk0ff.unicrumbs.templates' => [
                'tab' => 'dubk0ff.unicrumbs::plugin.tab',
                'label' => 'dubk0ff.unicrumbs::plugin.permissions.templates'
            ]
        ];
    }

    public function registerSettings(): array
    {
        return [
            'unicrumbs_crumbs' => [
                'label' => 'dubk0ff.unicrumbs::plugin.settings.crumbs.label',
                'description' => 'dubk0ff.unicrumbs::plugin.settings.crumbs.description',
                'category' => 'dubk0ff.unicrumbs::plugin.tab',
                'icon' => 'icon-link',
                'url' => Backend::url('dubk0ff/unicrumbs/crumbs'),
                'permissions' => ['dubk0ff.unicrumbs.crumbs'],
                'order' => 500,
            ],
            'unicrumbs_templates' => [
                'label' => 'dubk0ff.unicrumbs::plugin.settings.templates.label',
                'description' => 'dubk0ff.unicrumbs::plugin.settings.templates.description',
                'category' => 'dubk0ff.unicrumbs::plugin.tab',
                'icon' => 'icon-files-o',
                'url' => Backend::url('dubk0ff/unicrumbs/templates'),
                'permissions' => ['dubk0ff.unicrumbs.templates'],
                'order' => 600,
            ]
        ];
    }
}
