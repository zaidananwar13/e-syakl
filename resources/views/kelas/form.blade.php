@extends('home/master2')
@section('judul', 'Form Kelas')
@section('data-controller', 'active')
@section('kelas', 'text-active')
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

    .table-hover tr:hover {
        cursor: pointer;
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
    
    <form action="{{($action!='kelas.store') ? url($action): route($action) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="id_kelas" value="{{ ($action!='kelas.store') ? $kelas->id_kelas : '' }}">
        <div class="card-body form-section">
            <!-- <div class="form-group mb-4">
                <label for="exampleInputEmail1">Kategori</label>
                <input type="text" class="form-control" name="id_kategori" value="{{ ($action!='kelas.store') ? $kelas->id_kategori : '' }}" placeholder="Nama">
            </div> -->
            <div class="row">
                <div class="col-md-6">
                    <label for="kategori">Kategori</label>
                    <select class="form-control" id="id_kategori" name="id_kategori">
                        @foreach ($kategori as $key => $value)
                        <option value="{{ $value->id_kategori }}" @if($action !="kelas.store" && $value->id_kategori == $kelas->id_kategori) selected="selected" @endif>
                            {{ $value->judul }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="reviewer">Reviewer</label>
                    <select class="form-control" id="id_reviewer" name="id_reviewer">
                        @foreach ($reviewer as $key => $value)
                        <option value="{{ $value->id_reviewer }}" @if($action !="kelas.store" && $value->id_reviewer == $kelas->id_reviewer) selected="selected" @endif>
                            {{ $value->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="form-group mb-4">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ ($action!='kelas.store') ? $kelas->judul : '' }}" placeholder="Judul">
            </div>
            <div class="form-group mb-4">
                <label for="gambar">Gambar</label>
                <!-- <input type="text" class="form-control" id="gambar" name="gambar" value="{{ ($action!='kelas.store') ? $kelas->gambar : '' }}" placeholder="Gambar"> -->
                <div class="custom-file">
                    <input type="file" id="gambar" name="gambar" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                @if($action!='kelas.store')
                <img src="/image/{{ $kelas->gambar }}" width="100px">
                @endif
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="langkah">Langkah</label>
                        <input type="text" class="form-control" id="langkah" name="langkah" value="{{ ($action!='kelas.store') ? $kelas->langkah : '' }}" placeholder="Langkah">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="level">Level</label>
                        <input type="text" class="form-control" id="level" name="level" value="{{ ($action!='kelas.store') ? $kelas->level : '' }}" placeholder="Level">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="durasi">Durasi</label>
                        <input type="text" class="form-control" id="durasi" name="durasi" value="{{ ($action!='kelas.store') ? $kelas->durasi : '' }}" placeholder="Durasi">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-4">
                        <label for="deskripsi_singkat">Deskripsi Singkat</label>
                        <!-- <input type="text" class="form-control" id="deskripsi_singkat" name="deskripsi_singkat" value="{{ ($action!='kelas.store') ? $kelas->deskripsi_singkat : '' }}" placeholder="Deskripsi Singkat"> -->
                        <textarea class="form-control" style="height:150px" id="deskripsi_singkat" name="deskripsi_singkat" placeholder="Deskripsi Singkat">{{ ($action!='kelas.store') ? $kelas->deskripsi_singkat : '' }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group mb-4">
                        <label for="deskripsi_kelas">Deskripsi Kelas</label>
                        <!-- <input type="text" class="form-control" id="deskripsi_kelas" name="deskripsi_kelas" value="{{ ($action!='kelas.store') ? $kelas->deskripsi_kelas : '' }}" placeholder="Deskripsi Kelas"> -->
                        <textarea class="form-control" style="height:150px" id="deskripsi_kelas" name="deskripsi_kelas" placeholder="Deskripsi Kelas">{{ ($action!='kelas.store') ? $kelas->deskripsi_kelas : '' }}</textarea>
                    </div>
                </div>

            </div>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <a href="#" onclick="addSilabus()" class="btn btn-primary"><i class="fas fa-envelope-open-text fs-4 me-2"></i> Tambah silabus baru</a>
                </div>
            </div>
        </div>

        <div class="modal-container">
        </div>

        <div class="card-footer">
            <button type="submit" id="btnSubmit" class="btn btn-success">{{ ($action!='kelas.store') ? 'Update' : 'Simpan' }}</button>
        </div>
    </form>

        
    <div id="form-container">
    </div>
</div>

<script type="text/javascript" src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
<script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    let createCKEditor = (id) => {
        let konten = document.getElementById(id);
        let editor = CKEDITOR;
        CKFinder.setupCKEditor(editor);

        console.log(konten);
        editor.replace(konten,{
            language:'en-gb'
        });
        editor.editorconfig.allowedContent = true;
    }
</script>

<script>
    let node;
    let silabusCount = -1;
    let silabusContainer = [];
    let tempContainer;

    let createElementFromHTML = (htmlString) => {
        var div = document.createElement('div');
        div.innerHTML = htmlString.trim();

        return div.firstChild; 
    }

    let addSilabus = () => {
        let id = ++silabusCount;
        let html = `
        <div class="row mt-4">
            <hr>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="judul">Silabus - ${(id) + 1}</label>
                    <input type="text" class="form-control" name="judul_${id}" id="judul_${id}" placeholder="Judul">
                </div>
                
                <div class="form-group mb-4">
                    <label for="judul">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi_${id}" id="deskripsi_${id}" id="deskripsi" cols="30" rows="10">
                    </textarea>
                </div>
            </div>

            <div class="col-md-6 mt-6">
                <a href="#" onclick="addMateriModal('${id}')" class="btn btn-primary mb-4"><i class="fas fa-envelope-open-text fs-4 me-2"></i> Tambah Materi</a>
                <p class="mb-1">&nbsp;</p>

                <table id="data_produk" class="table table-rounded border table-striped table-row-bordered table-hover">
                    <tbody id="tbody-${id}">
                    </tbody>
                </table>
            </div>
        </div>
        `;
        let node = createElementFromHTML(html);
        document.querySelector(".form-section").appendChild(node);
        silabusContainer.push({
            judul: document.getElementById(`judul_${id}`).value, 
            deskripsi: document.getElementById(`deskripsi_${id}`).value,
            materi: []
        });
    }

    let addMateriModal = (idSilabus) => {
        let idMateri = silabusContainer[idSilabus].materi.length;
        let html = `
        <div class="modal bg-white fade" tabindex="-1" id="kt_modal_${idSilabus}_${idMateri}">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content shadow-none">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>

                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <span class="svg-icon svg-icon-2x"></span>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-4">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" name="modal${idSilabus}_${idMateri}-judul" id="modal${idSilabus}_${idMateri}-judul" value="" placeholder="Judul">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="deskripsi">Deskripsi</label>
                            
                            <input class="form-control" name="modal${idSilabus}_${idMateri}-deskripsi" id="modal${idSilabus}_${idMateri}-deskripsi" value="">
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="konten">Konten</label>
                            
                            <textarea class="form-control" name="modal${idSilabus}_${idMateri}_konten" id="modal${idSilabus}_${idMateri}_konten"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="saveMateri('${idSilabus}', '${checkMateri(idSilabus)}')">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        `;
        let node = createElementFromHTML(html);
        document.querySelector(".modal-container").appendChild(node);
        $(`#kt_modal_${idSilabus}_${idMateri}`).modal('show');
        createCKEditor(`modal${idSilabus}_${idMateri}_konten`);
    }

    let saveMateri = (idSilabus, idMateri) => {
        let id = silabusContainer[idSilabus].materi.length + 1;
        let judul = document.getElementById(`modal${idSilabus}_${idMateri}-judul`).value;

        if(silabusContainer[idSilabus].materi[idMateri] == null) {
            let tr = document.createElement('tr');
            let td1 = document.createElement('td');
            let td2 = document.createElement('td');
            tr.setAttribute('data-bs-toggle', 'modal');
            tr.setAttribute('data-bs-target', `#kt_modal_${idSilabus}_${idMateri}`);

            td1.setAttribute('align', 'center');
            td1.innerHTML = id;

            td2.setAttribute('align', 'center');
            td2.innerHTML = judul;

            tr.appendChild(td1);
            tr.appendChild(td2);

            document.querySelector(`#tbody-${idSilabus}`).appendChild(tr);
            silabusContainer[idSilabus].materi.push({
                judul: document.getElementById(`modal${idSilabus}_${idMateri}-judul`).value,
                deskripsi: document.getElementById(`modal${idSilabus}_${idMateri}-deskripsi`).value,
                konten: CKEDITOR.instances[`modal${idSilabus}_${idMateri}_konten`].getData(),
            });
        }else {
            id = silabusContainer[idSilabus].materi[idMateri].id;
            document.querySelector(`#tbody-${idSilabus}`).children[idMateri].children[0].innerHTML = id;
            document.querySelector(`#tbody-${idSilabus}`).children[idMateri].children[1].innerHTML = judul;
            silabusContainer[idSilabus].materi[idMateri] = {
                judul: document.getElementById(`modal${idSilabus}_${idMateri}-judul`).value,
                deskripsi: document.getElementById(`modal${idSilabus}_${idMateri}-deskripsi`).value,
                konten: CKEDITOR.instances[`modal${idSilabus}_${idMateri}_konten`].getData(),
            };
        }
        
        $(`#kt_modal_${idSilabus}_${idMateri}`).modal('toggle');
    }

    let checkMateri = (idSilabus) => {
        return silabusContainer[idSilabus].materi.length;
    }

    // let verifySilabus = () => {

    //     for(let i = 0; i < silabusContainer.length; i++) {
    //         silabusContainer[i] = {
    //             judul: document.getElementById(`judul_${i}`).value, 
    //             deskripsi: document.getElementById(`deskripsi_${i}`).value,
    //             materi: []
    //         };

    //         for(let j = 0; j < tempContainer[i].materi.length; j++) {
    //             silabusContainer[i].materi.push({
    //                 judul: document.getElementById(`modal${i}_${j}-judul`).value,
    //                 deskripsi: document.getElementById(`modal${i}_${j}-deskripsi`).value,
    //                 konten: document.getElementById(`modal${i}_${j}_konten`).value,
    //             });
    //         }
    //     }
    // }

    // createCKEditor("konten");
</script>

<script>
    document.getElementById("btnSubmit").addEventListener("click", () => {
        // tempContainer = silabusContainer;
        // console.log(tempContainer);
        // // verifySilabus();

        let kelasContainer = {
            "id_kategori": document.getElementById('id_kategori').value,
            "id_reviewer": document.getElementById('id_reviewer').value,
            "judul": document.getElementById('judul').value,
            "gambar": document.getElementById('gambar').value,
            "langkah": document.getElementById('langkah').value,
            "level": document.getElementById('level').value,
            "durasi": document.getElementById('durasi').value,
            "deskripsi_singkat": document.getElementById('deskripsi_singkat').value,
            "deskripsi_kelas": document.getElementById('deskripsi_kelas').value,
            "silabus": silabusContainer
        };
        
        console.log(JSON.stringify(kelasContainer));

    });
</script>

@endsection
