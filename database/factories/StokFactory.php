<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Database\Eloquent\Factories\Factory;

class StokFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = Stok::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$produk = Produk::pluck('id_produk')->toArray();
		return [
			'jumlah_stok' => $this->faker->numberBetween(10, 100),
			'size' => $this->faker->numberBetween(35, 47),
			'warna' => $this->faker->colorName(),
			'id_produk' => $produk[array_rand($produk)],
		];
	}
}
