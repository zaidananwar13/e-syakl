@extends('home/master2')
@section('judul', 'Form Materi')
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

    <form role="form" action="{{($action!='sub_kategori_silabus.store') ? url($action): route($action) }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="id_sub_kategori_silabus" value="{{ ($action!='sub_kategori_silabus.store') ? $sub_kategori_silabus->id_sub_kategori_silabus : '' }}">
        <div class="card-body">

            <label for="kategori_silabus">Kategori Silabus</label>
            <select class="form-control mb-4" name="id_kategori_silabus">
                @foreach ($kategori_silabus as $key => $value)
                <option value="{{ $value->id_kategori_silabus }}" @if($action !="sub_kategori_silabus.store" && $value->id_kategori_silabus == $sub_kategori_silabus->id_kategori_silabus) selected="selected" @endif>
                    {{ $value->judul }}
                </option>
                @endforeach
            </select>
            <div class="form-group mb-4">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" name="judul" value="{{ ($action!='sub_kategori_silabus.store') ? $sub_kategori_silabus->judul : '' }}" placeholder="Judul">
            </div>
            
            <div class="form-group mb-4">
                <label for="deskripsi">Deskripsi</label>
                
                <input class="form-control" name="deskripsi" id="deskripsi" value="{{ ($action!='sub_kategori_silabus.store') ? $sub_kategori_silabus->deskripsi : '' }}">
            </div>
            
            <div class="form-group mb-4">
                <label for="konten">Konten</label>
                
                <textarea class="form-control" name="konten" id="konten">{{ ($action!='sub_kategori_silabus.store') ? $sub_kategori_silabus->konten : '' }}</textarea>
            </div>



        <!-- /.card-body -->

        <div class="card-footer">
            <input type="submit" class="btn btn-success" value="{{ ($action!='sub_kategori_silabus.store') ? 'Update' : 'Simpan' }}">
        </div>
    </form>
</div>

@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
<script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
var konten = document.getElementById("konten");
    CKEDITOR
let editor = CKEDITOR;
CKFinder.setupCKEditor( editor );

editor.replace(konten,{
        language:'en-gb'
    });
editor.editorconfig.allowedContent = true;
</script>
</body>
@endsection