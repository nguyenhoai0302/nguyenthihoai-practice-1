<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\PostController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/', function() {
    return response()->json([
        'message' => 'Welcome to the Laravel API'
    ]);
});

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class,'index']);
    Route::get('/{id}', [PostController::class,'show']);
    Route::post('/', [PostController::class,'store']);
    Route::delete('/{id}', [PostController::class,'destroy']);
});

Route::resource('posts', PostController::class);
Route::post('/post',[PostController::class,'store']);

