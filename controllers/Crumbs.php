<?php namespace Dubk0ff\UniCrumbs\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use BackendMenu;
use Backend\Classes\Controller;
use Dubk0ff\UniCrumbs\Classes\Actions\DeleteCrumbAction;
use Dubk0ff\UniCrumbs\Classes\Actions\ImportCrumbsAction;
use Dubk0ff\UniCrumbs\Classes\Actions\RestoreCrumbAction;
use Dubk0ff\UniCrumbs\Models\Crumb as CrumbModel;
use Illuminate\Http\RedirectResponse;
use October\Rain\Database\Builder;
use Redirect;
use System\Classes\SettingsManager;

class Crumbs extends Controller
{
    public $implement = [
        FormController::class,
        ListController::class,
    ];

    public string $formConfig = 'config_form.yaml';

    public string $listConfig = 'config_list.yaml';

    protected $requiredPermissions = ['dubk0ff.unicrumbs.crumbs'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Dubk0ff.UniCrumbs', 'unicrumbs_crumbs');
    }

    public function isShowImportButton(): bool
    {
        return CrumbModel::count() === 0;
    }

    public function formExtendQuery(Builder $query): void
    {
        $query->withTrashed();
    }

    public function listExtendQuery(Builder $query): void
    {
        $query->withTrashed();
    }

    public function index_onImportPages(): RedirectResponse
    {
        app(ImportCrumbsAction::class)->run();

        return Redirect::refresh();
    }

    public function onDeleteCrumb(int $id): RedirectResponse
    {
        app(DeleteCrumbAction::class)->run($id);

        return Redirect::refresh();
    }

    public function onRestoreCrumb(int $id): RedirectResponse
    {
        app(RestoreCrumbAction::class)->run($id);

        return Redirect::refresh();
    }
}
