<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/produtos', [App\Http\Controllers\ProdutoController::class, 'index']);
Route::match(['get', 'post'], '/produto/{produto}', [App\Http\Controllers\ProdutoController::class, 'show'])->whereNumber('produto');
Route::post('/produto', [App\Http\Controllers\ProdutoController::class, 'store']);
Route::match(['put', 'patch'], '/produto/{produto}', [App\Http\Controllers\ProdutoController::class, 'update'])->whereNumber('produto');
Route::delete('/produto/{produto}', [App\Http\Controllers\ProdutoController::class, 'destroy'])->whereNumber('produto');
