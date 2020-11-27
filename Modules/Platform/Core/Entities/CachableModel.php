<?php

namespace Modules\Platform\Core\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

/**
 * Cachable Model
 *
 * Class CachableModel
 * @package Modules\Platform\Core\Entities
 */
class CachableModel extends Model
{
    use Cachable;
}
