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
        <form role="form" action="{{($action!='quiz.store') ? url($action): route($action) }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" id="count" value="1" name="count"/>
        
            <div class="container-fluid">
                <div id="container-soal">
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <label for="tipe_soal">Silabus</label>
                                <select id="tipe_soal" class="form-control mb-4" name="id_silabus">            
                                    @foreach ($silabus as $silab)
                                    <option value="{{ $silab->id_kategori_silabus }}"> {{ $silab->id_kategori_silabus }} - {{ $silab->judul }}</option>
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

                    <div class="card-body" id="page-0">                    
                        <div class="row">
                            <div class="col-md-8">
                                <label for="konten"><h3>Soal No. 1</h3></label>
                                <textarea class="form-control" name="soal-0" rows="5">{{ ($action!='quiz.store') ? $quiz->soal : '' }}</textarea>
                            </div>

                            <div class="col-md-4 mt-3">
                                <label for="tipe_soal">Tipe Soal</label>
                                <select id="tipe_soal" class="form-control mb-4" name="tipe_soal-0">
                                    <option value="radio">Pilihan</option>
                                    <option value="text">Text</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-4">
                        
                            <div class="mb-0">
                                <label class="form-label">Pilihan</label>
                                <input name="pilihan-0" class="form-control" placeholder="Masukkan pilihan" id="kt_tagify_1" />
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Jawaban</label>
                                <input name="kunci-0" class="form-control form-control-solid" placeholder="Masukkan Jawaban" id="kt_tagify_2" />
                            </div>
                        
                        </div>
                        

                    </div>


                </div>
                
                
                
                <!-- /.card-body -->

                <div class="card-footer mt-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="submit" class="btn btn-success" value="{{ ($action!='quiz.store') ? 'Update' : 'Simpan' }}">
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4" style="display: flex; justify-content: space-evenly;">
                            <p class="btn btn-secondary" onclick="prevPage()">Previous</p>
                            <p class="btn btn-primary" onclick="nextPage()">Next</p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>

@endsection

@section('js')
<script>
    
    // The DOM elements you wish to replace with Tagify
    var input1 = document.querySelector("#kt_tagify_1");
    var input2 = document.querySelector("#kt_tagify_2");

    // Initialize Tagify components on the above inputs
    var tag1 = new Tagify(input1);
    var tag2 = new Tagify(input2);

</script>

<script>
    var createElementFromHTML = (htmlString) => {
        var div = document.createElement('div');
        div.innerHTML = htmlString.trim();

        return div.firstChild; 
    }

    var changePage = (count, page) => {
        if(count > page) {
            let container =  document.querySelector(`#container-soal`);
            let html = `
                <div class="card-body" id="page-${page}">                    
                    <div class="row">
                        <div class="col-md-8">
                            <label for="konten"><h3>Soal No. ${(page + 1)}</h3></label>
                            <textarea class="form-control" name="soal-${page}" rows="5">{{ ($action!='quiz.store') ? $quiz->soal : '' }}</textarea>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label for="tipe_soal">Tipe Soal</label>
                            <select id="tipe_soal" class="form-control mb-4" name="tipe_soal-${page}">
                                <option value="radio">Pilihan</option>
                                <option value="checkbox">Pilihan Ganda</option>
                                <option value="text">Tulis Teks</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="mb-10">
                            <label class="form-label">Pilihan</label>
                            <input name="pilihan-${page}" class="form-control" placeholder="Masukkan Pilihan" id="kt_tagify_1_${page}" />
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Jawaban</label>
                            <input name="kunci-${page}" class="form-control form-control-solid" placeholder="Masukkan Jawaban" id="kt_tagify_2_${page}" />
                        </div>
                    
                    </div>
                    

                </div>
            `;
            let node = createElementFromHTML(html);
            container.appendChild(node);

            var input1 = document.querySelector(`#kt_tagify_1_${page}`);
            var input2 = document.querySelector(`#kt_tagify_2_${page}`);
            new Tagify(input1);
            new Tagify(input2);

            let val = document.querySelector("#count").value;
            val++;

            document.querySelector("#count").value = val;

            document.querySelector(`#page-${(counter - 2)}`).style.display = "none";
        }else {
            document.querySelector(`#page-${(counter - 2)}`).style.display = "none";
        }

        console.log("page: " + page);
    }
</script>

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

<script>

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