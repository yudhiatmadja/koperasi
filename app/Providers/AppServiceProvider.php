<?php

namespace App\Providers;

use App\Models\SimpananBulanan;
use Illuminate\Support\ServiceProvider;
use App\Observers\SimpananBulananObserver;

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
        SimpananBulanan::observe(SimpananBulananObserver::class);
    }
}
