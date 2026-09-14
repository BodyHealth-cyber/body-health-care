<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $stylePath = public_path('css/style.css');
        $scriptPath = public_path('js/main.js');

        View::share('styleVersion', file_exists($stylePath) ? (string) filemtime($stylePath) : '1');
        View::share('mainJsVersion', file_exists($scriptPath) ? (string) filemtime($scriptPath) : '1');
    }
}
