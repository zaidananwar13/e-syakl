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

    .inactive {
        display: none;
    }
</style>



<script>
    let counter = 1, page = 0;

    let nextPage = () => {
        if(counter > page) {
            changePage(++counter, ++page);
        }
    }

    let prevPage = () => {
        if(counter > 1) {        
            changePage(--counter, page);
        }
    }
</script>
@endsection
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

    <div class="container" style="padding: 0;">
        <form role="form" action="{{($action!='quiz.store') ? url("quiz/update"): route($action) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" id="old_id_quiz_container" value="{{ $quiz->id_kategori_silabus }}" name="old_id_quiz_container"/>
            <input type="hidden" id="id_quiz_container" value="{{ $quiz->id_quiz_container }}" name="id_quiz_container"/>
        
            <div class="container-fluid">
                <div id="container-soal">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="tipe_soal">Silabus</label>
                                <select id="tipe_soal" class="form-control mb-4" name="id_silabus">            
                                    @foreach ($silabus as $silab)
                                    <option {{ ($quiz->id_kategori_silabus == $silab->id_kategori_silabus) ? "selected" : "" }} value="{{ $silab->id_kategori_silabus }}"> {{ $silab->id_kategori_silabus }} - {{ $silab->judul }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="desc">Deskripsi Quiz</label>
                                <textarea id="desc" class="form-control" name="desc" rows="5">{{ ($action!='quiz.store') ? $quiz->desc : '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr>


                </div>
                
                
                
                <!-- /.card-body -->

                <div class="card-footer mt-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="submit" class="btn btn-success" value="{{ ($action!='quiz.store') ? 'Update' : 'Simpan' }}">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>

@endsection
@section('js')
<script type="text/javascript" src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
<script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    // let counter = 0;
    let createCKEditor = (id) => {
        let konten = document.getElementById(id);
        let editor = CKEDITOR;
        CKFinder.setupCKEditor(editor);

        editor.replace(konten,{
            language:'en-gb'
        });
        editor.editorconfig.allowedContent = true;
    }

    createCKEditor("desc");
</script>
</body>
@endsection