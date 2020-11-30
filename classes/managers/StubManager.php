<?php namespace Dubk0ff\UniCrumbs\Classes\Managers;

use October\Rain\Exception\ExceptionBase;
use October\Rain\Filesystem\Filesystem;
use Twig;

/**
 * Class StubManager
 * @package Dubk0ff\UniCrumbs\Classes\Managers
 */
class StubManager
{
    /** @var array */
    protected $stubs = [
        'crumbs' => 'dubk0ff/unicrumbs/stubs/crumbs.stub',
        'template' => 'dubk0ff/unicrumbs/stubs/template.stub'
    ];

    /** @var string */
    protected $stubKey;

    /**
     * StubManager constructor.
     * @param string $stubKey
     */
    public function __construct(string $stubKey)
    {
        $this->stubKey = $stubKey;
    }

    /**
     * @param array $data
     * @return string
     */
    public function getRenderedStubContent(array $data = [])
    {
        return Twig::parse(
            $this->getStubContent(),
            $data
        );
    }

    /**
     * @return string
     */
    public function getStubContent()
    {
        $filesystem = new Filesystem;
        $stubPath = $this->getStubPath();

        if (!$filesystem->exists($stubPath)) {
            throw new ExceptionBase(sprintf(trans('dubk0ff.unicrumbs::plugin.exceptions.stub_not_found'), $this->stubKey));
        }

        return $filesystem->get($stubPath);
    }

    /**
     * @return string
     */
    public function getStubPath()
    {
        return plugins_path($this->stubs[$this->stubKey]);
    }
}