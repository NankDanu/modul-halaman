<?php

namespace Org\Halaman\Services;

use Org\Halaman\Models\Halaman;

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
