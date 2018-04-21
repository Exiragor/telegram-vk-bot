<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('telegram')->group(function () {
    Route::post('hook/' . env("TELEGRAM_TOKEN"), 'Api\TelegramController@hookInfo');
});

Route::prefix('vk')->group(function () {
//    Route::get('authback', '');
    Route::get('auth', 'Api\VkController@');
});