<?php

namespace App\Providers;

require_once __DIR__ . '/../helpers.php';

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 既存の公開パスバインド
        $this->app->bind('path.public', function() {
            return '/home/web13c/best-web.net/public_html/solo';
        });

        Vite::useBuildDirectory('build');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();
    }
}
