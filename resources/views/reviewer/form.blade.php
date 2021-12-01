@extends('home/master2')
@section('judul', 'Form Reviewer')
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
    <form role="form" action="{{($action!='reviewer.store') ? url($action): route($action) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id_reviewer" value="{{ ($action!='reviewer.store') ? $reviewer->id_reviewer : '' }}">
        <div class="card-body">
            <div class="form-group mb-4">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" name="nama" value="{{ ($action!='reviewer.store') ? $reviewer->nama : '' }}" placeholder="Nama">
            </div>
            <div class="form-group mb-4">
                <label for="foto">Foto</label>
                <div class="custom-file">
                    <input type="file" name="foto" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" name="foto" for="customFile">Choose file</label>
                </div>
                @if($action!='reviewer.store')
                <img src="/image/{{ $reviewer->foto }}" width="100px">
                @endif
            </div>
            <div class="form-group mb-4">
                <label for="jabatan">Jabatan</label>
                <input type="text" class="form-control" name="jabatan" value="{{ ($action!='reviewer.store') ? $reviewer->jabatan : '' }}" placeholder="Jabatan">
            </div>
            <div class="form-group mb-4">
                <label for="portofolio">Portofolio</label>
                <textarea class="form-control" style="height:150px" name="portofolio" placeholder="Portofolio">{{ ($action!='reviewer.store') ? $reviewer->portofolio : '' }}</textarea>

            </div>

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="submit" class="btn btn-success" value="{{ ($action!='reviewer.store') ? 'Update' : 'Simpan' }}">
        </div>
    </form>
</div>

@endsection
