<?php namespace Dubk0ff\UniCrumbs\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;

/**
 * Class Templates
 * @package Dubk0ff\UniCrumbs\Controllers
 */
class Templates extends Controller
{
    /** @var array */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
    ];

    /** @var string */
    public $formConfig = 'config_form.yaml';

    /** @var string */
    public $listConfig = 'config_list.yaml';

    /** @var array */
    public $requiredPermissions = ['dubk0ff.unicrumbs.access.templates'];

    /**
     * Templates constructor.
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Dubk0ff.UniCrumbs', 'unicrumbs_templates');
    }
}