@extends('home/master2')
@section('judul', 'Data Instansi')
@section('data-controller', 'active')
@section('kategori', 'text-active')
@section('css')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<style>
    .custom-container {
        background-color: white;
        padding-top: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    }

    .text-active {
        color: #009ef7 !important;
    }
</style>
@endsection
@section('content')

<div class="container custom-container">
    <a href="{{ url('kategori/create')}}" class="btn btn-success">Tambah</a>
    <hr />
    <table id="data_produk" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>Judul</th>
                <th>Gambar</th>
                <th>Deskripsi</th>

                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $key => $value)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->judul}}</td>
                <!-- <td>{{$value->gambar}}</td> -->
                <td><img src="/image/{{ $value->gambar }}" width="100px"></td>
                <!-- <td>{{$value->harga}}</td> -->
                <td>{{$value->deskripsi}}</td>
                <td><a href="{{url('kategori/'.$value->id_kategori.'/edit')}}" class="btn btn-warning"><i class="fa fa-edit"></i></a> |
                    <a onclick="return confirm('Are you sure to proceed?')" href="{{url('kategori/delete/'.$value->id_kategori)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
@section('js')

<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<!-- AdminLTE App -->
<!-- page script -->
<script>
    $(function() {
        $("#data_produk").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>
@endsection
