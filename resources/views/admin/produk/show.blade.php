@extends('layouts/landing/master')
@section('title')
    Detail Produk
@endsection

@section('content')


    @php
    $jumlahStok = $produks->first()->stoks->first()->jumlah_stok;
    @endphp
    @if ($jumlahStok <= 5 && $jumlahStok > 0)
        <div class="alert alert-warning" role="alert">
            Stok Hampir Habis
        </div>
    @else
        <div class="alert alert-success" role="alert">
            Stok Masih Banyak
        </div>
    @endif
    @foreach ($produks as $produk)
        <h2>{{ $produk->nama_produk }}</h2>
        <ul>
            @foreach ($produk->stoks as $stok)
                <li>Jumlah Stok : {{ $stok->jumlah_stok }}</li>
                <li>Ukuran : {{ $stok->size }}</li>
                <li>Warna : {{ $stok->warna }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn btn-primary mb-3" value="{{ $produk }}" data-toggle="modal"
            data-target="#exampleModal">
            Edit Produk
        </button>
    @endforeach
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('produk.update', $produk) }}" method="POST">
                    <div class="modal-body">

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
                            <input class="form-control" id="exampleFormControlInput1" type="text"
                                placeholder="Nama Produk" name="nama_produk" required value="{{ $produk->nama_produk }}">
                            @error('nama_produk') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Harga</label>
                            <input class="form-control" id="exampleFormControlInput1" type="number"
                                placeholder="Harga Produk" name="harga" value="{{ $produk->harga }}">
                            @error('harga') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlTextarea1">Deskripsi Produk</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                name="deskripsi_produk" required>{{ $produk->deskripsi_produk }}</textarea>
                            @error('deskripsi_produk') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Tag</label>
                            <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="Tag Produk"
                                name="tags" required value="{{ $produk->tags }}">
                            @error('tags') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Jumlah Produk</label>
                            <input class="form-control" id="exampleFormControlInput1" type="number"
                                placeholder="Jumlah Produk" name="jumlah_stok" required
                                value="{{ $produk->stoks->first()->jumlah_stok }}">
                            @error('jumlah_stok') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Ukuran</label>
                            <input class="form-control" id="exampleFormControlInput1" type="text"
                                placeholder="Ukuran Produk" name="size" required
                                value="{{ $produk->stoks->first()->size }}">
                            @error('size') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Warna</label>
                            <input class="form-control" id="exampleFormControlInput1" type="text"
                                placeholder="Warna Produk" name="warna" required
                                value="{{ $produk->stoks->first()->warna }}">
                            @error('warna') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Edit Produk</button>
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
