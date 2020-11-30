<?php namespace Dubk0ff\UniCrumbs\Classes\Managers;

/**
 * Class TemplateManager
 * @package Dubk0ff\UniCrumbs\Classes\Managers
 */
class TemplateManager
{
    /**
     * @return string
     */
    public static function getDefaultCode()
    {
        return (new StubManager('template'))->getStubContent();
    }
}