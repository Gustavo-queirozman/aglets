<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/products', [App\Http\Controllers\ProdutoController::class, 'index']);
Route::match(['get', 'post'], '/product/{product}', [App\Http\Controllers\ProdutoController::class, 'show'])->whereNumber('product');
Route::post('/product', [App\Http\Controllers\ProdutoController::class, 'store']);
Route::match(['put', 'patch'], '/product/{product}', [App\Http\Controllers\ProdutoController::class, 'update'])->whereNumber('product');
Route::delete('/product/{product}', [App\Http\Controllers\ProdutoController::class, 'destroy'])->whereNumber('product');
