<?php

namespace Database\Factories;

use App\Models\KategoriProduk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class KategoriProdukFactory extends Factory
{
	/**
	 * The name of the factory's corresponding model.
	 *
	 * @var string
	 */
	protected $model = KategoriProduk::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		$namaKategori = $this->faker->unique()->languageCode;
		return [
			'nama_kategori' => $namaKategori,
			'slug' => Str::slug($namaKategori),
		];
	}
}
