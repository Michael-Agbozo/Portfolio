<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['num', 'category', 'feature_image', 'title', 'meta', 'body', 'images', 'tags', 'url', 'sort_order'];

    protected $casts = ['tags' => 'array', 'images' => 'array'];
}
