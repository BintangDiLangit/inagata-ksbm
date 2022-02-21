<?php

use App\Http\Controllers\CustomAuthController as CAC;
use App\Http\Controllers\ProdukController as PC;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriProdukController as KP;
use App\Http\Controllers\TransaksiController as TC;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::prefix('admin')->group(function () {

	Route::middleware(['auth:sanctum', 'verified'])->group(function () {
		Route::post('/logout', [CAC::class, 'logout']);
		Route::resource('/kategori', KP::class);
		Route::resource('/produk', PC::class);

		Route::resource('/transaksi', TC::class);
		Route::get('/transaksi/{approve}/approve', [TC::class, 'approve'])->name('approve');
	});
});

Route::middleware(['auth:sanctum', 'verified'])->get('dashboard', function () {
	return view("dashboard");
})->name('dashboard');
