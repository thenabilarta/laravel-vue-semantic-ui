<?php

namespace Modules\Platform\User\Events;

use Modules\Platform\User\Entities\User;

/**
 * Class UserEvent
 * @package Modules\Platform\User\Events
 */
class UserEvent
{

    /**
     * @param User $user
     */
    public function saving(User $user)
    {
        $fullName = $user->first_name . ' ' . $user->last_name;
        $user->name = $fullName;
    }

    /**
     * @param User $user
     */
    public function saved(User $user)
    {
        \Cache::forget('filter_dropdown_users');
    }

    /**
     * @param User $user
     */
    public function updated(User $user)
    {
        \Cache::forget('filter_dropdown_users');
    }
}
