@extends('master')
@section('judul', 'Form Reviewer')
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
<form role="form" action="{{($action!='reviewer.store') ? url($action): route($action) }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="id_reviewer" value="{{ ($action!='reviewer.store') ? $reviewer->id_reviewer : '' }}">
    <div class="card-body">
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" name="nama" value="{{ ($action!='reviewer.store') ? $reviewer->nama : '' }}" placeholder="Nama">
        </div>
        <div class="form-group">
            <label for="foto">Foto</label>
            <div class="custom-file">
                <input type="file" name="foto" class="custom-file-input" id="customFile">
                <label class="custom-file-label" name="foto" for="customFile">Choose file</label>
            </div>
            @if($action!='reviewer.store')
            <img src="/image/{{ $reviewer->foto }}" width="100px">
            @endif
        </div>
        <div class="form-group">
            <label for="jabatan">Jabatan</label>
            <input type="text" class="form-control" name="jabatan" value="{{ ($action!='reviewer.store') ? $reviewer->jabatan : '' }}" placeholder="Jabatan">
        </div>
        <div class="form-group">
            <label for="portofolio">Portofolio</label>
            <textarea class="form-control" style="height:150px" name="portofolio" placeholder="Portofolio">{{ ($action!='reviewer.store') ? $reviewer->portofolio : '' }}</textarea>

        </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <input type="submit" class="btn btn-success" value="{{ ($action!='reviewer.store') ? 'Update' : 'Simpan' }}">
    </div>
</form>

@endsection
