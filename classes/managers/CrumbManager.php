<?php namespace Dubk0ff\UniCrumbs\Classes\Managers;

use Cms\Classes\Page;
use Dubk0ff\UniCrumbs\Classes\Helpers\BaseHelper;
use Dubk0ff\UniCrumbs\Components\UniCrumbs;
use Dubk0ff\UniCrumbs\Models\Crumb as CrumbModel;
use October\Rain\Exception\ExceptionBase;

/**
 * Class CrumbManager
 * @package Dubk0ff\UniCrumbs\Classes\Managers
 */
class CrumbManager
{
    /** @var string */
    const PARAM_TITLE = 'param_title';

    /** @var string */
    const DEFAULT_SLUG = 'your_url_slug';

    /** @var string */
    const DEFAULT_CRUMB = 'Not found crumb title!';

    /** @var CrumbModel */
    protected $crumbModel;

    /**
     * CrumbManager constructor.
     * @param CrumbModel $crumbModel
     */
    public function __construct(CrumbModel $crumbModel)
    {
        $this->crumbModel = $crumbModel;
    }

    /**
     * @return string
     */
    public function getConnectionCode()
    {
        $data = [
            'parameters_name' => UniCrumbs::PARAMETERS_NAME,
            'id' => $this->crumbModel->id,
            'titles' => $this->getTitlesFromCmsPages(),
            'slugs' => $this->getSlugsFromCmsPages()
        ];

        return (new StubManager('crumbs'))->getRenderedStubContent($data);
    }

    /**
     * @return \October\Rain\Database\Collection
     */
    public function getListOfCrumbs()
    {
        return $this->crumbModel->getParentsAndSelf();
    }

    /**
     * @return bool
     */
    public static function isShowImportButton()
    {
        return !(bool) CrumbModel::count();
    }

    /**
    * @return void
    */
    public static function importCmsPages()
    {
        Page::all()->each(function ($page) {
            CrumbModel::create([
                'name'  => $page->title ?? $page->meta_title ?? $page->fileName,
                'type'  => 'cms',
                'page'  => $page->baseFileName
            ]);
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getTitlesFromCmsPages()
    {
        return $this
            ->getListOfCrumbs()
            ->pluck('page', 'id')
            ->filter()
            ->transform(function ($page) {
                return $this->getTitleInPage($page);
            })
            ->filter();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getSlugsFromCmsPages()
    {
        return $this
            ->getListOfCrumbs()
            ->pluck('page', 'id')
            ->filter()
            ->transform(function ($page) {
                return $this->getSlugsInPage($page);
            })
            ->filter(function ($item) {
                return $item->count() > 0;
            });
    }

    /**
     * @param string $fileName
     * @return mixed
     */
    protected function getTitleInPage(string $fileName)
    {
        $page = BaseHelper::getPageByFileName($fileName);

        if (is_null($page->crumb)) {
            return self::DEFAULT_CRUMB;
        }

        if ($specifiersСount = substr_count($page->crumb, '%s')) {
            return array_fill(0, $specifiersСount, self::PARAM_TITLE);
        }

        return null;
    }

    /**
     * @param string $fileName
     * @return \Illuminate\Support\Collection
     */
    protected function getSlugsInPage(string $fileName)
    {
        $page = BaseHelper::getPageByFileName($fileName);
        $rule = BaseHelper::getRuleFromPage($page);

        return collect($rule->segments)
            ->transform(function ($segment) {
                return (strpos($segment, ':') !== false)
                    ? ltrim($segment, ':')
                    : null;
            })
            ->filter()
            ->flip()
            ->transform(function () {
                return self::DEFAULT_SLUG;
            });
    }

    /**
     * @return \October\Rain\Database\Collection
     */
    public function getBaseCrumbsList()
    {
        return $this->getListOfCrumbs()->mapWithKeys(function (CrumbModel $crumb) {
            switch ($crumb->type) {
                case 'static':
                    $item = [
                        'title' => $crumb->title,
                        'type' => 'link',
                        'value' => $crumb->link
                    ];
                    break;

                case 'static_plus':
                    $item = [
                        'title' => $crumb->title,
                        'type' => 'segment',
                        'value' => $crumb->segment
                    ];
                    break;

                case 'cms':
                    $item = [
                        'title' => BaseHelper::getPageByFileName($crumb->page)->crumb ?? self::DEFAULT_CRUMB,
                        'type' => 'page',
                        'value' => $crumb->page
                    ];
                    break;

                default:
                    throw new ExceptionBase(trans('dubk0ff.unicrumbs::plugin.exceptions.unsupported_crumb_type'));
            }

            return [
                $crumb->id => $item
            ];
        });
    }
}