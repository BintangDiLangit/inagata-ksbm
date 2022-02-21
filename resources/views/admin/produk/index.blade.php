@extends('layouts/landing/master')
@section('title')
    List Produk
@endsection

@section('content')
    @include('sweetalert::alert')
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
        Add Produk
    </button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('produk.store') }}" method="POST" data-parsley-validate
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Kategori</label>
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
                                placeholder="Nama Produk" name="nama_produk" required value="{{ old('nama_produk') }}">
                            @error('nama_produk') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Harga</label>
                            <input class="form-control" id="exampleFormControlInput1" type="number"
                                placeholder="Harga Produk" name="harga" value="{{ old('harga') }}">
                            @error('harga') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlTextarea1">Deskripsi Produk</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                name="deskripsi_produk" required>{{ old('deskripsi_produk') }}</textarea>
                            @error('deskripsi_produk') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Tag</label>
                            <input class="form-control" id="exampleFormControlInput1" type="text" placeholder="Tag Produk"
                                name="tags" required value="{{ old('tags') }}">
                            @error('tags') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Jumlah Produk</label>
                            <input class="form-control" id="exampleFormControlInput1" type="number"
                                placeholder="Jumlah Produk" name="jumlah_stok" required value="{{ old('jumlah_stok') }}">
                            @error('jumlah_stok') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Ukuran</label>
                            <input class="form-control" id="exampleFormControlInput1" type="text"
                                placeholder="Ukuran Produk" name="size" required value="{{ old('size') }}">
                            @error('size') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Warna</label>
                            <input class="form-control" id="exampleFormControlInput1" type="text"
                                placeholder="Warna Produk" name="warna" required value="{{ old('warna') }}">
                            @error('warna') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Gambar</label>
                            <input class="form-control" id="exampleFormControlInput1" type="file"
                                placeholder="Gambar Produk" name="url" required value="{{ old('url') }}">
                            @error('url') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Tambah Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <table class="table table-striped" id="tabel1">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Tag</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
@endsection


@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            isi()
        })

        function isi() {
            $('#tabel1').DataTable({
                serverside: true,
                responseive: true,
                ajax: {
                    url: "{{ route('produk.index') }}"
                },
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {
                        data: 'id_kategori_produk',
                        name: 'id_kategori_produk'
                    },
                    {
                        data: 'nama_produk',
                        name: 'nama_produk'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'tags',
                        name: 'tags'
                    },
                    {
                        "mData": null,
                        'className': 'py-4 ps-0',
                        "mRender": function(data, type, full) {
                            btn =
                                `<a class="edit btn btn-info text-white" href="produk/${data.slug}">Detail</a>
								<button type="button" class="btn btn-danger hap" value="${data}" id="${data.id_produk}" onclick=getid() data-toggle="modal" data-target="#exampleModal2">
									Delete
								</button>

								<!-- Modal -->
								<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Hapus Produk</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												Apa anda yakin ingin menghapus produk ini?
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button type="button" class="delete btn btn-danger text-white" id="${data.id_produk}" onclick=hapus()  name="delete">Hapus</button>
											</div>
										</div>
									</div>
								</div>
								
								`

                            res = btn;
                            return res;
                        }
                    },
                ]
            })
        }

        var id = $(this).attr('id');

        function getid() {
            $(document).on('click', '.hap', function() {
                id = $(this).attr('id');
            })
        }

        function hapus() {

            $(document).on('click', '.delete', function() {
                $.ajax({
                    url: 'produk/' + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    }
                });

                location.reload()
            })

        };
    </script>
    {{-- Modal --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
@endpush
