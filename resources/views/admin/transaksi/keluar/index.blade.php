@extends('layouts/landing/master')
@section('title')
    Transaksi
@endsection

@section('content')
    @include('sweetalert::alert')
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
        Add Transaksi
    </button>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('transaksi.store') }}" method="POST" data-parsley-validate
                    enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="user">User</label>
                            <select class="form-select" name="user" id="user">
                                <option selected="true" disabled="true">Pilih User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nama_lengkap }}</option>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Tambah Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-2">
            From:
            <input type="date" name="min" id="min" placeholder="minimum date">
        </div>
        <div class="col-2">
            To:
            <input type="date" name="max" id="max" placeholder="maximum date">
        </div>
    </div>
    <table class="table table-striped" id="tabel-transaksi">
        <thead>
            <tr>
                <th>No</th>
                <th>Pembayaran</th>
                <th>Harga Total</th>
                <th>Status</th>
                <th>User</th>
                <th>Produk</th>
                <th>Waktu Pembelian</th>
                <th>Konfirmasi Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
    <script type="text/javascript">
        var minDate, maxDate;

        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min = minDate;
                var max = maxDate;
                var date = new Date(data[6]).getTime();

                if (
                    (min === undefined && max === undefined) ||
                    (min === undefined && date <= max) ||
                    (min <= date && max === undefined) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;
            }
        );
        $(document).ready(function() {

            var transaksiTable = table(getTransaksiData());
            // Refilter the table
            $('#min, #max').on('change', function() {
                minDate = new Date($('#min').val()).getTime();
                maxDate = new Date($('#max').val()).getTime();
                transaksiTable.draw();
            });

        })


        function table(transaksis) {
            return $('#tabel-transaksi').DataTable({
                autoWidth: false,
                responsive: true,
                data: transaksis.data,
                columns: [{
                        data: 'id_transaksi'
                    },
                    {
                        data: 'detail_transaksi.pembayaran'
                    },
                    {
                        data: 'detail_transaksi.harga_total'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'user.nama_lengkap'
                    },
                    {
                        data: 'produk.nama_produk'
                    },
                    {
                        data: 'created_at',
                        type: 'date',
                        mRender: function(data) {
                            let d = new Date(data);
                            return d;
                        }
                    },
                    {
                        "mData": null,
                        'className': 'ps-0',
                        "mRender": function(data, type, full) {
                            btnBatal =
                                `<a class="btn btn-warning text-white" href="transaksi/${data.id_transaksi}/approve">Batal Konfirmasi</a>`;
                            btn =
                                `<a class="btn btn-info text-white" href="transaksi/${data.id_transaksi}/approve">Konfirmasi</a>`;

                            if (data.status == 'SUKSES') {
                                return btnBatal;
                            } else {
                                return btn;
                            }
                        }
                    },
                    {
                        "mData": null,
                        'className': 'ps-0',
                        "mRender": function(data, type, full) {
                            btn =
                                `<a class="edit btn btn-info text-white" href="transaksi/${data.id_transaksi}">Detail</a>
								<button type="button" class="btn btn-danger hap" value="${data}" id="${data.id_transaksi}" onclick=getid() data-toggle="modal" data-target="#exampleModal2">
									Delete
								</button>

								<!-- Modal -->
								<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Hapus Transaksi</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												Apa anda yakin ingin menghapus transaksi ini?
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button type="button" class="delete btn btn-danger text-white" id="${data.id_transaksi}" onclick=hapus()  name="delete">Hapus</button>
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

        function getTransaksiData(filter) {
            let transaksi;
            $.ajax({
                url: `/admin/transaksi`,
                type: 'GET',
                async: false,
                dataType: 'json',
                success: function(data, textStatus, xhr) {
                    transaksi = data;
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('Error in Database');

                }
            });
            return transaksi;
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
                    url: 'transaksi/' + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    }
                });

                location.reload()
            })

        };
    </script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
@endpush
