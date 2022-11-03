<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function (Request $request) {
    $name = $request->input('name');
    if (empty($name)) {
        return 'noname';
    }
    return response()->json([
        'test' => 123,
        'athhhh' => 'poops',
        'name' => $name,
        'time' => time(),
        'date' => date('Y-m-d H:i:s'),
        'ip' => $request->ip(),
        'user-agent' => $request->userAgent(),
        'server' => $_SERVER,
        'request' => $request->all(),
    ]);
});

//Version control
Route::prefix('v1')->group(function (){
    Route::get('/test', function (Request $request) {
        return "content here";
    });
});
