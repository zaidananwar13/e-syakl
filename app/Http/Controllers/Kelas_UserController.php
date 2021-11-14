<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Kelas_User;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;

class Kelas_UserController extends Controller
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
            $kelas_users = Kelas_User::all();
            $data['kelas_user'] = $kelas_users;
            $kelass = Kelas::all();
            $data['kelas'] = $kelass;
            $users = User::all();
            $data['user'] = $users;
            return view('kelas_user.index', $data);
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
            $users = User::all();

            $data['user'] = $users;
            $data['action'] = 'kelas_user.store';
            return view('kelas_user.form', $data);
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
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            // $kelas_user = new Kelas_User;
            // $kelas_user->id_user = $request->id_user;
            // $kelas_user->id_kelas = $request->id_kelas;
            // $kelas_user->point_review = $request->point_review;
            // $kelas_user->komentar_review = $request->komentar_review;
            // $kelas_user->save();

            // return redirect('/kelas_user');
            $request->validate([
                'id_user' => 'required',
                'id_kelas' => 'required',
                'point_review' => 'required',
                'komentar_review' => 'required'
            ]);

            $input = $request->all();

            Kelas_User::create($input);
            return redirect('/kelas_user')->with('success', 'Kelas User Berhasil Ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas_User  $kelas_user
     * @return \Illuminate\Http\Response
     */
    public function show(Kelas_User $kelas_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas_User  $kelas_user
     * @return \Illuminate\Http\Response
     */
    public function edit(Kelas_User $kelas_user)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $kelas_user = Kelas_User::find($kelas_user->id_kelas_user);
            $data['kelas_user'] = $kelas_user;
            $kelass = Kelas::all();
            $data['kelas'] = $kelass;
            $users = User::all();
            $data['user'] = $users;
            $data['action'] = 'kelas_user/update/';
            return view('kelas_user.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas_User  $kelas_user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelas_User $kelas_user)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $kelas_user = Kelas_User::find($request->id_kelas_user);
            // $kelas_user->id_user = $request->id_user;
            // $kelas_user->id_kelas = $request->id_kelas;
            // $kelas_user->point_review = $request->point_review;
            // $kelas_user->komentar_review = $request->komentar_review;
            // $kelas_user->save();
            // return redirect('/kelas_user');
            $request->validate([
                'id_user' => 'required',
                'id_kelas' => 'required',
                'point_review' => 'required',
                'komentar_review' => 'required'
            ]);

            $input = $request->all();
            $kelas_user->update($input);

            return redirect('/kelas_user')->with('success', 'Kelas User Berhasil Berubah');
        }
    }
    public function delete($id = "")
    {
        $kelas_user = Kelas_User::find($id);
        $data['kelas_user'] = $kelas_user;
        $kelas_user->delete();
        return redirect('/kelas_user')->with('success', 'Kelas User Berhasil Berubah');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas_User  $kelas_user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kelas_User $kelas_user)
    {
        //
    }
}
