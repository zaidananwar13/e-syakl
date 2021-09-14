@extends('master')
@section('judul', 'Data Kelas')
@section('css')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection
@section('content')

<a href="{{ url('kelas/create')}}" class="btn btn-success">Tambah</a>
<hr />
<table id="data_produk" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Reviewer</th>
            <th>Judul</th>
            <th>Gambar</th>
            <!-- <th>Langkah</th>
            <th>Level</th>
            <th>Deskripsi Singkat</th>
            <th>Durasi</th>
            <th>Deskripsi Kelas</th> -->

            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kelas as $key => $value)
        <tr>
            <td>{{$key+1}}</td>
            @foreach($kategori as $kt)
            @if($value->id_kategori == $kt->id_kategori)
            <td>{{$kt->judul}}</td>
            @endif
            @endforeach
            @foreach($reviewer as $rvw)
            @if($value->id_reviewer == $rvw->id_reviewer)
            <td>{{$rvw->nama}}</td>
            @endif
            @endforeach
            <td>{{$value->judul}}</td>
            <td><img src="/image/{{ $value->gambar }}" width="100px"></td>
            <!-- <td>{{$value->langkah}}</td>
            <td>{{$value->level}}</td>
            <td>{{$value->deskripsi_singkat}}</td>
            <td>{{$value->durasi}}</td>
            <td>{{$value->deskripsi_kelas}}</td> -->
            <td>
                <a href="{{ route('kelas.show',$value->id_kelas) }}" class="btn btn-primary"><i class="fa fa-search"></i></a>|
                <a href="{{url('kelas/'.$value->id_kelas.'/edit')}}" class="btn btn-warning"><i class="fa fa-edit"></i></a> |
                <a href="{{url('kelas/delete/'.$value->id_kelas)}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

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
