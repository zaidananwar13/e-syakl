@extends('home/master2')
@section('judul', 'Data Kelas User')
@section('data-controller', 'active')
@section('kelas-user', 'text-active')
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
    <a href="{{ url('kelas_user/create')}}" class="btn btn-success">Tambah</a>
    <hr />
    <table id="data_produk" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>User</th>
                <th>Kelas</th>
                <th>Point Review</th>
                <th>Komentar Review</th>


                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kelas_user as $key => $value)
            <tr>
                <td>{{$key+1}}</td>
                @foreach($user as $kt)
                @if($value->id_user == $kt->id_user)
                <td>{{$kt->username}}</td>
                @endif
                @endforeach
                @foreach($kelas as $kls)
                @if($value->id_kelas == $kls->id_kelas)
                <td>{{$kls->judul}}</td>
                @endif
                @endforeach
                <td>{{$value->point_review}}</td>
                <td>{{$value->komentar_review}}</td>
                <td><a href="{{url('kelas_user/'.$value->id_kelas_user.'/edit')}}" class="btn btn-warning"><i class="fa fa-edit"></i></a> |
                    <a href="{{url('kelas_user/delete/'.$value->id_kelas_user)}}" onclick="return confirm('Are you sure to proceed?')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
