<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Kelas;
use App\Models\Kategori;
use App\Models\Reviewer;
use Illuminate\Http\Request;

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
            // $request->validate([
            //     'id_kategori' => 'required',
            //     'id_reviewer' => 'required',
            //     'judul' => 'required',
            //     'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            //     'langkah' => 'required',
            //     'level' => 'required',
            //     'deskripsi_singkat' => 'required',
            //     'durasi' => 'required',
            //     'deskripsi_kelas' => 'required',
            // ]);

            header('Content-Type: application/json; charset=utf-8');
            // $input = $request->all();
            // $input['tipe_kelas'] = false;


            // if ($image = $request->file('gambar')) {
            //     $destinationPath = 'image/';
            //     $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            //     $image->move($destinationPath, $profileImage);
            //     $input['gambar'] = "$profileImage";
            // }

            $data = $request->data;
            var_dump($data);

            die;
            Kelas::create($input);
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
