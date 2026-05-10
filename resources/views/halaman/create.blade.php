@extends('base::layouts.app')

@section('page-title', 'Tambah Halaman')

@section('breadcrumb')
    <a href="{{ route('halaman.index') }}">Halaman</a>
@endsection

@section('content')
    <form method="POST" action="{{ route('halaman.store') }}" class="space-y-4 rounded border bg-white p-4">
        @csrf

        @include('halaman::halaman.partials.form', ['halaman' => null])

        <div class="flex items-center gap-2">
            <button type="submit" class="btn-primary">Simpan</button>
            <a href="{{ route('halaman.index') }}" class="text-gray-600">Batal</a>
        </div>
    </form>
@endsection
