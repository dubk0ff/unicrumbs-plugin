<?php namespace Dubk0ff\UniCrumbs\Classes\Actions;

use Cms\Classes\Page;
use Dubk0ff\UniCrumbs\Models\Crumb;
use Flash;

final class ImportCrumbsAction
{
    public function run(): void
    {
        $this->importCmsPages();

        Flash::success(trans('dubk0ff.unicrumbs::messages.import_pages_success'));
    }

    protected function importCmsPages(): void
    {
        Page::all()->each(function (Page $page) {
            Crumb::create([
                'name' => $page->title ?? $page->meta_title ?? $page->getFileName(),
                'title' => $page->crumb ?? $page->title ?? $page->getFileName(),
                'type' => 'cms',
                '_cms' => $page->getBaseFileName(),
            ]);
        });
    }
}
