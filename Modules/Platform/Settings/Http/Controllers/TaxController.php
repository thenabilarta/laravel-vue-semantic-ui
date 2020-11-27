<?php

namespace Modules\Platform\Settings\Http\Controllers;

use Modules\Platform\Core\Http\Controllers\SettingsCrudController;
use Modules\Platform\Settings\Datatables\CurrencyDatatable;
use Modules\Platform\Settings\Datatables\LanguageDatatable;
use Modules\Platform\Settings\Datatables\TaxDatatable;
use Modules\Platform\Settings\Http\Forms\CurrencyForm;
use Modules\Platform\Settings\Http\Forms\LanguageForm;
use Modules\Platform\Settings\Http\Forms\TaxForm;
use Modules\Platform\Settings\Http\Requests\CurrencySettingsRequest;
use Modules\Platform\Settings\Http\Requests\LanguageSettingsRequest;
use Modules\Platform\Settings\Http\Requests\TaxSettingsRequest;
use Modules\Platform\Settings\Repositories\CurrencyRepository;
use Modules\Platform\Settings\Repositories\LanguageRepository;
use Modules\Platform\Settings\Repositories\TaxRepository;

/**
 * Class TaxController
 * @package Modules\Platform\Settings\Http\Controllers
 */
class TaxController extends SettingsCrudController
{
    public function __construct()
    {
        parent::__construct();
    }

    protected $datatable = TaxDatatable::class;

    protected $formClass = TaxForm::class;

    protected $storeRequest = TaxSettingsRequest::class;

    protected $updateRequest = TaxSettingsRequest::class;

    protected $repository = TaxRepository::class;

    protected $showFields = [
        'details' => [
            'name' => ['type' => 'text'],
            'tax_value' => ['type' => 'text'],
        ]
    ];


    protected $languageFile = 'settings::tax';


    protected $routes = [
        'index' => 'settings.tax.index',
        'create' => 'settings.tax.create',
        'show' => 'settings.tax.show',
        'edit' => 'settings.tax.edit',
        'store' => 'settings.tax.store',
        'destroy' => 'settings.tax.destroy',
        'update' => 'settings.tax.update'
    ];
}
