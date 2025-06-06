<?php

// use App\Http\Controllers\HomeController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

use App\Models\Customer;

use Illuminate\Http\Request;


Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/register', [AuthController::class, 'showRegistrationForm']);
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('kategori/add', [KategoriController::class, 'create']);
Route::get('kategori/{id}/edit', [KategoriController::class, 'edit']);
Route::put('kategori/{id}/edit', [KategoriController::class, 'update']);
Route::delete('kategori/{id}/delete', [KategoriController::class, 'destroy']);

Route::post('kategori/add', [KategoriController::class, 'store']);

Route::get('produk', [ProdukController::class, 'index']);
Route::get('produk/add', [ProdukController::class, 'create']);
Route::post('produk/add', [ProdukController::class, 'store']);
Route::get('produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');

Route::put('produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('produk/{id}/delete', [ProdukController::class, 'destroy']);

Route::get('kasir', [KasirController::class, 'index'])->name('kasir.index');

Route::post('cart/add', [KasirController::class, 'store'])->name('cart.add');
Route::post('cart/min/{id}', [KasirController::class, 'kurang'])->name('cart.min');
Route::post('cart/tambah/{id}', [KasirController::class, 'tambah'])->name('cart.tambah');
Route::delete('cart/destroy', [KasirController::class, 'destroy'])->name('cart.destroy');

Route::post('kasir/scan-barcode', [KasirController::class, 'scanBarcode'])->name('barcode.search');

Route::get('/', [DashboardController::class, 'index']);


// Route::get('kasir',[KasirController::class,'']);

Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('kategori/add', [KategoriController::class, 'create']);
Route::get('kategori/{id}/edit', [KategoriController::class, 'edit']);
Route::put('kategori/{id}/edit', [KategoriController::class, 'update']);
Route::delete('kategori/{id}/delete', [KategoriController::class, 'destroy']);

Route::post('kategori/add', [KategoriController::class, 'store']);

Route::get('produk', [ProdukController::class, 'index']);
Route::get('produk/add', [ProdukController::class, 'create']);
Route::post('produk/add', [ProdukController::class, 'store']);
Route::get('produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');

Route::put('produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('produk/{id}/delete', [ProdukController::class, 'destroy']);

Route::get('/', [DashboardController::class, 'index']);
Route::middleware(['auth', 'role:admin'])->group(function () {
});

// Kasir Routes
Route::middleware(['auth', 'role:kasir'])->group(function () {
});
Route::get('kasir', [KasirController::class, 'index'])->name('kasir.index');

Route::post('cart/add', [KasirController::class, 'store'])->name('cart.add');
Route::post('cart/min/{id}', [KasirController::class, 'kurang'])->name('cart.min');
Route::post('cart/tambah/{id}', [KasirController::class, 'tambah'])->name('cart.tambah');
Route::delete('cart/destroy', [KasirController::class, 'destroy'])->name('cart.destroy');

Route::resource('member', 'App\Http\Controllers\MemberController');

Route::get('/check-member', function (Request $request) {
    $member = Customer::where('no_hp', $request->phone)
        ->where('status_member', true)
        ->first();

    return response()->json([
        'is_member' => !!$member,
        'member_data' => $member
    ]);
});
Route::post('/checkout', [TransactionController::class, 'checkout'])->name('cart.checkout');




Route::post('/checkout', [TransactionController::class, 'checkout'])->name('cart.checkout');



Route::resource('member', 'App\Http\Controllers\MemberController');
Route::resource('user', 'App\Http\Controllers\UserController');

Route::get('/check-member', function (Request $request) {
    $member = Customer::where('no_hp', $request->phone)
        ->where('status_member', true)
        ->first();

    return response()->json([
        'is_member' => !!$member,
        'member_data' => $member
    ]);
});
// Route::resource('/',ProdukController::class);