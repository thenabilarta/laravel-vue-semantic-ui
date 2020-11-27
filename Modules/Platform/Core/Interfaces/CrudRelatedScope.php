<?php

namespace Modules\Platform\Core\Interfaces;

/**
 * Interface CrudRelatedScope
 * @package Modules\Platform\Core\Interfaces
 */
interface CrudRelatedScope
{

    /**
     * @param $relation
     * @return mixed
     */
    public function relation($relation);
}
