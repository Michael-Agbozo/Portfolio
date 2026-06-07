<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['num', 'category', 'title', 'meta', 'body', 'images', 'tags', 'url', 'sort_order'];

    protected $casts = ['tags' => 'array', 'images' => 'array'];
}
