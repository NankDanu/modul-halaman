<?php

namespace Nank\Halaman\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Nank\Halaman\Models\Halaman;
use Nank\Halaman\Services\PageRenderer;

class HalamanController extends Controller
{
    public function index()
    {
        $items = Halaman::query()
            ->latest('id')
            ->paginate(20);

        return view('halaman::halaman.index', compact('items'));
    }

    public function create()
    {
        return view('halaman::halaman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:mt_cms_pages,slug'],
            'status' => ['required', Rule::in(['draft', 'published', 'scheduled', 'archived'])],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:160'],
            'seo_canonical_url' => ['nullable', 'url', 'max:255'],
            'published_at' => ['nullable', 'date'],
        ]);

        Halaman::create($validated);

        return redirect()->route('halaman.index')
            ->with('success', 'Halaman berhasil disimpan.');
    }

    public function show(Halaman $halaman)
    {
        return view('halaman::halaman.show', compact('halaman'));
    }

    public function edit(Halaman $halaman)
    {
        return view('halaman::halaman.edit', compact('halaman'));
    }

    public function update(Request $request, Halaman $halaman)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('mt_cms_pages', 'slug')->ignore($halaman->id)],
            'status' => ['required', Rule::in(['draft', 'published', 'scheduled', 'archived'])],
            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:160'],
            'seo_canonical_url' => ['nullable', 'url', 'max:255'],
            'published_at' => ['nullable', 'date'],
        ]);

        $halaman->update($validated);

        return redirect()->route('halaman.index')
            ->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Halaman $halaman)
    {
        $halaman->delete();

        return redirect()->route('halaman.index')
            ->with('success', 'Halaman berhasil dihapus.');
    }

    public function renderBySlug(string $slug, PageRenderer $renderer)
    {
        $halaman = $renderer->resolvePublishedPageBySlug($slug);

        abort_if($halaman === null, 404);

        return view('halaman::public.show', compact('halaman'));
    }
}
