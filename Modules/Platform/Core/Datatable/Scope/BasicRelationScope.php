<?php

namespace Modules\Platform\Core\Datatable\Scope;

use Modules\Platform\Core\Interfaces\CrudRelatedScope;
use Yajra\DataTables\Contracts\DataTableScope;

/**
 * Class BasicRelationScope
 * @package Modules\Platform\Core\Datatable\Scope
 */
class BasicRelationScope implements DataTableScope, CrudRelatedScope
{
    private $relation;

    public function relation($relation)
    {
        $this->relation = $relation;
    }

    public function apply($query)
    {
        $query->whereIn('id', $this->relation->pluck('id')->toArray());
    }
}
