<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class KategoriProdukController extends Controller
{
	public function index()
	{
		$data = KategoriProduk::get();
		if (request()->ajax()) {
			return Datatables::of($data)->make();
		}
		return view('admin.kategori.index');
	}

	public function create()
	{
		$kategoris = KategoriProduk::get();
		return view('admin.kategori.create', compact('kategoris'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'nama_kategori' => 'string|max:255|required',
		]);
		try {

			$kategori = new KategoriProduk();
			$kategori->nama_kategori = $request->nama_kategori;
			$kategori->slug = Str::slug($request->nama_kategori);
			$kategori->save();
			Alert::success('Kategori Ditambahkan', 'Data Kategori Berhasil Ditambahkan');
			return redirect(route('kategori.index'));
		} catch (\Throwable $error) {
			return $error;
		}
	}


	public function show($slug)
	{
		$kategoris = KategoriProduk::where('slug', $slug)->with('produks')->get();

		return view('admin.kategori.show', compact('kategoris'));
	}

	public function edit($id)
	{
		$kategori = KategoriProduk::where('id_kategori_produk', $id)->first();
		return view('admin.kategori.edit', compact('kategori'));
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'nama_kategori' => 'string|max:255|required',
		]);
		try {

			$kategori = KategoriProduk::find($id);
			$kategori->nama_kategori = $request->nama_kategori;
			$kategori->slug = Str::slug($request->nama_kategori);
			$kategori->update();
			Alert::success('Kategori Diupdate', 'Data Kategori Berhasil Diupdate');
			return redirect(route('kategori.index'));
		} catch (\Throwable $error) {
			return $error;
		}
	}

	public function destroy($id)
	{
		$kategori = KategoriProduk::find($id);
		$kategori->delete();
		Alert::success('Kategori Dihapus', 'Data Kategori Berhasil Dihapus');
		return redirect(route('admin.kategori.index'));
	}
}
