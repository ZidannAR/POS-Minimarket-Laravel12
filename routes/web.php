<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;






Route::get('/',[KategoriController::class,'index']);
Route::get('kategori/add', [KategoriController::class, 'create']);
Route::get('kategori/{id}/edit', [KategoriController::class, 'edit']);
Route::put('kategori/{id}/edit', [KategoriController::class, 'update']);
Route::delete('kategori/{id}/delete', [KategoriController::class, 'destroy']);



Route::post('kategori/add',[KategoriController::class,'store']);

Route::get('produk',[ProdukController::class,'index']);
Route::get('produk/add',[ProdukController::class,'create']);
Route::post('produk/add',[ProdukController::class,'store']);
Route::get('produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');

Route::put('produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('produk/{id}/delete', [ProdukController::class, 'destroy']);

Route::get('kasir',[KasirController::class,'index'])->name('kasir.index');

Route::post('cart/add',[KasirController::class,'store'])->name('cart.add');
Route::post('cart/min/{id}',[KasirController::class,'kurang'])->name('cart.min');
Route::post('cart/tambah/{id}',[KasirController::class,'tambah'])->name('cart.tambah');
Route::delete('cart/destroy', [KasirController::class, 'destroy'])->name('cart.destroy'); 
// Route::get('kasir',[KasirController::class,'']);




Route::post('/checkout', [TransactionController::class, 'checkout'])->name('cart.checkout');

// Route::resource('/',ProdukController::class);