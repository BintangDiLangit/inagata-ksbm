@extends('layouts/landing/master')
@section('title')
    Detail Kategori Produk
@endsection

@section('content')


    @foreach ($kategoris as $kategori)
        <h2>{{ $kategori->nama_kategori }}</h2>

        <table class="table">
            <thead>
                <th>No.</th>
                <th>Nama Produk</th>
            </thead>
            <tbody>
                @foreach ($kategori->produks as $produk)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $produk->nama_produk }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" class="btn btn-primary mb-3" value="{{ $kategori }}" data-toggle="modal"
            data-target="#exampleModal">
            Edit Kategori
        </button>
    @endforeach
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('kategori.update', $kategori) }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Nama Kategori Produk</label>
                            <input class="form-control" id="exampleFormControlInput1" type="text"
                                value="{{ $kategori->nama_kategori }}" placeholder="Nama Kategori" name="nama_kategori"
                                required>
                            @error('nama_kategori') <span class="text-danger">{{ $message }}</span>@enderror
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
