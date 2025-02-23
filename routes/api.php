<?php

use App\Http\Controllers\UssdController;
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

Route::name('api.')->group(function () {
    Route::post('/transact', [UssdController::class, 'handleUssd'])->name('handle-ussd-transaction');
    Route::post('/register', [UssdController::class, 'register'])->name('handle-ussd-registration');
});
