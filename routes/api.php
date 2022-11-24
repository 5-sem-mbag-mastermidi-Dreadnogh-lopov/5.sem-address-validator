<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CacheController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Version control
Route::prefix('v1')->group(function () {

    Route::get('/datawash', [AddressController::class, 'index']);


    Route::prefix('address')->group(function () {
        Route::get("/", [CacheController::class, 'index']);
        Route::get("/{id}", [CacheController::class, 'get']);
        Route::put("/{id}", [CacheController::class, 'update']);
        Route::delete("/{id}", [CacheController::class, 'delete']);
    });

    Route::get('alive', function () {
        return response()->json(['alive' => true]);
    });
});
