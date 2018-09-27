<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'keywords', 'description', 'demo_url', 'picture', 'tags', 'source', 'size', 'score', 'click',
    ];

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable', 'taggables');
    }
}
