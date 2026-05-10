<?php

namespace Nank\Halaman\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    protected $table = 'mt_cms_page_sections';

    protected $fillable = [
        'page_id',
        'block_type',
        'sort_order',
        'payload',
    ];

    protected $casts = [
        'payload' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Halaman::class, 'page_id');
    }
}
