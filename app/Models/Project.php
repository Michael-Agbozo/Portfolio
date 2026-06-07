<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = ['num', 'category', 'feature_image', 'title', 'slug', 'meta', 'body', 'images', 'tags', 'url', 'active'];

    protected $casts = ['tags' => 'array', 'images' => 'array', 'active' => 'boolean'];

    /**
     * Use the slug (e.g. "emefs-foods") instead of the numeric id when
     * Laravel resolves {project} from the URL — keeps links readable.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
