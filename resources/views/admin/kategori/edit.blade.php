@extends('layouts/landing/master')
@section('title')
    Edit Kategori Produk
@endsection

@section('content')
    <form action="{{ route('kategori.update', $kategori) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label" for="exampleFormControlInput1">Nama Kategori Produk</label>
            <input class="form-control" id="exampleFormControlInput1" type="text" value="{{ $kategori->nama_kategori }}"
                placeholder="Nama Kategori" name="nama_kategori" required>
            @error('nama_kategori') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <button class="btn btn-primary" type="submit">Edit Kategori</button>
    </form>
@endsection
