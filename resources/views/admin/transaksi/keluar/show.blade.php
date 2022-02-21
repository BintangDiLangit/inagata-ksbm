@extends('layouts/landing/master')
@section('title')
    Detail Transaksi
@endsection

@section('content')
    <h2>Nama Pembeli : {{ $transaksi->user->nama_lengkap }}</h2>
    <h2>Nama Produk : {{ $transaksi->produk->nama_produk }}</h2>
    <h2>Harga Produk : {{ $transaksi->produk->harga }}</h2>
    <h2>Jumlah Produk : {{ $transaksi->detailTransaksi->jumlah }}</h2>
    <h2>Harga Total : {{ $transaksi->detailTransaksi->harga_total }}</h2>
    <h2>Metode Pembayaran : {{ $transaksi->detailTransaksi->pembayaran }}</h2>

    <button type="button" class="btn btn-primary mb-3" value="{{ $transaksi }}" data-toggle="modal"
        data-target="#exampleModal">
        Edit Transaksi
    </button>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('transaksi.update', $transaksi) }}" method="POST" data-parsley-validate
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="user">User</label>
                            <select class="form-select" name="user" id="user">
                                <option selected="true" disabled="true">Pilih User</option>
                                @foreach ($users as $user)
                                    <option {{ $user->id === $transaksi->user->id ? 'selected' : '' }}
                                        value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
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
                                    <option {{ $produk->id_produk === $transaksi->produk->id_produk ? 'selected' : '' }}
                                        value="{{ $produk->id_produk }}">{{ $produk->nama_produk }}</option>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Edit Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).on('click', '.open_modal', function() {
            var url = "domain.com/yoururl";
            var tour_id = $(this).val();
            $.get(url + '/' + tour_id, function(data) {
                //success data
                console.log(data);
                $('#tour_id').val(data.id);
                $('#name').val(data.name);
                $('#details').val(data.details);
                $('#btn-save').val("update");
                $('#myModal').modal('show');
            })
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
@endpush
