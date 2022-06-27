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
        <form role="form" action="/api/quiz/submit" method="POST">
            {{ csrf_field() }}
            <input type="hidden" value="361241ef5bee6faae7cd7179f28d5d63e1b1528a50de3d446dccbff0869f6dd9" name="api_token">
            <input type="hidden" value="1" name="id_silabus">
            
            <?php $i=1; ?>
            <div class="container">
              <div class="card-columns">
              @foreach ($quizzes as $quiz)
              <div class="card card-bordered mx-auto border-primary mb-4 w-100">
                  <div class="card-header bg-primary">
                      <h3 class="card-title text-white">Soal {{ $i }}</h3>
                  </div>
                  <div class="card-body">
                    <input type="hidden" value="{{ $quiz->id_quiz }}" name="id_quiz_{{ $i }}"/>
                    <p class="font-weight-bold">{{ $quiz['soal'] }}</p>

                      @foreach (explode(',', $quiz->pilihan) as $pilih)
                      <div class="form-check form-check-custom form-check-solid">
                          <input class="form-check-input" name="pilihan_{{ $i }}" type="radio" value="{{ $pilih }}" id="flexCheckDefault_{{ $i }}"/>
                          <label class="form-check-label" for="flexCheckDefault_{{ $i }}">
                            {{ ucfirst($pilih) }}
                          </label>
                      </div>
                      @endforeach
                  </div>
              </div>
              <?php $i++; ?>
              @endforeach
              </div>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
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
    // let createCKEditor = (id) => {
    //     let konten = document.getElementById(id);
    //     let editor = CKEDITOR;
    //     CKFinder.setupCKEditor(editor);

    //     editor.replace(konten,{
    //         language:'en-gb'
    //     });
    //     editor.editorconfig.allowedContent = true;
    // }

    // createCKEditor("konten");
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