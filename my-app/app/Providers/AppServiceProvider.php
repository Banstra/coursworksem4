<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// app/Providers/AppServiceProvider.php
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive(); // или useBootstrapFour() для BS4
    }


}
