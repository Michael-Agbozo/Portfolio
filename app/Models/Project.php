<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = ['num', 'category', 'feature_image', 'title', 'meta', 'body', 'images', 'tags', 'url', 'active'];

    protected $casts = ['tags' => 'array', 'images' => 'array', 'active' => 'boolean'];
}
