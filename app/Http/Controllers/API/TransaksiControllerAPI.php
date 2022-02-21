<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiControllerAPI extends Controller
{
	public function index()
	{
		$produks = Produk::all();
		$users = User::all();
		$stoks = Stok::all();
		$listTransaksiMasuk = Transaksi::with('user', 'produk', 'detailTransaksi')->get();

		return response()->json([
			"success" => true,
			"message" => "List Transaksi",
			"data" => [$produks, $stoks, $stoks, $listTransaksiMasuk]
		]);
	}


	public function approve($approve)
	{
		$status = Transaksi::where('id_transaksi', $approve)->get()->first();
		if ($status->status == 'SUKSES') {
			$status->update([
				'status' => 'PENDING'
			]);
			return response()->json([
				"success" => true,
				"message" => "Approve Berhasil Dibatalkan",
				"data" => [$status]
			]);
		} else if ($status->status == 'PENDING') {
			$status->update([
				'status' => 'SUKSES'
			]);
			return response()->json([
				"success" => true,
				"message" => "Transaksi Berhasil Terapprove",
				"data" => [$status]
			]);
		} else {
			return response()->json([
				"success" => false,
				"message" => "Transaksi Gagal",
				"data" => [$status]
			]);
		}
	}

	public function store(Request $request)
	{
		$request->validate([
			'user' => ['required'],
			'produk' => ['required'],
			'jumlah' => ['required', 'numeric'],
		]);

		$produk = Produk::with('stoks')->where('id_produk', $request->produk)->first();

		if ($produk->stoks->isEmpty()) {
			return response()->json([
				"success" => false,
				"message" => "Stok barang kosong",
				"data" => $produk
			]);
		}

		$user = User::where('id', $request->user)->first();

		DB::transaction(function () use ($produk, $user, $request) {
			$transaksi = Transaksi::create([
				'id_produk' => $produk->id_produk,
				'id_user' => $user->id,
			]);

			$detail_transaksi = DetailTransaksi::create([
				'id_transaksi' => $transaksi->id_transaksi,
				'jumlah' => $request->jumlah,
				'harga_total' => ($request->jumlah * $produk->harga),
			]);

			Stok::where('id_stok', $request->stok)->decrement('jumlah_stok', $detail_transaksi->jumlah);
		});
		return response()->json([
			"success" => true,
			"message" => "Transaksi berhasil ditambahkan",
			"data" => $produk
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Transaksi  $transaksi
	 * @return \Illuminate\Http\Response
	 */
	public function show(Transaksi $transaksi)
	{
		$users = User::all();
		$produks = Produk::all();
		$transaksi = Transaksi::with('user', 'produk', 'detailTransaksi')->where('id_transaksi', $transaksi->id_transaksi)->first();
		return view('admin.transaksi.keluar.show', compact('transaksi', 'users', 'produks'));
	}

	public function destroy($id)
	{
		$transaksi = Transaksi::find($id);
		$transaksi->delete();
		return response()->json([
			"success" => true,
			"message" => "Data transaksi telah dihapus",
			"data" => $transaksi
		]);
	}
}
