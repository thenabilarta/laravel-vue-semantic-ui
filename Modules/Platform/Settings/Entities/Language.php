<?php

namespace Modules\Platform\Settings\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Platform\Core\Entities\CachableModel;

class Language extends CachableModel
{
    const DEFAULT_LANGUAGE = 'en';

    use SoftDeletes;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'namee' => 'required|max:255',
    ];
    public $table = 'bap_language';
    public $fillable = [
        'name',
        'language_key',
        'is_active'
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
        'language_key' => 'string'
    ];
}
