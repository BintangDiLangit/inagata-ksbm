<?php

namespace Database\Seeders;

use App\Models\GalleryProduk;
use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\User;
use Database\Factories\StokFactory;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		User::factory()->count(5)->create();
		KategoriProduk::factory()->count(10)->create();
		Produk::factory()->count(25)->create();
		Stok::factory()->count(25)->create();
		GalleryProduk::factory()->count(25)->create();
	}
}
