<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
	use HasFactory;
	protected $table = 'stoks';
	protected $guarded = [];
	protected $primaryKey = 'id_stok';

	public function produk()
	{
		return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
	}
}
