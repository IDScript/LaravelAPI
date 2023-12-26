<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\APIAuthMiddleware;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware(APIAuthMiddleware::class)->group(function () {
    Route::get('/user/current', [UserController::class, 'get']);
    Route::patch('/user', [UserController::class, 'update']);
    Route::delete('/logout', [UserController::class, 'logout']);
    // contact
    Route::post('/contacts', [ContactController::class, 'store']);
    Route::get('/contacts', [ContactController::class, 'search']);
    Route::get('/contacts/{id}', [ContactController::class, 'show'])
        ->where('id', '[0-9]+');
    Route::put('/contacts/{id}', [ContactController::class, 'update'])
        ->where('id', '[0-9]+');
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])
        ->where('id', '[0-9]+');
    // address
    Route::post('/contact/{idContact}/addresses', [AddressController::class, 'store'])->where('idContact', '[0-9]+');
    Route::get('/contacts/{idContact}/addresses/{idAddress}', [AddressController::class, 'show'])
        ->where('idContact', '[0-9]+')
        ->where('idAddress', '[0-9]+');
});
