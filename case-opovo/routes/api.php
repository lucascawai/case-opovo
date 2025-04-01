<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\NewsTypeController;
use App\Http\Controllers\NewsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function (Request $request) {
    return $request->headers;
})->withoutMiddleware('auth:api');

Route::post('register', [JWTAuthController::class, 'register']);
Route::post('login', [JWTAuthController::class, 'login']);

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::post('me', [JWTAuthController::class, 'getJournalist']);
    Route::post('logout', [JWTAuthController::class, 'logout']);
});

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::post('type/create', [NewsTypeController::class, 'create']);
    Route::post('type/update/{type_id}', [NewsTypeController::class, 'update']);
    Route::post('type/delete/{type_id}', [NewsTypeController::class, 'delete']);
    Route::get('type/me', [NewsTypeController::class, 'showAll']);
});

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::post('news/create', [NewsController::class, 'create']);
    Route::post('news/update/{news_id}', [NewsController::class, 'update']);
    Route::post('news/delete/{news_id}', [NewsController::class, 'delete']);
    Route::get('news/me', [NewsController::class, 'showAll']);
    Route::get('news/type/{type_id}', [NewsController::class, 'showAllByType']);
});
