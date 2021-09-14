<?php

namespace App\Http\Controllers;

use App\Models\Reviewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewerController extends Controller
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
            return view('reviewer.index', $data);
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
            $data['action'] = 'reviewer.store';
            return view('reviewer.form', $data);
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
        // $reviewer = new Reviewer;
        // $reviewer->nama = $request->nama;
        // $reviewer->jabatan = $request->jabatan;
        // $reviewer->foto = $request->foto;
        // $reviewer->portofolio = $request->portofolio;
        // $reviewer->save();

        // return redirect('/reviewer');
        // $idn = [
        //     'required'=>':'
        // ]
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $request->validate([
                'nama' => 'required',
                'jabatan' => 'required',
                'portofolio' => 'required',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $input = $request->all();

            if ($image = $request->file('foto')) {
                $destinationPath = 'image/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['foto'] = "$profileImage";
            }
            Reviewer::create($input);
            return redirect('/reviewer')->with('success', 'Reviewer Berhasil Ditambahkan.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reviewer  $reviewer
     * @return \Illuminate\Http\Response
     */
    public function show(Reviewer $reviewer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reviewer  $reviewer
     * @return \Illuminate\Http\Response
     */
    public function edit(Reviewer $reviewer)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $reviewer = Reviewer::find($reviewer->id_reviewer);
            $data['reviewer'] = $reviewer;
            $data['action'] = 'reviewer/update/';
            return view('reviewer.form', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reviewer  $reviewer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reviewer $reviewer)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $reviewer = Reviewer::find($request->id_reviewer);
            // $reviewer->nama = $request->nama;
            // $reviewer->jabatan = $request->jabatan;
            // $reviewer->foto = $request->foto;
            // $reviewer->portofolio = $request->portofolio;
            // $reviewer->save();
            // return redirect('/reviewer');
            $request->validate([
                'nama' => 'required',
                'jabatan' => 'required',
                'portofolio' => 'required'
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

            $reviewer->update($input);

            return redirect('/reviewer')->with('success', 'Reviewer Berhasil Berubah');
        }
    }
    public function delete($id = "")
    {
        $reviewer = Reviewer::find($id);
        $data['reviewer'] = $reviewer;
        $reviewer->delete();
        return redirect('/reviewer')->with('success', 'Reviewer Berhasil Berubah');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reviewer  $reviewer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reviewer $reviewer)
    {
        //
    }
}
