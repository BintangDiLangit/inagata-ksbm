<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
	use HasFactory;
	protected $guarded = [];

	public function transaksis()
	{
		return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id');
	}
}
