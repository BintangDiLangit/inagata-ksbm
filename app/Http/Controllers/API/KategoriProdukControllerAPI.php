<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class KategoriProdukControllerAPI extends Controller
{
	public function index()
	{
		$kategoris = KategoriProduk::with('produk_produks')->get();
		return response()->json([
			"success" => true,
			"message" => "Daftar Kategori produk",
			"data" => $kategoris
		]);
	}


	public function store(Request $request)
	{
		$input = $request->all();
		dd($input);
		$validator = Validator::make($input, [
			'nama_kategori' => 'string|max:255|required',
		]);
		if ($validator->fails()) {
			return $this->sendError('Validation Error.', $validator->errors());
		}
		$kategori = KategoriProduk::create(
			[
				'nama_kategori' => $request->nama_kategori,
				'slug' => Str::slug($request->nama_kategori),
			]
		);
		return response()->json([
			"success" => true,
			"message" => "Data kategori produk telah ditambahkan.",
			"data" => $kategori
		]);
	}


	public function update(Request $request, $id)
	{
		$input = $request->all();
		$validator = Validator::make($input, [
			'nama_kategori' => 'required'
		]);
		if ($validator->fails()) {
			return $this->sendError('Validation Error.', $validator->errors());
		}
		$data = KategoriProduk::find($id);
		$kategori = $data->update([
			'nama_kategori' => $request->nama_kategori,
			'slug' => Str::slug($request->nama_kategori),
		]);
		return response()->json([
			"success" => true,
			"message" => "Data kategori produk telah diupdate.",
			"data" => $kategori
		]);
	}


	public function destroy($kategori)
	{
		KategoriProduk::destroy($kategori);
		return response()->json([
			"success" => true,
			"message" => "Data kategori produk telah dihapus",
			"data" => $kategori
		]);
	}
}
