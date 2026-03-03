<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\FortifyServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // FortifyServiceProvider を登録
        $this->app->register(FortifyServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
