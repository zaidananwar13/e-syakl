@extends('master')
@section('judul', 'Show Kelas')
@section('content')


<div class="card-body">

    <div class="row">
        <div class="col-md-4">

            <td><img src="/image/{{ $kelas->gambar }}" width="100px"></td>
        </div>
        <div class="col-md-4">
            <label for="reviewer">Kategori</label>
            @foreach($kategori as $kt)
            @if($kelas->id_kategori == $kt->id_kategori)
            <input type="text" class="form-control" value=" {{ $kt->judul  }}" readonly>
            @endif
            @endforeach

        </div>
        <div class="col-md-4">
            <label for="reviewer">Reviewer</label>
            @foreach($reviewer as $rv)
            @if($kelas->id_reviewer == $rv->id_reviewer)
            <input type="text" class="form-control" value=" {{ $rv->nama  }}" readonly>
            @endif
            @endforeach
        </div>

    </div>

    <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" class="form-control" value=" {{ $kelas->judul  }}" readonly>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="langkah">Langkah</label>

                <input type="text" class="form-control" value=" {{ $kelas->langkah  }}" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="level">Level</label>
                <input type="text" class="form-control" value=" {{ $kelas->level  }}" readonly>

            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="durasi">Durasi</label>
                <input type="text" class="form-control" value=" {{ $kelas->durasi  }}" readonly>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="deskripsi_singkat">Deskripsi Singkat</label>
                <!-- <input type="text" class="form-control" name="deskripsi_singkat" value="{{  $kelas->deskripsi_singkat  }}" placeholder="Deskripsi Singkat"> -->
                <textarea class="form-control" style="height:150px" name="deskripsi_singkat" placeholder="Deskripsi Singkat" readonly>{{ $kelas->deskripsi_singkat  }}</textarea>
            </div>
        </div>
        <div class="col-md-6">

            <div class="form-group">
                <label for="deskripsi_kelas">Deskripsi Kelas</label>
                <!-- <input type="text" class="form-control" name="deskripsi_kelas" value="{{  $kelas->deskripsi_kelas  }}" placeholder="Deskripsi Kelas"> -->
                <textarea class="form-control" style="height:150px" name="deskripsi_kelas" placeholder="Deskripsi Kelas" readonly>{{ $kelas->deskripsi_kelas  }}</textarea>
            </div>
        </div>

    </div>
</div>


</div>
<!-- /.card-body -->

<div class="card-footer">
    <a class="btn btn-success" href="{{ route('kelas.index') }}"> Kembali</a>
</div>


@endsection
