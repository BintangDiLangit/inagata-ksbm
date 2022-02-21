<?php

namespace Database\Factories;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProdukFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Produk::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$namaProduk = $this->faker->unique()->company();
		$kategoriProduk = KategoriProduk::pluck('id_kategori_produk')->toArray();
		$tags = ['Adidos', 'New Zaman', 'KickOff'];
		return [
			'nama_produk' => $namaProduk,
			'harga' => $this->faker->numberBetween(1000, 1000000),
			'deskripsi_produk' => $this->faker->text(200),
			'tags' => $tags[array_rand($tags)],
			'slug' => Str::slug($namaProduk),
			'id_kategori_produk' => $kategoriProduk[array_rand($kategoriProduk)],
		];
	}
}
