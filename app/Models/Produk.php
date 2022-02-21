<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
	use HasFactory;
	protected $table = 'produks';
	protected $primaryKey = 'id_produk';
	protected $guarded = [];

	public function kategoriProduk()
	{
		return $this->belongsTo(KategoriProduk::class, 'id_kategori_produk', 'id_kategori_produk');
	}

	public function stoks()
	{
		return $this->hasMany(Stok::class, 'id_produk', 'id_produk');
	}
}
