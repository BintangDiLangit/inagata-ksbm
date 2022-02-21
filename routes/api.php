<?php

use App\Http\Controllers\API\KategoriProdukControllerAPI;
use App\Http\Controllers\API\ProdukControllerAPI;
use App\Http\Controllers\API\UserControllerAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('store/v1')->group(function () {

	Route::post('/register', [UserControllerAPI::class, 'register'])->name('register.api');
	Route::post('/login', [UserControllerAPI::class, 'login'])->name('login.api');

	Route::middleware('auth:sanctum')->group(function () {
		Route::resource('produk', ProdukControllerAPI::class);
		Route::resource('kategori', KategoriProdukControllerAPI::class);
		Route::get('/user', [UserControllerAPI::class, 'fetchUser']);
		Route::post('/user', [UserControllerAPI::class, 'updateProfile']);
		Route::post('/logout', [UserControllerAPI::class, 'logout.api']);
		Route::get('transaksi', [TransaksiControllerAPI::class, 'all']);
		Route::get('/transaksi/{approve}/approve', [TransaksiControllerAPI::class, 'approve']);
		Route::post('checkout', [TransaksiControllerAPI::class, 'checkout']);
	});
});
