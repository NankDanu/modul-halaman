<?php

use Illuminate\Support\Facades\Route;
use Org\Halaman\Http\Controllers\HalamanController;
use Org\Halaman\Http\Controllers\PageBlockController;

Route::middleware(['web', 'auth'])
    ->prefix((string) config('halaman.routes.admin_prefix', 'halaman'))
    ->name('halaman.')
    ->group(function (): void {
        Route::get('/', [HalamanController::class, 'index'])->name('index');
        Route::get('/create', [HalamanController::class, 'create'])->name('create');
        Route::post('/', [HalamanController::class, 'store'])->name('store');
        Route::get('/{halaman}', [HalamanController::class, 'show'])->name('show');
        Route::get('/{halaman}/edit', [HalamanController::class, 'edit'])->name('edit');
        Route::put('/{halaman}', [HalamanController::class, 'update'])->name('update');
        Route::delete('/{halaman}', [HalamanController::class, 'destroy'])->name('destroy');

        Route::get('/blocks/types', [PageBlockController::class, 'listBlockTypes'])->name('blocks.types');
        Route::post('/{halaman}/blocks', [PageBlockController::class, 'addBlock'])->name('blocks.store');
        Route::put('/{halaman}/blocks/{section}', [PageBlockController::class, 'updateBlock'])->name('blocks.update');
        Route::delete('/{halaman}/blocks/{section}', [PageBlockController::class, 'deleteBlock'])->name('blocks.destroy');
        Route::post('/{halaman}/blocks/reorder', [PageBlockController::class, 'reorderBlocks'])->name('blocks.reorder');
    });

if ((bool) config('halaman.public.enabled', true)) {
    Route::middleware(['web'])
        ->get('/{slug}', [HalamanController::class, 'renderBySlug'])
        ->where('slug', '^(?!halaman|admin|login|logout|register)[a-z0-9\-]+$')
        ->name('halaman.public.show');
}
