<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $halaman->seo_title ?: $halaman->title }}</title>
    @if ($halaman->seo_description)
        <meta name="description" content="{{ $halaman->seo_description }}">
    @endif
    @if ($halaman->seo_canonical_url)
        <link rel="canonical" href="{{ $halaman->seo_canonical_url }}">
    @endif
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; line-height: 1.6; color: #333; }
        main { max-width: 1000px; margin: 0 auto; padding: 2rem 1rem; }
        h1, h2, h3, h4, h5, h6 { margin-top: 1.5rem; margin-bottom: 0.75rem; font-weight: 600; }
        p { margin-bottom: 1rem; }
        img { max-width: 100%; height: auto; }
        article { margin-bottom: 2rem; }
    </style>
</head>
<body>
    <main>
        <article>
            <h1>{{ $halaman->title }}</h1>
            @if ($halaman->excerpt)
                <p style="font-size: 1.1rem; color: #666; margin-bottom: 2rem;">{{ $halaman->excerpt }}</p>
            @endif

            @if ($halaman->content)
                <section style="margin-bottom: 2rem;">
                    {!! $halaman->content !!}
                </section>
            @endif
        </article>

        @php
            $blockRenderer = app(\Org\Halaman\Services\BlockRenderer::class);
            $sections = $halaman->sections()->orderBy('sort_order')->get();
        @endphp

        @foreach ($sections as $section)
            <section style="margin-bottom: 2rem;">
                {!! $blockRenderer->renderSection($section) !!}
            </section>
        @endforeach
    </main>
</body>
</html>
