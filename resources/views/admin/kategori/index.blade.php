@extends('layouts/landing/master')
@section('title')
    List Kategori
@endsection

@section('content')
    @include('sweetalert::alert')
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
        Add Kategori
    </button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('kategori.store') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Nama Kategori Produk</label>
                            <input class="form-control" id="exampleFormControlInput1" type="text"
                                placeholder="Nama Kategori" name="nama_kategori" required
                                value="{{ old('nama_kategori') }}">
                            @error('nama_kategori') <span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Tambah Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <table class="table table-striped" id="tabelKategori">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori Produk</th>
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
            $('#tabelKategori').DataTable({
                serverside: true,
                responseive: true,
                ajax: {
                    url: "{{ route('kategori.index') }}"
                },
                columns: [{
                        "data": null,
                        "sortable": false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1
                        }
                    },
                    {
                        data: 'nama_kategori',
                        name: 'nama_kategori'
                    },
                    {
                        "mData": null,
                        'className': 'py-4 ps-0',
                        "mRender": function(data, type, full) {
                            btn =
                                `<a class="edit btn btn-info text-white" href="kategori/${data.slug}">Detail</a>
								
								
								<button type="button" class="btn btn-danger hap" value="${data}" id="${data.id_kategori_produk}" onclick=getid() data-toggle="modal" data-target="#exampleModal2">
									Delete
								</button>

								<!-- Modal -->
								<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Hapus Kategori</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												Apa anda yakin ingin menghapus kategori ini?
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button type="button" class="delete btn btn-danger text-white" id="${data.id_kategori_produk}" onclick=hapus()  name="delete">Hapus</button>
											</div>
										</div>
									</div>
								</div>
								
								
								
								
								
								
								
								`;

                            res = btn;
                            return res;
                        }
                    }

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
                    url: 'kategori/' + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    }
                });

                location.reload()
            })
        };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
@endpush
