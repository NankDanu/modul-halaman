@if ($errors->any())
    <div class="rounded border border-red-200 bg-red-50 p-3 text-red-700">
        <ul class="list-disc pl-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-4 md:grid-cols-2">
    <div class="space-y-1 md:col-span-2">
        <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
        <input id="title" name="title" type="text" value="{{ old('title', $halaman->title ?? '') }}" class="w-full rounded border border-gray-300 px-3 py-2" required>
    </div>

    <div class="space-y-1">
        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $halaman->slug ?? '') }}" class="w-full rounded border border-gray-300 px-3 py-2" required>
    </div>

    <div class="space-y-1">
        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
        <select id="status" name="status" class="w-full rounded border border-gray-300 px-3 py-2" required>
            @foreach (['draft', 'published', 'scheduled', 'archived'] as $status)
                <option value="{{ $status }}" @selected(old('status', $halaman->status ?? 'draft') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="space-y-1 md:col-span-2">
        <label for="excerpt" class="block text-sm font-medium text-gray-700">Ringkasan</label>
        <textarea id="excerpt" name="excerpt" rows="3" class="w-full rounded border border-gray-300 px-3 py-2">{{ old('excerpt', $halaman->excerpt ?? '') }}</textarea>
    </div>

    <div class="space-y-1 md:col-span-2">
        <label for="content" class="block text-sm font-medium text-gray-700">Konten</label>
        <textarea id="content" name="content" rows="10" class="w-full rounded border border-gray-300 px-3 py-2">{{ old('content', $halaman->content ?? '') }}</textarea>
    </div>

    <div class="space-y-1">
        <label for="seo_title" class="block text-sm font-medium text-gray-700">SEO Title</label>
        <input id="seo_title" name="seo_title" type="text" value="{{ old('seo_title', $halaman->seo_title ?? '') }}" class="w-full rounded border border-gray-300 px-3 py-2">
    </div>

    <div class="space-y-1">
        <label for="seo_description" class="block text-sm font-medium text-gray-700">SEO Description</label>
        <input id="seo_description" name="seo_description" type="text" value="{{ old('seo_description', $halaman->seo_description ?? '') }}" class="w-full rounded border border-gray-300 px-3 py-2">
    </div>

    <div class="space-y-1">
        <label for="seo_canonical_url" class="block text-sm font-medium text-gray-700">Canonical URL</label>
        <input id="seo_canonical_url" name="seo_canonical_url" type="url" value="{{ old('seo_canonical_url', $halaman->seo_canonical_url ?? '') }}" class="w-full rounded border border-gray-300 px-3 py-2">
    </div>

    <div class="space-y-1">
        <label for="published_at" class="block text-sm font-medium text-gray-700">Publish At</label>
        <input id="published_at" name="published_at" type="datetime-local" value="{{ old('published_at', optional($halaman->published_at ?? null)->format('Y-m-d\TH:i')) }}" class="w-full rounded border border-gray-300 px-3 py-2">
    </div>
</div>
