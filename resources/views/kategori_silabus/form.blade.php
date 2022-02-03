@extends('home/master2')
@section('judul', 'Form Data Silabus')
@section('data-controller', 'active')
@section('silabus', 'text-active')
@section('kategori-silabus', 'text-active')
@section('css')
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
@section('content')

<div class="custom-container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Ups!</strong> Ada yang salah dengan isian mu.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form role="form" action="{{($action!='kategori_silabus.store') ? url($action): route($action) }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="id_kategori_silabus" value="{{ ($action!='kategori_silabus.store') ? $kategori_silabus->id_kategori_silabus : '' }}">
        <div class="card-body">
            <!-- <div class="form-group mb-4">
                <label for="exampleInputEmail1">Kelas</label>
                <input type="text" class="form-control" name="id_kelas" value="{{ ($action!='kategori_silabus.store') ? $kategori_silabus->id_kelas : '' }}" placeholder="Nama">
            </div> -->
            <label for="exampleInputEmail1">Kelas</label>
            <select class="form-control" name="id_kelas">
                @foreach ($kelas as $key => $value)
                <option value="{{ $value->id_kelas }}" @if($action !="kategori_silabus.store" && $value->id_kelas == $kategori_silabus->id_kelas) selected="selected" @endif>
                    {{ $value->judul }}
                </option>
                @endforeach
            </select>
            <div class="form-group mb-4">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" name="judul" value="{{ ($action!='kategori_silabus.store') ? $kategori_silabus->judul : '' }}" placeholder="Judul">
            </div>
            
            <div class="form-group mb-4">
                <label for="judul">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10">{{ ($action!='kategori_silabus.store') ? $kategori_silabus->deskripsi : '' }}</textarea>
            </div>



        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="submit" class="btn btn-success" value="{{ ($action!='kategori_silabus.store') ? 'Update' : 'Simpan' }}">
        </div>
    </form>

</div>

@endsection
