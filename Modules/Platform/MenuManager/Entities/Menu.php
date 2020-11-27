<?php

namespace Modules\Platform\MenuManager\Entities;

use Modules\Platform\Core\Entities\CachableModel;

/**
 * Menu Entity
 *
 * Class Menu
 * @package Modules\Platform\MenuManager\Entities
 */
class Menu extends CachableModel
{
    protected $table = 'bap_menu';

    protected $fillable = [
        'url',
        'label',
        'icon',
        'permission',
        'parent_id',
        'section',
        'visibility',
        'dont_translate'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'id' => 'integer',
        'label' => 'string',
        'icon' => 'string',
        'permission' => 'string',
        'parent_id' => 'integer',
        'section' => 'integer'
    ];

    /**
     * Parent menu element
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Children of menu element
     *
     * @return $this
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order_by', 'asc');
    }
}
