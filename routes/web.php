<?php

use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

Route::resource('/',ProdukController::class);