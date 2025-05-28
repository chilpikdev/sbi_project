<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Category::observe(\App\Observers\CategoryObserver::class);
        \App\Models\Product::observe(\App\Observers\ProductObserver::class);
    }
}
