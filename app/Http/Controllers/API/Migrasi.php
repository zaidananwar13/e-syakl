<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Migrasi extends Controller
{
    public function index(Request $request, $mode) {
        $message = [
            'title' => 'E - Syakl | Migrasi Login API',
            'code' => 200,
            'message' => '200 OK.'
        ];

        if($mode == "local") {
            $migrasi = \App\Models\Migrasi::find(1);
            $migrasi->mode = 'local';
            $migrasi->save();

            $message['message'].= ' -----> Beralih ke lokal';
        }else {
            $migrasi = \App\Models\Migrasi::find(1);
            $migrasi->mode = 'vps';
            $migrasi->save();
            $message['message'].= ' -----> Beralih ke vps';
        }

        return $message;
    }
}
