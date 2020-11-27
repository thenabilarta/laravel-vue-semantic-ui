<?php

namespace Modules\Platform\User\Events;

use Modules\Platform\User\Entities\Group;

/**
 * Class GroupEvent
 * @package Modules\Platform\User\Events
 */
class GroupEvent
{

    /**
     * @param Group $group
     */
    public function saving(Group $group)
    {
    }

    /**
     * @param Group $group
     */
    public function saved(Group $group)
    {
        \Cache::forget('filter_dropdown_groups');
    }

    /**
     * @param Group $group
     */
    public function updated(Group $group)
    {
        \Cache::forget('filter_dropdown_groups');
    }
}
