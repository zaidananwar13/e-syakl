@extends('master')
@section('judul', 'Form Kelas')
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
<form action="{{($action!='kelas.store') ? url($action): route($action) }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="id_kelas" value="{{ ($action!='kelas.store') ? $kelas->id_kelas : '' }}">
    <div class="card-body">
        <!-- <div class="form-group">
            <label for="exampleInputEmail1">Kategori</label>
            <input type="text" class="form-control" name="id_kategori" value="{{ ($action!='kelas.store') ? $kelas->id_kategori : '' }}" placeholder="Nama">
        </div> -->
        <div class="row">
            <div class="col-md-6">
                <label for="kategori">Kategori</label>
                <select class="form-control" name="id_kategori">
                    @foreach ($kategori as $key => $value)
                    <option value="{{ $value->id_kategori }}" @if($action !="kelas.store" && $value->id_kategori == $kelas->id_kategori) selected="selected" @endif>
                        {{ $value->judul }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="reviewer">Reviewer</label>
                <select class="form-control" name="id_reviewer">
                    @foreach ($reviewer as $key => $value)
                    <option value="{{ $value->id_reviewer }}" @if($action !="kelas.store" && $value->id_reviewer == $kelas->id_reviewer) selected="selected" @endif>
                        {{ $value->nama }}
                    </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" class="form-control" name="judul" value="{{ ($action!='kelas.store') ? $kelas->judul : '' }}" placeholder="Judul">
        </div>
        <div class="form-group">
            <label for="gambar">Gambar</label>
            <!-- <input type="text" class="form-control" name="gambar" value="{{ ($action!='kelas.store') ? $kelas->gambar : '' }}" placeholder="Gambar"> -->
            <div class="custom-file">
                <input type="file" name="gambar" class="custom-file-input" id="customFile">
                <label class="custom-file-label" name="gambar" for="customFile">Choose file</label>
            </div>
            @if($action!='kelas.store')
            <img src="/image/{{ $kelas->gambar }}" width="100px">
            @endif
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="langkah">Langkah</label>
                    <input type="text" class="form-control" name="langkah" value="{{ ($action!='kelas.store') ? $kelas->langkah : '' }}" placeholder="Langkah">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="level">Level</label>
                    <input type="text" class="form-control" name="level" value="{{ ($action!='kelas.store') ? $kelas->level : '' }}" placeholder="Level">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="durasi">Durasi</label>
                    <input type="text" class="form-control" name="durasi" value="{{ ($action!='kelas.store') ? $kelas->durasi : '' }}" placeholder="Durasi">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="deskripsi_singkat">Deskripsi Singkat</label>
                    <!-- <input type="text" class="form-control" name="deskripsi_singkat" value="{{ ($action!='kelas.store') ? $kelas->deskripsi_singkat : '' }}" placeholder="Deskripsi Singkat"> -->
                    <textarea class="form-control" style="height:150px" name="deskripsi_singkat" placeholder="Deskripsi Singkat">{{ ($action!='kelas.store') ? $kelas->deskripsi_singkat : '' }}</textarea>
                </div>
            </div>
            <div class="col-md-6">

                <div class="form-group">
                    <label for="deskripsi_kelas">Deskripsi Kelas</label>
                    <!-- <input type="text" class="form-control" name="deskripsi_kelas" value="{{ ($action!='kelas.store') ? $kelas->deskripsi_kelas : '' }}" placeholder="Deskripsi Kelas"> -->
                    <textarea class="form-control" style="height:150px" name="deskripsi_kelas" placeholder="Deskripsi Kelas">{{ ($action!='kelas.store') ? $kelas->deskripsi_kelas : '' }}</textarea>
                </div>
            </div>

        </div>
    </div>


    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <input type="submit" class="btn btn-success" value="{{ ($action!='kelas.store') ? 'Update' : 'Simpan' }}">
    </div>
</form>

@endsection
