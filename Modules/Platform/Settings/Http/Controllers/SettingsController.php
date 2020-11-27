<?php

namespace Modules\Platform\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Krucas\Settings\Facades\Settings;
use Modules\Platform\Core\Http\Controllers\AppBaseController;

class SettingsController extends AppBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('settings::index');
    }
}
