<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['num', 'title', 'meta', 'tags', 'url', 'sort_order'];

    protected $casts = ['tags' => 'array'];
}
