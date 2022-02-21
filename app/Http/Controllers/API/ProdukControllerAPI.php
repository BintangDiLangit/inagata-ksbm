<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\GalleryProduk;
use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdukControllerAPI extends Controller
{
	public function index()
	{
		$data = Produk::with('kategoriProduk', 'stoks')->get();
		return response()->json([
			"success" => true,
			"message" => "Daftar produk",
			"data" => $data
		]);
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

			$produk = Produk::create([
				'nama_produk' => $request->nama_produk,
				'harga' => $request->harga,
				'deskripsi_produk' => $request->deskripsi_produk,
				'tags' => $request->tags,
				'slug' => Str::slug($request->nama_produk),
				'id_kategori_produk' => $request->id_kategori_produk
			]);

			$stok = Stok::create([
				'id_produk' => $produk->id_produk,
				'jumlah_stok' => $request->jumlah_stok,
				'size' => $request->size,
				'warna' => $request->warna
			]);

			if ($request->hasFile('url')) {
				$galeri = new GalleryProduk();
				$galeri->id_produk = $produk->id_produk;

				$imageName = time() . '.' . $request->file('url')->getClientOriginalExtension();
				$request->file('url')->move('blog-images/', $imageName);

				$galeri->url = $imageName;
				$galeri->save();
			}
			return response()->json([
				"success" => true,
				"message" => "Produk telah ditambahkan",
				"data" => [$produk, $stok]
			]);
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

			$data = Produk::find($id);
			if (!is_null($data)) {
				$produk = $data->update([
					'nama_produk' => $request->nama_produk,
					'harga' => $request->harga,
					'deskripsi_produk' => $request->deskripsi_produk,
					'tags' => $request->tags,
					'slug' => Str::slug($request->nama_produk),
					'id_kategori_produk' => $request->id_kategori_produk
				]);

				$dataStok = Stok::find($id);
				$stok = $dataStok->update([
					'id_produk' => $produk->id_produk,
					'jumlah_stok' => $request->jumlah_stok,
					'size' => $request->size,
					'warna' => $request->warna
				]);
			}


			return response()->json([
				"success" => true,
				"message" => "Produk telah diubah",
				"data" => [$produk, $stok]
			]);
		} catch (\Throwable $error) {
			return $error;
		}
	}

	public function destroy($id)
	{
		$blg = Produk::find($id);
		$blg->delete();
		return response()->json([
			"success" => true,
			"message" => "Data produk telah dihapus",
			"data" => $blg
		]);
	}
}
