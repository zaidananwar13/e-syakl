<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InstansiController extends Controller
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
            $instansis = Instansi::all();
            $data['instansi'] = $instansis;
            return view('instansi.index', $data);
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
            $data['action'] = 'instansi.store';
            return view('instansi.form', $data);
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
        // $instansi = new Instansi;
        // $instansi->nama = $request->nama;
        // $instansi->lokasi = $request->lokasi;
        // $instansi->foto = $request->foto;
        // $instansi->save();

        // return redirect('/instansi');
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $request->validate([
                'nama' => 'required',
                'lokasi' => 'required',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($image = $request->file('foto')) {
                $destinationPath = 'image/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['foto'] = "$profileImage";
            }


            Instansi::create($input);

            return redirect('/instansi')->with('success', 'Instansi Berhasil Ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instansi  $instansi
     * @return \Illuminate\Http\Response
     */
    public function show(Instansi $instansi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Instansi  $instansi
     * @return \Illuminate\Http\Response
     */
    public function edit(Instansi $instansi)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $instansi = Instansi::find($instansi->id_instansi);
            $data['instansi'] = $instansi;
            $data['action'] = 'instansi/update/';
            return view('instansi.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instansi  $instansi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Instansi $instansi)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $instansi = Instansi::find($request->id_instansi);
            $request->validate([
                'nama' => 'required',
                'lokasi' => 'required'
            ]);

            $input = $request->all();

            if ($image = $request->file('foto')) {
                $destinationPath = 'image/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['foto'] = "$profileImage";
            } else {
                unset($input['foto']);
            }

            $instansi->update($input);

            return redirect('/instansi')->with('success', 'Instansi Berhasil Berubah');
        }
    }
    public function delete($id = "")
    {
        $instansi = Instansi::find($id);
        $data['instansi'] = $instansi;
        $instansi->delete();
        return redirect('/instansi')->with('success', 'Instansi Berhasil Dihapus.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instansi  $instansi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instansi $instansi)
    {
        //
    }
}
