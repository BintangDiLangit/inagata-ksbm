@extends('layouts/landing/master')
@section('title')
    Tambah Produk
@endsection

@section('content')
    <form action="{{ route('transaksi.store') }}" method="POST" data-parsley-validate enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="user">User</label>
            <select class="form-select" name="user" id="user">
                <option selected="true" disabled="true">Pilih User</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->nama_user }}</option>
                @endforeach
            </select>
            @error('user') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="produk">Produk</label>
            <select class="form-select" name="produk" id="produk"
                onchange="onChangeProduk(this.options[this.selectedIndex].value)">
                <option selected="true" disabled="true">Pilih Produk</option>
                @foreach ($produks as $produk)
                    <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }}</option>
                @endforeach
            </select>
            @error('produk') <span class="text-danger">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3" id="input-stok">
            <label class="form-label" for="stok">Stok</label>
            <select class="form-select" name="stok" id="stok">
                <option selected="true" disabled="true">Pilih Stok</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="jumlah">Jumlah</label>
            <input class="form-control" type="number" placeholder="Input Jumlah" name="jumlah">
            @error('jumlah') <span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <button class="btn btn-primary" type="submit">Tambah Transaksi</button>
    </form>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        const stoks = {!! json_encode($stoks->toArray()) !!};        

        function onChangeProduk(id_produk) {
            var filtered_stoks = findStokByProduk(id_produk);
            $('#stok')
                .empty()
                .append('<option selected="selected" disabled="true">Pilih Varian</option>');
            $.each(filtered_stoks, function(key, value) {                
                $('#stok').append($("<option></option>")
                    .attr("value", value.id_stok)
                    .text("warna: " + value.warna + ", size: " + value.size)
                )
            });
        }

        function findStokByProduk(id_produk) {

            var filtered_stok = stoks.filter(function(el) {
                return el.id_produk == id_produk;
            })

            return filtered_stok;
        }
    </script>
@endpush
