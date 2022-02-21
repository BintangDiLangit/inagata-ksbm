@extends('layouts/landing/master')
@section('title')
    Edit Produk
@endsection

@section('content')
    <form action="{{ route('produk.update', $produk) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="exampleFormControlInput1">Kategori :
                {{ $selectedKategori->nama_kategori }}</label>
            <select name="id_kategori_produk" class="form-control" id="" required>
                <option value="">Pilih Kategori Produk</option>
                @php
                    foreach ($kategoris as $kategori) {
                        echo '<option value="' . $kategori->id_kategori_produk . '">' . $kategori->nama_kategori . '</option>';
                    }
                @endphp
            </select>
            @error('id_kategori_produk') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="exampleFormControlInput1">Nama Produk</label>
            <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="Nama Produk"
                name="nama_produk" required value="{{ $produk->nama_produk }}">
            @error('nama_produk') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="exampleFormControlInput1">Harga</label>
            <input class="form-control" id="exampleFormControlInput1" type="number" placeholder="Harga Produk"
                name="harga" value="{{ $produk->harga }}">
            @error('harga') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="exampleFormControlTextarea1">Deskripsi Produk</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="deskripsi_produk"
                required>{{ $produk->deskripsi_produk }}</textarea>
            @error('deskripsi_produk') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="exampleFormControlInput1">Tag</label>
            <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="Tag Produk" name="tags"
                required value="{{ $produk->tags }}">
            @error('tags') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <hr>
        <div class="mb-3">
            <label class="form-label" for="exampleFormControlInput1">Jumlah Produk</label>
            <input class="form-control" id="exampleFormControlInput1" type="number" placeholder="Jumlah Produk"
                name="jumlah_stok" required value="{{ $produk->stoks->first()->jumlah_stok }}">
            @error('jumlah_stok') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="exampleFormControlInput1">Ukuran</label>
            <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="Ukuran Produk" name="size"
                required value="{{ $produk->stoks->first()->size }}">
            @error('size') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="exampleFormControlInput1">Warna</label>
            <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="Warna Produk" name="warna"
                required value="{{ $produk->stoks->first()->warna }}">
            @error('warna') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <button class="btn btn-primary" type="submit">Edit Produk</button>
    </form>
@endsection
