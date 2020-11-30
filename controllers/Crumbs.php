<?php namespace Dubk0ff\UniCrumbs\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Dubk0ff\UniCrumbs\Classes\Managers\CrumbManager;
use Dubk0ff\UniCrumbs\Models\Crumb;
use Dubk0ff\UniCrumbs\Models\Crumb as CrumbModel;
use Flash;
use System\Classes\SettingsManager;
use Redirect;

/**
 * Class Crumbs
 * @package Dubk0ff\UniCrumbs\Controllers
 */
class Crumbs extends Controller
{
    /** @var array */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\ReorderController::class
    ];

    /** @var string */
    public $formConfig = 'config_form.yaml';

    /** @var string */
    public $listConfig = 'config_list.yaml';

    /** @var string */
    public $reorderConfig = 'config_reorder.yaml';

    /** @var array */
    public $requiredPermissions = ['dubk0ff.unicrumbs.access.crumbs'];

    /**
     * Crumbs constructor.
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Dubk0ff.UniCrumbs', 'unicrumbs_crumbs');
    }

    /**
    * @return void
    */
    public function index()
    {
        $this->params['isShowImportButton'] = CrumbManager::isShowImportButton();
        $this->addJs('/plugins/dubk0ff/unicrumbs/assets/js/bulk-actions.js');
        $this->asExtension('ListController')->index();
    }

    /***** EXTENDS *****/

    /**
     * @param $query
     */
    public function formExtendQuery($query)
    {
        $query->withTrashed();
    }

    /**
     * @param $query
     */
    public function listExtendQuery($query)
    {
        $query->withTrashed();
    }

    /**
     * @param $query
     */
    public function reorderExtendQuery($query)
    {
        $query->withTrashed();
    }

    /***** AJAX REQUESTS *****/

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index_onImportPages()
    {
        CrumbManager::importCmsPages();
        Flash::success(trans('dubk0ff.unicrumbs::controllers.messages.import_pages_success'));

        return Redirect::refresh();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index_onBulkAction()
    {
        if (
            ($bulkAction = request()->post('action'))
            && ($checkedIds = request()->post('checked'))
            && is_array($checkedIds)
            && count($checkedIds)
        ) {
            foreach ($checkedIds as $id) {
                if (!$crumb = CrumbModel::withTrashed()->whereId($id)->first()) {
                    continue;
                }

                switch ($bulkAction) {
                    case 'soft-delete':
                        $crumb->delete();
                        break;

                    case 'restore':
                        $crumb->restore();
                        break;

                    case 'delete':
                        $crumb->forceDelete();
                        break;
                }
            }
            Flash::success(trans('dubk0ff.unicrumbs::controllers.messages.bulk_action_success'));
        } else {
            Flash::error(trans('dubk0ff.unicrumbs::controllers.messages.bulk_action_error'));
        }

        return Redirect::refresh();
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function onDeleteCrumb(int $id)
    {
        CrumbModel::whereId($id)->firstOrFail()->delete();
        Flash::success(trans('dubk0ff.unicrumbs::controllers.messages.delete_success'));

        return Redirect::refresh();
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function onRestoreCrumb(int $id)
    {
        CrumbModel::withTrashed()->whereId($id)->firstOrFail()->restore();
        Flash::success(trans('dubk0ff.unicrumbs::controllers.messages.restore_success'));

        return Redirect::refresh();
    }
}