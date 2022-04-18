<?php namespace Yfktn\SuratMasuk\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class SuratMasuk extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'yfktn.surat_masuk.management' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Yfktn.SuratMasuk', 'main-menu-suratmasuk');
    }
}
