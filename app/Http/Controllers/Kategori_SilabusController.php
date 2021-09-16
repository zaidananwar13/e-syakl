<?php

namespace App\Http\Controllers;

use App\Models\Kategori_Silabus;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Kategori_SilabusController extends Controller
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
            $kategori_silabuss = Kategori_Silabus::all();
            $kelass = Kelas::all();
            $data['kategori_silabus'] = $kategori_silabuss;
            $data['kelas'] = $kelass;
            return view('kategori_silabus.index', $data);
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
            $data['action'] = 'kategori_silabus.store';
            return view('kategori_silabus.form', $data);
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
        // $kategori_silabus = new Kategori_Silabus;
        // $kategori_silabus->id_kelas = $request->id_kelas;
        // $kategori_silabus->judul = $request->judul;

        // $kategori_silabus->save();

        // return redirect('/kategori_silabus');
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $request->validate([
                'id_kelas' => 'required',
                'judul' => 'required'
            ]);

            $input = $request->all();

            Kategori_Silabus::create($input);
            return redirect('/kategori_silabus')->with('success', 'Kategori Silabus Berhasil Ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kategori_Silabus  $kategori_silabus
     * @return \Illuminate\Http\Response
     */
    public function show(Kategori_Silabus $kategori_silabus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kategori_Silabus  $kategori_silabus
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $kelass = Kelas::all();
            $data['kelas'] = $kelass;
            $kategori_silabus = Kategori_Silabus::find($id);
            $data['kategori_silabus'] = $kategori_silabus;
            $data['action'] = 'kategori_silabus/update/';
            return view('kategori_silabus.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kategori_Silabus  $kategori_silabus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kategori_Silabus $kategori_silabus)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $kategori_silabus = Kategori_Silabus::find($request->id_kategori_silabus);
            // $kategori_silabus->id_kelas = $request->id_kelas;
            // $kategori_silabus->judul = $request->judul;
            // $kategori_silabus->save();
            // return redirect('/kategori_silabus');
            $request->validate([
                'id_kelas' => 'required',
                'judul' => 'required'
            ]);

            $input = $request->all();



            $kategori_silabus->update($input);

            return redirect('/kategori_silabus')->with('success', 'Kategori Silabus Berhasil Berubah');
        }
    }
    public function delete($id = "")
    {
        $kategori_silabus = Kategori_Silabus::find($id);
        $data['kategori_silabus'] = $kategori_silabus;
        $kategori_silabus->delete();
        return redirect('/kategori_silabus')->with('success', 'Kategori Silabus Berhasil Dihapus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kategori_Silabus  $kategori_silabus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategori_Silabus $kategori_silabus)
    {
        //
    }
}
