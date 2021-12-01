@extends('home/master2')
@section('judul', 'Data Reviewer')

@section('data-controller', 'active')
@section('reviewer', 'text-active')
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
    <a href="{{ url('reviewer/create')}}" class="btn btn-success">Tambah</a>
    <hr />
    <table id="data_produk" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Foto</th>
                <th>Portofolio</th>

                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviewer as $key => $value)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->nama}}</td>
                <td>{{$value->jabatan}}</td>

                <td><img src="/image/{{ $value->foto }}" width="100px"></td>
                <td>{{$value->portofolio}}</td>
                <td><a href="{{url('reviewer/'.$value->id_reviewer.'/edit')}}" class="btn btn-warning"><i class="fa fa-edit"></i></a> |
                    <a href="{{url('reviewer/delete/'.$value->id_reviewer)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
