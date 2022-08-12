<?php

use App\Http\Controllers\Api\V1\URLController;
use App\Http\Middleware\APIToken;
use App\Http\Middleware\APIVersion;
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

Route::middleware([APIVersion::class, APIToken::class])->group(function () {
    Route::post('/short-urls', [URLController::class, 'getApicreate']);
});
