<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'keywords', 'description', 'tags', 'source', 'size', 'score', 'click',
    ];

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable', 'taggables');
    }
}
