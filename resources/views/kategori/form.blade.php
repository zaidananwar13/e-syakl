@extends('home/master2')
@section('judul', 'Form Kategori')
@section('data-controller', 'active')
@section('kategori', 'text-active')
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

    <form action="{{($action!='kategori.store') ? url($action): route($action) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id_kategori" value="{{ ($action!='kategori.store') ? $kategori->id_kategori : '' }}">
        <div class="card-body">
            <div class="form-group mb-4">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" name="judul" value="{{ ($action!='kategori.store') ? $kategori->judul : '' }}" placeholder="Judul Kategori">
            </div>
            <div class="form-group mb-4">
                <label for="gambar">Gambar</label>
                <div class="custom-file">
                    <input type="file" name="gambar" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" name="gambar" for="customFile">Choose file</label>
                </div>
                @if($action!='kategori.store')
                <img src="/image/{{ $kategori->gambar }}" width="100px">
                @endif
            </div>
            <div class="form-group mb-4">
                <label for="deskripsi">Deksripsi</label>
                <!-- <input type="text" class="form-control" name="deskripsi" value="{{ ($action!='kategori.store') ? $kategori->deskripsi : '' }}" placeholder="Deskripsi"> -->
                <textarea class="form-control" style="height:150px" name="deskripsi" placeholder="Deskripsi">{{ ($action!='kategori.store') ? $kategori->deskripsi : '' }}</textarea>
            </div>


        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="submit" class="btn btn-success" value="{{ ($action!='kategori.store') ? 'Update' : 'Simpan' }}">
        </div>
    </form>
</div>


@endsection
