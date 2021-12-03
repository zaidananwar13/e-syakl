@extends('home/master2')
@section('judul', 'Data Materi')
@section('data-controller', 'active')
@section('silabus', 'text-active')
@section('sub-kategori-silabus', 'text-active')
@section('css')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<style>
    .custom-container {
        background-color: white;
        padding-top: 20px !important;
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
    <a href="{{ url('sub_kategori_silabus/create')}}" class="btn btn-success">Tambah</a>
    <hr />
    <table id="data_produk" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kategori Silabus</th>
                <th>Judul</th>


                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sub_kategori_silabus as $key => $value)
            <tr>
                <td>{{$key+1}}</td>
                @foreach($kategori_silabus as $slb)
                @if($value->id_kategori_silabus == $slb->id_kategori_silabus)
                <td>{{$slb->judul}}</td>
                @endif
                @endforeach
                <td>{{$value->judul}}</td>
                <td><a href="{{url('sub_kategori_silabus/'.$value->id_sub_kategori_silabus.'/edit')}}" class="btn btn-warning"><i class="fa fa-edit"></i></a> |
                    <a href="{{url('sub_kategori_silabus/delete/'.$value->id_sub_kategori_silabus)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
