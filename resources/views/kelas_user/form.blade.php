@extends('home/master2')
@section('judul', 'Form Kelas User')
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
    <form role="form" action="{{($action!='kelas_user.store') ? url($action): route($action) }}" method="POST">
        {{ csrf_field() }}
        <input type="hidden" name="id_kelas_user" value="{{ ($action!='kelas_user.store') ? $kelas_user->id_kelas_user : '' }}">
        <div class="card-body">
            <div class="form-group mb-4">
                <label for="id_user">User</label>
                <!-- <input type="text" class="form-control" name="id_user" value="{{ ($action!='kelas_user.store') ? $kelas_user->id_user : '' }}" placeholder="Nama"> -->
                <select class="form-control" name="id_user">
                    @foreach ($user as $key => $value)
                    <option value="{{ $value->id_user }}" @if($action !="kelas_user.store" && $value->id_user == $kelas_user->id_user) selected="selected" @endif>
                        {{ $value->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="id_kelas">Kelas</label>
                <!-- <input type="text" class="form-control" name="id_kelas" value="{{ ($action!='kelas_user.store') ? $kelas_user->id_kelas : '' }}" placeholder="Nama"> -->
                <select class="form-control" name="id_kelas">
                    @foreach ($kelas as $key => $value)
                    <option value="{{ $value->id_kelas }}" @if($action !="kelas_user.store" && $value->id_kelas == $kelas_user->id_kelas) selected="selected" @endif>
                        {{ $value->judul }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="point_review">Point Review</label>
                <input type="text" class="form-control" name="point_review" value="{{ ($action!='kelas_user.store') ? $kelas_user->point_review : '' }}" placeholder="Point Review">
            </div>
            <div class="form-group mb-4">
                <label for="komentar_review">Komentar Review</label>
                <input type="text" class="form-control" name="komentar_review" value="{{ ($action!='kelas_user.store') ? $kelas_user->komentar_review : '' }}" placeholder="Komentar Review">
            </div>



        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="submit" class="btn btn-success" value="{{ ($action!='kelas_user.store') ? 'Update' : 'Simpan' }}">
        </div>
    </form>
</div>

@endsection
