<?php

namespace Modules\Platform\Account\Http\Controllers;

//TODO Implement this
use Modules\Platform\Core\Http\Controllers\AppBaseController;

class NotificationsController extends AppBaseController
{

    /**
     * Notification list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(){ // load paginated notifications

        $view = view('account::notifications');

        return $view;
    }

    /**
     * Load more notifications
     */
    public function loadMore(){

    }

    /**
     * Mark notification (read|new)
     */
    public function markNotification(){
        //TODO Implement
    }

    /**
     * Delete notification
     */
    public function deleteNotification(){
        //TODO Implement
    }

}