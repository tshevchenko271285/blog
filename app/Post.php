<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['slug', 'title', 'description', 'thumbnail_id'];

    public function thumbnail() {
        return $this->hasOne('App\Attachment', 'id', 'thumbnail_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
