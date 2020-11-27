<?php

namespace Modules\Platform\Settings\Http\Controllers;

use Modules\Platform\Core\Http\Controllers\SettingsCrudController;
use Modules\Platform\Settings\Datatables\CurrencyDatatable;
use Modules\Platform\Settings\Datatables\LanguageDatatable;
use Modules\Platform\Settings\Http\Forms\CurrencyForm;
use Modules\Platform\Settings\Http\Forms\LanguageForm;
use Modules\Platform\Settings\Http\Requests\CurrencySettingsRequest;
use Modules\Platform\Settings\Http\Requests\LanguageSettingsRequest;
use Modules\Platform\Settings\Repositories\CurrencyRepository;
use Modules\Platform\Settings\Repositories\LanguageRepository;

class CurrencyController extends SettingsCrudController
{
    public function __construct()
    {
        parent::__construct();
    }

    protected $datatable = CurrencyDatatable::class;

    protected $formClass = CurrencyForm::class;

    protected $storeRequest = CurrencySettingsRequest::class;

    protected $updateRequest = CurrencySettingsRequest::class;

    protected $repository = CurrencyRepository::class;

    protected $showFields = [
        'details' => [
            'name' => ['type' => 'text'],
            'code' => ['type' => 'text'],
            'symbol' => ['type' => 'text'],
        ]
    ];


    protected $languageFile = 'settings::currency';


    protected $routes = [
        'index' => 'settings.currency.index',
        'create' => 'settings.currency.create',
        'show' => 'settings.currency.show',
        'edit' => 'settings.currency.edit',
        'store' => 'settings.currency.store',
        'destroy' => 'settings.currency.destroy',
        'update' => 'settings.currency.update'
    ];
}
