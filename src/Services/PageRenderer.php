<?php

namespace Nank\Halaman\Services;

use Nank\Halaman\Models\Halaman;

class PageRenderer
{
    public function resolvePublishedPageBySlug(string $slug): ?Halaman
    {
        return Halaman::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();
    }
}
