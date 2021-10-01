<?php

namespace App\Http\Controllers\API;

use App\Helper as Help;
use App\Http\Controllers\Controller;
use App\Models\Kategori_Silabus;
use App\Models\SilabusChecker;
use App\Models\Sub_Kategori_Silabus;
use App\Models\User;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class SilabusController extends Controller
{
    public function index($id) {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Silabus API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $kategori_silabus = Kategori_Silabus::select('id_kategori_silabus', 'id_kelas', 'judul')
            ->where('id_kelas', $id)->get();

        foreach($kategori_silabus as $k_silabus) {
            $k_silabus->sub_kategori_silabus = Sub_Kategori_Silabus::select('id_sub_kategori_silabus', 'id_kategori_silabus', 'judul', 'konten')
                ->where('id_kategori_silabus', $k_silabus->id_kategori_silabus)->get();
        }

        if(count($kategori_silabus) > 0) {
            $message = [
                'title' => 'E - Syakl | Silabus API',
                'code'=> 200,
                'message'=> 'Retrieving data successful!',
                'data' => $kategori_silabus
            ];
        }

        return $message;
    }

    public function silabus($id)
    {
        header('Content-Type: application/json; charset=utf-8');

        $secureKey = Help::checkSilabusAccessUser(1, 1, 1);
        $message = [
            'title' => 'E - Syakl | Silabus API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        if($secureKey == null) {
            $message['code'] = '401';
            $message['message'] = 'Unauthorized';

            return $message;
        }

        if($secureKey['id_sub_kategori_silabus'] == $id) {
            $silabus = Sub_Kategori_Silabus::select('id_sub_kategori_silabus', 'id_kategori_silabus', 'judul', 'konten')
                ->where('id_sub_kategori_silabus', $id)->first();
            
            if($silabus != null) {
                $message = [
                    'title' => 'E - Syakl | Silabus API',
                    'code'=> 200,
                    'message'=> 'Retrieving data successful!',
                    'data' => $silabus
                ];
            }

        }

        return $message;
    }

    public function auth(Request $request) {
        header('Content-Type: application/json; charset=utf-8');
        
        $req = $request->all();
        $message = [
            'title' => 'E - Syakl | Silabus Auth API',
            'code' => 401,
            'message' => 'Unauthorized'
        ];

        $user = User::select('id_user')
            ->where('api_token', $req['api_token'])
            ->first();

        if($user != null) {
            $user = $user->toArray();

            $silabus = new SilabusChecker();
            $silabus->id_user = $user['id_user'];
            $silabus->id_kategori_silabus = $req['id_kategori_silabus'];
            $silabus->id_sub_kategori_silabus = $req['id_sub_kategori_silabus'];
            $silabus->save();

            $message['code'] = 200;
            $message['message'] = 'Auth register success!';
        }

        return $message;
    }
}