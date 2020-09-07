<?php

namespace App;

use App\Events\OnAttachmentDeleted;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['path'];
    /**
     * @var array
     */
    protected $dispatchesEvents = [
        'deleting' => OnAttachmentDeleted::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Post', 'thumbnail_id', 'id');
    }
}
