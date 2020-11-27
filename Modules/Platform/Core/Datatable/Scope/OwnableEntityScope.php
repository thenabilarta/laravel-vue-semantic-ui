<?php

namespace Modules\Platform\Core\Datatable\Scope;

use Modules\Platform\User\Entities\Group;
use Modules\Platform\User\Entities\User;
use Nwidart\Modules\Facades\Module;
use Yajra\DataTables\Contracts\DataTableScope;

/**
 * Class OwnableEntityScope
 * @package Modules\Platform\Core\Datatable\Scope
 */
class OwnableEntityScope implements DataTableScope
{
    private $user;

    private $moduleName;

    public function __construct(User $user, $moduleName)
    {
        $this->user = $user;
        $this->moduleName = $moduleName;
    }

    public function apply($query)
    {
        $user = \Auth::user();

        $module = Module::get($this->moduleName);
        $privateAccess = config($module->getLowerName() . '.entity_private_access');

        // Module has private access - scope records
        if ($privateAccess) {
            $query->where(function ($query) use ($user) {
                $query->where(function ($query) use ($user) {
                    $query->where('owned_by_type', Group::class)->whereIn('owned_by_id', $user->groups()->pluck('id')->toArray());
                })
                ->orWhere(function ($query) use ($user) {
                    $query->where('owned_by_type', User::class)->where('owned_by_id', '=', $user->id);
                })
                ->orWhere(function ($query) {
                    $query->where('owned_by_type', '=', null);
                });
            });
        }

        return $query;
    }
}
