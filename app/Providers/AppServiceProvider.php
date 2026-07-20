<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Safe default for older MySQL versions.
        Schema::defaultStringLength(191);

        // Arabic date formatting across the app.
        Carbon::setLocale('ar');
    }
}
