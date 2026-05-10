@extends('base::layouts.app')

@section('page-title', 'Edit Halaman')

@section('breadcrumb')
    <a href="{{ route('halaman.index') }}">Halaman</a>
@endsection

@section('content')
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        <!-- Form Utama -->
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('halaman.update', $halaman) }}" class="space-y-4 rounded border bg-white p-4">
                @csrf
                @method('PUT')

                @include('halaman::halaman.partials.form', ['halaman' => $halaman])

                <div class="flex items-center gap-2">
                    <button type="submit" class="btn-primary">Perbarui</button>
                    <a href="{{ route('halaman.index') }}" class="text-gray-600">Batal</a>
                </div>
            </form>
        </div>

        <!-- Block Editor Sidebar -->
        <div class="rounded border bg-white p-4">
            <h3 class="mb-4 text-lg font-semibold">Page Sections</h3>

            <div id="block-list" class="space-y-2">
                @forelse ($halaman->sections()->orderBy('sort_order')->get() as $section)
                    <div class="flex items-center justify-between rounded border bg-gray-50 p-2" data-block-id="{{ $section->id }}">
                        <span class="text-sm">{{ ucfirst(str_replace('_', ' ', $section->block_type)) }}</span>
                        <div class="flex gap-1">
                            <button type="button" class="text-sm text-blue-600 hover:text-blue-800 edit-block" data-section-id="{{ $section->id }}">Edit</button>
                            <button type="button" class="text-sm text-red-600 hover:text-red-800 delete-block" data-section-id="{{ $section->id }}">Hapus</button>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Belum ada sections</p>
                @endforelse
            </div>

            <div class="mt-4 border-t pt-4">
                <button type="button" class="w-full rounded bg-blue-600 px-3 py-2 text-sm text-white hover:bg-blue-700" id="add-block-btn">
                    + Tambah Section
                </button>
            </div>
        </div>
    </div>

    <!-- Block Type Selector Modal (simplified) -->
    <script>
        document.getElementById('add-block-btn').addEventListener('click', function() {
            const blockType = prompt('Pilih tipe block: hero, text, image, gallery, cta, faq, latest_posts, custom_html');
            if (!blockType) return;

            fetch('{{ route('halaman.blocks.store', $halaman) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    block_type: blockType,
                    payload: {},
                }),
            })
            .then(r => r.json())
            .then(data => {
                location.reload();
            });
        });

        document.querySelectorAll('.delete-block').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!confirm('Hapus section ini?')) return;
                fetch('{{ route('halaman.blocks.destroy', [$halaman, ':id']) }}'.replace(':id', this.dataset.sectionId), {
                    method: 'DELETE',
                    headers: {'X-CSRF-Token': '{{ csrf_token() }}'},
                })
                .then(() => location.reload());
            });
        });
    </script>
@endsection
