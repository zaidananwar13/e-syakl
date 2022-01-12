<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Kelas;
use App\Models\Kategori;
use App\Models\Kategori_Silabus;
use App\Models\Sub_Kategori_Silabus;
use App\Models\Reviewer;
use Illuminate\Http\Request;
use KategoriSilabus;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $reviewers = Reviewer::all();
            $data['reviewer'] = $reviewers;
            $kategoris = Kategori::all();
            $data['kategori'] = $kategoris;
            $kelass = Kelas::all();
            $data['kelas'] = $kelass;
            return view('kelas.index', $data);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $reviewers = Reviewer::all();
            $kategoris = Kategori::all();
            $data['reviewer'] = $reviewers;

            $data['kategori'] = $kategoris;
            $data['action'] = 'kelas.store';
            return view('kelas.form', $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        header('Content-Type: application/json; charset=utf-8');
        $dataForm = $request->all();

        foreach($dataForm as $key => $val) {
            if(strpos($key, 'judul_') !== false || strpos($key, 'deskripsi_') !== false && $key != "deskripsi_singkat" && $key != "deskripsi_kelas") {               
                $silabus[]= [$key => $val];
            }
            
            if(strpos($key, "modal") !== false) {               
                $materi[]= [$key => $val];
            }
        }

        // Silabus decrypt
        $count = 0;
        for($i = 1; $i <= count($silabus); $i++) {

            if($i % 2 != 0) {
                $dataSilabus[]= [
                    "judul" => $silabus[$i-1]["judul_" . $count],
                    "deskripsi" => $silabus[$i]["deskripsi_" . $count],
                    "materi" => []
                ];
                $count++;
            }
        }

        // Materi decrypt
        $count = 0;
        $count2 = 0;
        $count3 = 0;

        $dataMateri[$count] = [];
        for($i = 0; $i < count($materi); $i++) {
            if($i % 3 == 0) {
                foreach($materi as $key => $val) {
		    $tempKey = array_keys($val);
		    $tempKey = $tempKey[0];
                    if(strpos($tempKey, "modal" . $count . "_") !== false ) {
                        $count2++;
                    }$count3 = $count2 / 3;
                }

		var_dump("count1: " . $count);
		var_dump("count2: " . $count2);
		var_dump("count3: " . $count3);

		for($c = 0; $c < $count3; $c++) {
		
		}

/*                $tempData = [
                    "judul" => $materi[$i]["modal" . $count . "_" . $count2 .  "-judul"],
                    "deskripsi" => $materi[$i + 1]["modal" . $count . "_" . $count2 .  "-deskripsi"],
                    "konten" => $materi[$i + 2]["modal" . $count . "_" . $count2 .  "_konten"],
                ];

                array_push($dataMateri[$count], $tempData); 
*/
                $count++;
		$count2 = 0;
                $dataMateri[$count] = [];
            }
        }array_pop($dataMateri);

        
        for($i = 0; $i < count($dataMateri); $i++) {
            for($j = 0; $j < count($dataMateri[$i]); $j++) {
                array_push($dataSilabus[$i]["materi"], $dataMateri[$i][$j]);
            }
        }

	var_dump($dataMateri); die;

        // $kelas = new Kelas;
        // $kelas->id_kategori = $request->id_kategori;
        // $kelas->id_reviewer = $request->id_reviewer;
        // $kelas->judul = $request->judul;
        // $kelas->gambar = $request->gambar;
        // $kelas->langkah = $request->langkah;
        // $kelas->level = $request->level;
        // $kelas->deskripsi_singkat = $request->deskripsi_singkat;
        // $kelas->durasi = $request->durasi;
        // $kelas->deskripsi_kelas = $request->deskripsi_kelas;
        // $kelas->save();


        // return redirect('/kelas');
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $request->validate([
                'id_kategori' => 'required',
                'id_reviewer' => 'required',
                'judul' => 'required',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'langkah' => 'required',
                'level' => 'required',
                'deskripsi_singkat' => 'required',
                'durasi' => 'required',
                'deskripsi_kelas' => 'required',
            ]);

            $input = $request->all();
            $input['tipe_kelas'] = false;


            if ($image = $request->file('gambar')) {
                $destinationPath = 'image/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['gambar'] = "$profileImage";
            }

            $idKelas = Kelas::create($input);
            $idKelas = $idKelas->id_kelas;

            // Inserting Silabus
            foreach($dataSilabus as $dS) {
                $input = [
                    "id_kelas" => $idKelas,
                    "judul" => $dS["judul"],
                    "deskripsi" => $dS["deskripsi"]
                ];

                $idSilabus = Kategori_Silabus::create($input);
                $idSilabus = $idSilabus->id_kategori_silabus;

                // Inserting Materi
                foreach($dS["materi"] as $dSM) {
                    $input = [
                        "id_kategori_silabus" => $idSilabus,
                        "judul" => $dSM["judul"],
                        "deskripsi" => $dSM["deskripsi"],
                        "konten" => $dSM["konten"]
                    ];
                    
                    Sub_Kategori_Silabus::create($input);
                }
                
            }

            return redirect('/kelas')->with('success', 'Kelas Berhasil Ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reviewers = Reviewer::all();
        $kategoris = Kategori::all();
        $data['reviewer'] = $reviewers;
        $data['kategori'] = $kategoris;
        $kelas = Kelas::find($id);
        $data['kelas'] = $kelas;
        return view('kelas.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $reviewers = Reviewer::all();
            $kategoris = Kategori::all();
            $data['reviewer'] = $reviewers;
            $data['kategori'] = $kategoris;
            $kelas = Kelas::find($id);
            $data['kelas'] = $kelas;
            $data['action'] = 'kelas/update/';
            return view('kelas.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas $kelas)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $kelas = Kelas::find($request->id_kelas);
            $request->validate([
                'id_kategori' => 'required',
                'id_reviewer' => 'required',
                'judul' => 'required',
                'langkah' => 'required',
                'level' => 'required',
                'deskripsi_singkat' => 'required',
                'durasi' => 'required',
                'deskripsi_kelas' => 'required',
            ]);

            $input = $request->all();

            if ($image = $request->file('gambar')) {
                $destinationPath = 'image/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['gambar'] = "$profileImage";
            } else {
                unset($input['gambar']);
            }

            $kelas->update($input);

            return redirect('/kelas')->with('success', 'Kelas Berhasil Berubah');
        }
    }
    public function delete($id = "")
    {
        $kelas = Kelas::find($id);
        $data['kelas'] = $kelas;
        $kelas->delete();
        return redirect('/kelas')->with('success', 'Kelas Berhasil Dihapus');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas $kelas)
    {
        //
    }
}
