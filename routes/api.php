<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(
    ['prefix' => 'v1'],
    function () {
        Route::post('/register', [App\Http\Controllers\API\AppUserController::class, 'register']);
        Route::post('/login', [App\Http\Controllers\API\AppUserController::class, 'login']);


        Route::group(
            [
                'middleware' => 'auth.user-api'
            ],
            function () {

                Route::get('/profile', [App\Http\Controllers\API\AppUserController::class, 'profile']);
                Route::post('/child_create', [App\Http\Controllers\API\ChildController::class, 'store']);
                Route::post('/child_delete', [App\Http\Controllers\API\ChildController::class, 'destroy']);
            }
        );
    }
);
