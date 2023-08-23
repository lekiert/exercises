<?php

use App\Http\Controllers\LessonController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(LessonController::class)->group(function () {
        Route::get('/lessons', 'index');
        Route::post('/lessons', 'store');
        Route::get('/lessons/{id}', 'show');
        Route::put('/lessons/{id}', 'update');
        Route::delete('/lessons/{id}', 'destroy');
    });
});
