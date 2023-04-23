<?php namespace Dubk0ff\UniCrumbs\Classes\Managers;

use October\Rain\Support\Collection;

final class ParametersManager
{
    protected Collection $parametersCode;

    protected array $parametersRouter;

    public function __construct(array $parametersCode, array $parametersRouter, array $parametersTwig)
    {
        $this->parametersCode = collect($parametersCode)->replaceRecursive($parametersTwig);
        $this->parametersRouter = $parametersRouter;
    }

    public function getTitles(): Collection
    {
        return collect($this->parametersCode->get('titles', []));
    }

    public function getSlugs(): Collection
    {
        return collect($this->parametersCode->get('slugs', []));
    }

    public function getSlugsRouter(): array
    {
        return $this->parametersRouter;
    }

    public function getQueries(): Collection
    {
        return collect($this->parametersCode->get('queries', []));
    }

    public function getInvisibleIds(): array
    {
        return $this->parametersCode->get('invisible', []);
    }
}
