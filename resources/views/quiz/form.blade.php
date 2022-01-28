@extends('home/master2')
@section('judul', 'Form Data Quiz')
@section('data-controller', 'active')
@section('quiz', 'text-active')
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
    <form role="form" action="{{($action!='quiz.store') ? url($action): route($action) }}" method="POST">
        {{ csrf_field() }}
        <div class="card-body" id="form-body">
            
            
            <div class="form-group mb-4">
                <label for="konten">Soal</label>
                <textarea class="form-control" name="deskripsi" id="konten" cols="30" rows="10">{{ ($action!='quiz.store') ? $quiz->soal : '' }}</textarea>
            </div>


            <label for="tipe_soal">Tipe Soal</label>
            <select id="tipe_soal" class="form-control mb-4" name="tipe_soal">
                <option value="radio">Pilihan</option>
                <option value="checkbox">Pilihan Ganda</option>
                <option value="text">Tulis Teks</option>
            </select>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <a onclick="addPilihan('tipe_soal', '1')" class="btn btn-primary"><i class="fas fa-envelope-open-text fs-4 me-2"></i> Tambah Pilihan</a>
                </div>
            </div>

            <!-- <div class="container-soal-1 mt-4">

                <div class="form-check form-check-custom form-check-solid">
                    <input class="form-check-input" name="radio-soal-1" type="radio" value="" id="flexRadioDefault"/>
                    <label class="form-check-label" for="flexRadioDefault">
                        Default radio
                    </label>
                </div>
            </div> -->

        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <input type="submit" class="btn btn-success" value="{{ ($action!='quiz.store') ? 'Update' : 'Simpan' }}">
        </div>
    </form>

</div>

@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
<script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    let counter = 0;
    let createCKEditor = (id) => {
        let konten = document.getElementById(id);
        let editor = CKEDITOR;
        CKFinder.setupCKEditor(editor);

        editor.replace(konten,{
            language:'en-gb'
        });
        editor.editorconfig.allowedContent = true;
    }

    createCKEditor("konten");
</script>

<script>
    let createElementFromHTML = (htmlString) => {
        var div = document.createElement('div');
        div.innerHTML = htmlString.trim();

        return div.firstChild; 
    }

    let addPilihan = (tipe, order) => {
        let container =  document.querySelector(`.container-soal-${order}`);
        let html = `
            <div class="container-soal-1 mt-4">
            </div>
        `;
        let node = createElementFromHTML(html);

        if(container == null) {
            document.querySelector("#form-body").appendChild(node);
            
            container =  document.querySelector(`.container-soal${order}`);
        }
        
        html = `
            <div class="form-check form-check-custom form-check-solid">
                <input class="form-check-input" type="radio" name="jawaban-${tipe}" value="pilihan-${order}" id="radio-${tipe}"/>
                <label contenteditable="true" class="form-check-label" for="flexRadioDefault">
                    Default radio
                </label>
            </div>
        `;

        node = createElementFromHTML(html); 
        container.appendChild(node);
    }
</script>
</body>
@endsection