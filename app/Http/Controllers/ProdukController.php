<?php

namespace App\Http\Controllers;

use App\Models\GalleryProduk;
use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ProdukController extends Controller
{
	public function index()
	{
		$kategoris = KategoriProduk::get();
		$data = Produk::with('kategoriProduk', 'stoks')->get();
		if (request()->ajax()) {
			return Datatables::of($data)->make();
		}
		return view('admin.produk.index', compact('kategoris'));
	}

	public function create()
	{
		$kategoris = KategoriProduk::get();
		return view('admin.produk.create', compact('kategoris'));
	}

	public function store(Request $request)
	{
		$request->validate([
			'id_kategori_produk' => 'required',

			'nama_produk' => 'string|max:255|required',
			'harga' => 'numeric|required',
			'deskripsi_produk' => 'string|required',
			'tags' => 'string|required',

			'jumlah_stok' => 'numeric|required',
			'size' => 'string|required',
			'warna' => 'string|required',

			'url' => 'image|required',
		]);

		try {

			$produk = new Produk();
			$produk->nama_produk = $request->nama_produk;
			$produk->harga = $request->harga;
			$produk->deskripsi_produk = $request->deskripsi_produk;
			$produk->tags = $request->tags;
			$produk->slug = Str::slug($request->nama_produk);
			$produk->id_kategori_produk = $request->id_kategori_produk;
			$produk->save();

			$stok = new Stok();
			$stok->id_produk = $produk->id_produk;
			$stok->jumlah_stok = $request->jumlah_stok;
			$stok->size = $request->size;
			$stok->warna = $request->warna;
			$stok->save();

			if ($request->hasFile('url')) {
				$galeri = new GalleryProduk();
				$galeri->id_produk = $produk->id_produk;

				$imageName = time() . '.' . $request->file('url')->getClientOriginalExtension();
				$request->file('url')->move('blog-images/', $imageName);

				$galeri->url = $imageName;
				$galeri->save();
			}
			Alert::success('Produk Ditambahkan', 'Data Produk Berhasil Ditambahkan');
			return redirect(route('produk.index'))->with('success', 'Produk berhasil ditambahkan');
		} catch (\Throwable $error) {
			return $error;
		}
	}


	public function show($slug)
	{

		$produks = Produk::where('slug', $slug)->with('stoks')->get();
		$kategoris = KategoriProduk::get();
		$produk = Produk::where('id_produk', $produks->first()->id_produk)->first();
		$selectedKategori = KategoriProduk::where('id_kategori_produk', $produk->id_kategori_produk)->first();
		return view('admin.produk.show', compact('produks', 'selectedKategori', 'produk', 'kategoris'));
	}

	public function edit($id)
	{
		$kategoris = KategoriProduk::get();
		$produk = Produk::where('id_produk', $id)->first();
		$selectedKategori = KategoriProduk::where('id_kategori_produk', $produk->id_kategori_produk)->first();

		return view('admin.produk.edit', compact('produk', 'kategoris', 'selectedKategori'));
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'id_kategori_produk' => 'required',

			'nama_produk' => 'string|max:255|required',
			'harga' => 'numeric|required',
			'deskripsi_produk' => 'string|required',
			'tags' => 'string|required',

			'jumlah_stok' => 'numeric|required',
			'size' => 'string|required',
			'warna' => 'string|required',
		]);

		try {

			$produk = Produk::find($id);
			if (!is_null($produk)) {
				$produk->nama_produk = $request->nama_produk;
				$produk->harga = $request->harga;
				$produk->deskripsi_produk = $request->deskripsi_produk;
				$produk->tags = $request->tags;
				$produk->slug = Str::slug($request->nama_produk);
				$produk->id_kategori_produk = $request->id_kategori_produk;
				$produk->update();

				$stok = Stok::find($id);
				$stok->id_produk = $produk->id_produk;
				$stok->jumlah_stok = $request->jumlah_stok;
				$stok->size = $request->size;
				$stok->warna = $request->warna;
				$stok->update();
			}

			Alert::success('Produk Diupdate', 'Data Produk Berhasil Diupdate');
			return redirect(route('produk.index'));
		} catch (\Throwable $error) {
			return $error;
		}
	}

	public function destroy($id)
	{
		$blg = Produk::find($id);
		$blg->delete();
		Alert::success('Produk Dihapus', 'Data Produk Berhasil Dihapus');
		return redirect(route('admin.produk.index'));
	}
}
