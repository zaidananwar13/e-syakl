<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KategoriController extends Controller
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
            $kategoris = Kategori::all();
            $kelass = Kelas::all();
            $data['kategori'] = $kategoris;
            $data['kelas'] = $kelass;
            return view('kategori.index', $data);
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
            $kelass = Kelas::all();
            $data['kelas'] = $kelass;
            $data['action'] = 'kategori.store';
            return view('kategori.form', $data);
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
        // $kategori = new Kategori;
        // $kategori->judul = $request->judul;
        // $kategori->gambar = $request->gambar;
        // $kategori->deskripsi = $request->deskripsi;
        // $kategori->save();

        // return redirect('/kategori');
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $request->validate([
                'judul' => 'required',
                'deskripsi' => 'required',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($image = $request->file('gambar')) {
                $destinationPath = 'image/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['gambar'] = "$profileImage";
            }
            Kategori::create($input);
            return redirect('/kategori')->with('success', 'Kategori Berhasil Ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategori $kategori)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $kategori = Kategori::find($kategori->id_kategori);
            $data['kategori'] = $kategori;
            $data['action'] = 'kategori/update/';
            return view('kategori.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori $kategori)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $kategori = Kategori::find($request->id_kategori);
            $request->validate([
                'judul' => 'required',
                'deskripsi' => 'required'
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

            $kategori->update($input);

            return redirect('/kategori')->with('success', 'Instansi Berhasil Berubah');
        }
    }
    public function delete($id = "")
    {
        $kategori = Kategori::find($id);
        $data['kategori'] = $kategori;
        $kategori->delete();
        return redirect('/kategori')->with('success', 'Kategori Berhasil Dihapus.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori  $kategori
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori $kategori)
    {
        //
    }
}
