<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/check-auth', function () {
    return response()->json(['authenticated' => true]);
});


Route::get('/years/{model}', [ProductionController::class, 'getYears']);
Route::get('/items/{model}', [ProductionController::class, 'getItems']);
