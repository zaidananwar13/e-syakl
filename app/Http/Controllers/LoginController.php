<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        if (!Session::get('login')) {
            return view('login.login');
        } else {
            return redirect('home');
        }
    }

    public function loginPost(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $data = User::where('username', $username)->first();
        if ($data) {
            if (Hash::check($password, $data->password)) {
                Session::put('username', $data->username);
                Session::put('login', TRUE);
                return redirect('home');
            } else {
                return redirect('login')->with('alert', 'Password Salah');
            }
        } else {
            return redirect('login')->with('alert', 'Username atau Password Salah');
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('login');
    }

    public function register()
    {
        return view('login.register');
    }

    public function registerPost(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'repassword' => 'required',
            'agreeTerms' => 'checked'
        ]);

        $data = User::where('username', $request->username)->first();
        if ($data) {
            return redirect('register')->with('alert', 'Username sudah terdaftar');
        } elseif ($request->password != $request->repassword) {
            return redirect('register')->with('alert', 'Password harus diisi sama');
        } else {

            $data =  new User();
            $data->username = $request->username;
            $data->password = bcrypt($request->password);
            $data->api_token = hash('sha256', Str::random(60));
            $data->save();
            return redirect('login')->with('alert-success', 'Kamu berhasil Register');
        }
    }

    public function indexHome()
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            return view('home.master');
        }
    }
}
