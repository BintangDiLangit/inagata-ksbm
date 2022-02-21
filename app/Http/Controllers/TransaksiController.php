<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	// public function index()
	// {
	// 	$listTransaksiMasuk = Transaksi::with('user', 'produk', 'detail_transaksis')->get();
	// 	return view('admin.transaksi.keluar.index', compact('listTransaksiMasuk'));
	// }
	public function index()
	{
		$produks = Produk::all();
		$users = User::all();
		$stoks = Stok::all();
		$listTransaksiMasuk = Transaksi::with('user', 'produk', 'detailTransaksi')->get();
		if (request()->ajax()) {
			return Datatables::of($listTransaksiMasuk)->make();
		}
		return view('admin.transaksi.keluar.index', compact('listTransaksiMasuk', 'users', 'produks', 'stoks'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$produks = Produk::all();
		$users = User::all();
		$stoks = Stok::all();
		return view('admin.transaksi.keluar.create', compact('users', 'produks', 'stoks'));
	}

	public function approve($approve)
	{
		$status = Transaksi::where('id_transaksi', $approve)->get()->first();
		if ($status->status == 'SUKSES') {
			$status->update([
				'status' => 'PENDING'
			]);
			Alert::success('Approve Dibatalakn', 'Approve Berhasil Dibatalkan');
		} else if ($status->status == 'PENDING') {
			$status->update([
				'status' => 'SUKSES'
			]);
			Alert::success('Approve Sukses', 'Transaksi Berhasil Terapprove');
		} else {
			return redirect()->back();
		}

		return redirect()->back();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			'user' => ['required'],
			'produk' => ['required'],
			'jumlah' => ['required', 'numeric'],
		]);

		$produk = Produk::with('stoks')->where('id_produk', $request->produk)->first();

		if ($produk->stoks->isEmpty()) {
			return Redirect::back()->withErrors(['produk' => 'stok sedang kosong']);
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
		Alert::success('Data Transaksi Ditambahkan', 'Transaksi Berhasil Ditambahkan');
		return redirect(route('transaksi.index'));
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

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Transaksi  $transaksi
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Transaksi $transaksi)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Transaksi  $transaksi
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Transaksi $transaksi)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Transaksi  $transaksi
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$transaksi = Transaksi::find($id);
		$transaksi->delete();
		return redirect(route('transaksi.index'))->with(Alert::success('Transaksi Dihapus', 'Data Transaksi Berhasil Dihapus'));
		// if ($transaksi->status == 'SUKSES') {
		// 	$transaksi->delete();
		// 	return redirect(route('transaksi.index'))->with('success', 'Transaksi berhasil dihapus');
		// } else {
		// 	Alert::warning('Warning Title', 'Warning Message');
		// 	return view('admin.transaksi.keluar.index', compact('alert'));
		// }
	}
}
