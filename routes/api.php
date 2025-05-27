<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['throttle:api']], function () {
    Route::prefix('admin/v1')->group(base_path('routes/admin/api_v1.php'));
});
