@extends('master')
@section('judul', 'Form Sub Kategori Silabus')
@section('content')
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
        <select class="form-control" name="id_kategori_silabus">
            @foreach ($kategori_silabus as $key => $value)
            <option value="{{ $value->id_kategori_silabus }}" @if($action !="sub_kategori_silabus.store" && $value->id_kategori_silabus == $sub_kategori_silabus->id_kategori_silabus) selected="selected" @endif>
                {{ $value->judul }}
            </option>
            @endforeach
        </select>
        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" class="form-control" name="judul" value="{{ ($action!='sub_kategori_silabus.store') ? $sub_kategori_silabus->judul : '' }}" placeholder="Judul">
        </div>
        
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            
            <input class="form-control" name="deskripsi" id="deskripsi" value="{{ ($action!='sub_kategori_silabus.store') ? $sub_kategori_silabus->deskripsi : '' }}">
        </div>
        
        <div class="form-group">
            <label for="konten">Konten</label>
            
            <textarea class="form-control" name="konten" id="konten">{{ ($action!='sub_kategori_silabus.store') ? $sub_kategori_silabus->konten : '' }}</textarea>
        </div>



    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <input type="submit" class="btn btn-success" value="{{ ($action!='sub_kategori_silabus.store') ? 'Update' : 'Simpan' }}">
    </div>
</form>

@endsection
