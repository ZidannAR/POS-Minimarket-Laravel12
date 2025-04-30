<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;






Route::get('/',[KategoriController::class,'index']);
Route::get('kategori/add', [KategoriController::class, 'create']);
Route::get('kategori/{id}/edit', [KategoriController::class, 'edit']);
Route::put('kategori/{id}/edit', [KategoriController::class, 'update']);
Route::delete('kategori/{id}/delete', [KategoriController::class, 'destroy']);



Route::post('kategori/add',[KategoriController::class,'store']);
// Route::resource('/',ProdukController::class);