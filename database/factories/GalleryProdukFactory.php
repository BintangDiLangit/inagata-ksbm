<?php

namespace Database\Factories;

use App\Models\GalleryProduk;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryProdukFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = GalleryProduk::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$produk = Produk::pluck('id_produk')->toArray();
		return [
			'url' => $this->faker->imageUrl(100, 100),
			'id_produk' => $produk[array_rand($produk)],
		];
	}
}
