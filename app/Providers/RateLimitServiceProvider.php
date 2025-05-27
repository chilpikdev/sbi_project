<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for(
            name: 'api',
            callback: static fn(Request $request): Limit => Limit::perMinute(
                maxAttempts: 180
            )->by($request->user()?->id ?? $request->ip())
        );
    }
}
