@extends('home/master2')
@section('judul', 'Form Instansi')
@section('data-controller', 'active')
@section('instansi', 'text-active')
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

<div class="custom-container">
    <form action="{{($action!='instansi.store') ? url($action): route($action) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id_instansi" value="{{ ($action!='instansi.store') ? $instansi->id_instansi : '' }}">
        <div class="card-body">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" name="nama" value="{{ ($action!='instansi.store') ? $instansi->nama : '' }}" placeholder="Nama Instansi">
            </div>
            <div class="form-group">
                <label for="Lokasi">Lokasi</label>
                <input type="text" class="form-control" name="lokasi" value="{{ ($action!='instansi.store') ? $instansi->lokasi : '' }}" placeholder="Lokasi">
            </div>
            <div class="form-group">
                <label for="Foto">Foto</label>

                <div class="custom-file">
                    <input type="file" name="foto" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" name="foto" for="customFile">Choose file</label>
                </div>
                @if($action!='instansi.store')
                <img src="/image/{{ $instansi->foto }}" width="100px">
                @endif
            </div>


        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="submit" class="btn btn-success" value="{{ ($action!='instansi.store') ? 'Update' : 'Simpan' }}">
        </div>
    </form>
</div>

@endsection
