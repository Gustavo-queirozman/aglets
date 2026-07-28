<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/produtos', [App\Http\Controllers\ProdutoController::class, 'index']);
Route::get('/produto/{id}', [App\Http\Controllers\ProdutoController::class, 'show']);

