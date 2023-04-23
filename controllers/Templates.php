<?php namespace Dubk0ff\UniCrumbs\Controllers;

use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;

class Templates extends Controller
{
    public $implement = [
        FormController::class,
        ListController::class,
    ];

    public string $formConfig = 'config_form.yaml';

    public string $listConfig = 'config_list.yaml';

    protected $requiredPermissions = ['dubk0ff.unicrumbs.templates'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Dubk0ff.UniCrumbs', 'unicrumbs_templates');
    }
}
