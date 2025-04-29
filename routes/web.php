<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;



Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});


Route::get('/',[HomeController::class,'index']);
// Route::resource('/',ProdukController::class);