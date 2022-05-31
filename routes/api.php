<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use  App\Http\Controllers\Api\WebsitePostController;
use  App\Http\Controllers\Api\WebsiteController;
use  App\Http\Controllers\Api\SubscriberController;

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

Route::resource('websites.posts', WebsitePostController::class)->only([
    'store',
]);

Route::resource('subscriber', SubscriberController::class)->only([
    'store',
]);

Route::resource('websites', WebsiteController::class)->only([
    'index',
]);
