<?php

namespace Nank\Halaman\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Halaman extends Model
{
    use SoftDeletes;

    protected $table = 'mt_cms_pages';

    protected $fillable = [
        'title',
        'slug',
        'status',
        'excerpt',
        'content',
        'seo_title',
        'seo_description',
        'seo_canonical_url',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(PageSection::class, 'page_id');
    }
}
