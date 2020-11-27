<?php

namespace Modules\Platform\Core\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @package Modules\Platform\Core\Entities
 */
class Comment extends Model
{
    const UPVOTES_TABLE_NAME = 'bap_comment_user_upvote';

    protected $fillable = [
        'comment',
        'upvote',
        'approved',
        'commentable_id',
        'commentable_type',
        'commented_id',
        'commented_type',
        'parent_id'
    ];

    public $table = 'bap_comment';

    protected $casts = [
        'approved' => 'boolean'
    ];



    public function commentable()
    {
        return $this->morphTo();
    }

    public function commented()
    {
        return $this->morphTo();
    }

    /**
     * @return $this
     */
    public function approve()
    {
        $this->approved = true;
        $this->save();

        return $this;
    }
}
