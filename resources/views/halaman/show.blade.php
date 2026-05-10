@extends('base::layouts.app')

@section('page-title', $halaman->seo_title ?: $halaman->title)

@section('breadcrumb')
    <a href="{{ route('halaman.index') }}">Halaman</a>
@endsection

@section('header-actions')
    <a href="{{ route('halaman.edit', $halaman) }}" class="btn-primary">Edit Halaman</a>
@endsection

@section('content')
    <article class="space-y-4 rounded border bg-white p-6">
        <header class="space-y-2 border-b pb-4">
            <h1 class="text-2xl font-semibold text-gray-900">{{ $halaman->title }}</h1>
            <p class="text-sm text-gray-500">Slug: /{{ $halaman->slug }} | Status: {{ ucfirst($halaman->status) }}</p>
            @if ($halaman->excerpt)
                <p class="text-gray-700">{{ $halaman->excerpt }}</p>
            @endif
        </header>

        @if ($halaman->content)
            <section class="prose max-w-none">
                {!! $halaman->content !!}
            </section>
        @endif

        @php
            $sections = $halaman->sections()->orderBy('sort_order')->get();
            $blockRenderer = app(\Org\Halaman\Services\BlockRenderer::class);
        @endphp

        @foreach ($sections as $section)
            <section class="border-t pt-4 mt-4">
                {!! $blockRenderer->renderSection($section) !!}
            </section>
        @endforeach
    </article>
@endsection
