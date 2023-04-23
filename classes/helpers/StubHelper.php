<?php namespace Dubk0ff\UniCrumbs\Classes\Helpers;

use October\Rain\Filesystem\Filesystem;

final class StubHelper
{
    const STUBS = [
        'crumbs' => 'dubk0ff/unicrumbs/stubs/crumbs.stub',
        'template' => 'dubk0ff/unicrumbs/stubs/template.stub'
    ];

    public static function getStub(string $stubKey): string
    {
        return (new Filesystem)->get(
            plugins_path(self::STUBS[$stubKey])
        );
    }
}
