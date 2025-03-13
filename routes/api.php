<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


route::get("/rida",function (){
    return "reda";
});

Route::post('/register', [AuthController::class,"register"]);
Route::post('/login', [AuthController::class,"login"]);
Route::post('/logout', [AuthController::class,"logout"])->middleware("auth:sanctum");

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/countries', [CountryController::class, 'index']);
    Route::get('/countries/{id}', [CountryController::class, 'show']);
    Route::put('/countries/{id}', [CountryController::class, 'update']);
    Route::delete('/countries/{id}', [CountryController::class, 'destroy']);
    Route::post('/countries', [CountryController::class, 'store']);
});