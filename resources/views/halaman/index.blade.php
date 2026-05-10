@extends('base::layouts.app')

@section('page-title', 'Halaman')

@section('breadcrumb')
    <a href="{{ route('halaman.index') }}">Halaman</a>
@endsection

@section('header-actions')
    <a href="{{ route('halaman.create') }}" class="btn-primary">
        + Tambah Halaman
    </a>
@endsection

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 p-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded border bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                <tr>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Publish At</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                @forelse ($items as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->title }}</td>
                        <td class="px-4 py-3">/{{ $item->slug }}</td>
                        <td class="px-4 py-3">{{ ucfirst($item->status) }}</td>
                        <td class="px-4 py-3">{{ optional($item->published_at)->format('d M Y H:i') ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a class="text-blue-600 hover:text-blue-800" href="{{ route('halaman.show', $item) }}">Lihat</a>
                                <a class="text-amber-600 hover:text-amber-800" href="{{ route('halaman.edit', $item) }}">Edit</a>
                                <form method="POST" action="{{ route('halaman.destroy', $item) }}" onsubmit="return confirm('Hapus halaman ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                            Belum ada data halaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>
@endsection
