<?php

namespace Modules\Platform\Settings\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Platform\Core\Entities\CachableModel;

class Currency extends CachableModel
{
    const USD = 96;

    use SoftDeletes;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|max:255',
        'symbol' => 'required|max:255',
    ];
    public $table = 'bap_currency';
    public $fillable = [
        'name',
        'symbol',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'symbol' => 'string'
    ];
}
