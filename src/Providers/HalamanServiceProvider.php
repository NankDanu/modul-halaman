<?php

namespace Org\Halaman\Providers;

use Illuminate\Support\ServiceProvider;
use Org\Base\Menu\MenuManager;

class HalamanServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/halaman.php',
            'halaman'
        );

        $this->app->singleton(\Org\Halaman\Services\BlockRenderer::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'halaman');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        MenuManager::add([
            'label' => 'Halaman',
            'icon' => 'heroicon-o-document-text',
            'route' => 'halaman.index',
            'permission' => 'halaman.view',
            'order' => 20,
            'active' => ['halaman.*'],
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../resources/views' => resource_path('views/vendor/halaman'),
            ], 'halaman-views');

            $this->publishes([
                __DIR__ . '/../../config/halaman.php' => config_path('halaman.php'),
            ], 'halaman-config');
        }
    }
}
