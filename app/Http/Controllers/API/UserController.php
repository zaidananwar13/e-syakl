<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        header('Content-Type: application/json; charset=utf-8');

        return User::all()->toArray();
    }

    public function register() {
        return view('test.register');
    }

    public function registerPost(Request $request) {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'repassword' => 'required',
            'agreeTerms' => 'checked'
        ]);

        $data = User::where('email', $request->email)->first();

        if ($data) {
            return redirect('register')->with('alert', 'Email sudah terdaftar');
        } elseif ($request->password != $request->repassword) {
            return redirect('register')->with('alert', 'Password harus diisi sama');
        } else {
            $name = explode('@', $request->email);
            $name = $name[0];

            $data =  new User();
            $data->name = $name;
            $data->email = $request->email;
            $data->google_id = "default";
            $data->password = bcrypt($request->password);
            $data->api_token = hash('sha256', Str::random(60));
            $data->save();
            return redirect('login')->with('alert-success', 'Kamu berhasil Register');
        }
    }
}
