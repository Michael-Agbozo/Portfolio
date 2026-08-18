<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'num',
        'category',
        'feature_image',
        'title',
        'slug',
        'meta',
        'client_name',
        'project_year',
        'services',
        'tech_stack',
        'challenge',
        'solution',
        'results',
        'testimonial',
        'before_image',
        'after_image',
        'body',
        'images',
        'tags',
        'url',
        'active',
    ];

    protected $casts = [
        'tags' => 'array',
        'services' => 'array',
        'tech_stack' => 'array',
        'images' => 'array',
        'active' => 'boolean',
    ];

    /**
     * Use the slug (e.g. "emefs-foods") instead of the numeric id when
     * Laravel resolves {project} from the URL — keeps links readable.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
