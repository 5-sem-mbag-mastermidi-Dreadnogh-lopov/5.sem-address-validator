<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\LoginController;
use App\Models\Hero;
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


<<<<<<< HEAD
    Route::prefix('address')->group(function () {
        Route::get("/", [CacheController::class, 'get']);
        Route::put("/{id}", [CacheController::class, 'update']);
        Route::delete("/{id}", [CacheController::class, 'delete']);
    });
=======
    Route::prefix('address')->middleware('checkToken')->group(
        function () {
            Route::get("/", [CacheController::class, 'index']);
            Route::get("/{id}", [CacheController::class, 'get']);
            Route::put("/{id}", [CacheController::class, 'update']);
            Route::delete("/{id}", [CacheController::class, 'delete']);
        }
    );
>>>>>>> 9a6b99dda4d3825e5ee5a478ec1de123b78190e3

    Route::get('/login', [LoginController::class, 'index']);
    Route::get('/test', [LoginController::class, 'test']);
});

Route::get('/alive', function () {
    return response()->json(['alive' => true]);
});