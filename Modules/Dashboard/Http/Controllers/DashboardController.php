<?php

namespace Modules\Dashboard\Http\Controllers;

use Modules\Platform\Core\Http\Controllers\AppBaseController;

/**
 * Class DashboardController
 * @package Modules\Dashboard\Http\Controllers
 */
class DashboardController extends AppBaseController
{

    /**
     * Dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $view = view('dashboard::index');

        return $view;
    }

}
