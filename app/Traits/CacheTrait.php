<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheTrait
{
    /**
     * Summary of generateKey
     * @return string
     */
    private function generateKey(): string
    {
        $uri = request()->getUri();
        return '_' . app()->getLocale() . '_' . sha1($uri);
    }

    /**
     * Summary of remember
     * @param string $key
     * @param callable $callback
     * @param int|null $ttl
     * @return mixed
     */
    public function remember(string $key, callable $callback, int|null $ttl = null): mixed
    {
        $ttl = $ttl ?? now()->addMonth();
        $cacheKey = $key . ':' . $this->generateKey();
        return Cache::remember($cacheKey, $ttl, $callback);
    }
}
