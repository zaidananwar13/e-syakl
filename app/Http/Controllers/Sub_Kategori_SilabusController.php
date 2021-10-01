<?php

namespace App\Http\Controllers;

use App\Models\Kategori_Silabus;
use App\Models\Sub_Kategori_Silabus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Sub_Kategori_SilabusController extends Controller
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
            $sub_kategori_silabuss = Sub_Kategori_Silabus::all();
            $data['sub_kategori_silabus'] = $sub_kategori_silabuss;
            $kategori_silabuss = Kategori_Silabus::all();
            $data['kategori_silabus'] = $kategori_silabuss;
            return view('sub_kategori_silabus.index', $data);
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
            $kategori_silabuss = Kategori_Silabus::all();
            $data['kategori_silabus'] = $kategori_silabuss;
            $data['action'] = 'sub_kategori_silabus.store';
            return view('sub_kategori_silabus.form', $data);
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
        // $sub_kategori_silabus = new Sub_Kategori_Silabus;
        // $sub_kategori_silabus->id_kategori_silabus = $request->id_kategori_silabus;
        // $sub_kategori_silabus->judul = $request->judul;

        // $sub_kategori_silabus->save();

        // return redirect('/sub_kategori_silabus');
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $request->validate([
                'id_kategori_silabus' => 'required',
                'judul' => 'required',
                'konten' => 'required'
            ]);

            $input = $request->all();

            Sub_Kategori_Silabus::create($input);
            return redirect('/sub_kategori_silabus')->with('success', 'Sub Kategori Silabus Berhasil Ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sub_Kategori_Silabus  $sub_kategori_silabus
     * @return \Illuminate\Http\Response
     */
    public function show(Sub_Kategori_Silabus $sub_kategori_silabus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sub_Kategori_Silabus  $sub_kategori_silabus
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $kategori_silabuss = Kategori_Silabus::all();
            $data['kategori_silabus'] = $kategori_silabuss;
            $sub_kategori_silabus = Sub_Kategori_Silabus::find($id);
            $data['sub_kategori_silabus'] = $sub_kategori_silabus;
            $data['action'] = 'sub_kategori_silabus/update/';
            return view('sub_kategori_silabus.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sub_Kategori_Silabus  $sub_kategori_silabus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sub_Kategori_Silabus $sub_kategori_silabus)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $sub_kategori_silabus = Sub_Kategori_Silabus::find($request->id_sub_kategori_silabus);
            // $sub_kategori_silabus->id_kategori_silabus = $request->id_kategori_silabus;
            // $sub_kategori_silabus->judul = $request->judul;
            // $sub_kategori_silabus->save();
            // return redirect('/sub_kategori_silabus');
            $request->validate([
                'id_kategori_silabus' => 'required',
                'judul' => 'required',
                'konten' => 'required'
            ]);

            $input = $request->all();

            $sub_kategori_silabus->update($input);

            return redirect('/sub_kategori_silabus')->with('success', 'Sub Kategori Silabus Berhasil Berubah');
        }
    }
    public function delete($id = "")
    {
        $sub_kategori_silabus = Sub_Kategori_Silabus::find($id);
        $data['sub_kategori_silabus'] = $sub_kategori_silabus;
        $sub_kategori_silabus->delete();
        return redirect('/sub_kategori_silabus')->with('success', 'Sub Kategori Silabus Berhasil Dihapus');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sub_Kategori_Silabus  $sub_kategori_silabus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sub_Kategori_Silabus $sub_kategori_silabus)
    {
        //
    }
}
