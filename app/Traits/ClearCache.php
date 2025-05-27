<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

trait ClearCache
{
    /**
     * Clear Function
     */
    public function clear(string $keyPrefix): void
    {
        foreach (Redis::keys("*{$keyPrefix}*") as $cacheValue) {
            Cache::forget(substr($cacheValue, strripos($cacheValue, $keyPrefix)));
        }
    }
}
