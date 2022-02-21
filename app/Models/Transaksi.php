<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
	use HasFactory;
	protected $table = 'transaksis';
	protected $guarded = [];
	protected $primaryKey = 'id_transaksi';

	public function user()
	{
		return $this->belongsTo(User::class, 'id_user', 'id');
	}

	public function produk()
	{
		return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
	}

	public function detailTransaksi()
	{
		return $this->hasOne(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
	}
}
