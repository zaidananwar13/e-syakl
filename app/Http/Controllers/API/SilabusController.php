<?php

namespace App\Http\Controllers\API;

use App\Helper as Help;
use App\Http\Controllers\Controller;
use App\Models\Kategori_Silabus;
use App\Models\SilabusChecker;
use App\Models\Sub_Kategori_Silabus;
use App\Models\User;
use Exception;
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

    public function silabus(Request $request, $id)
    {
        header('Content-Type: application/json; charset=utf-8');

        $user = User::select('id_user')
            ->where('api_token', $request->api_token)
            ->firstOrFail()
            ->toArray();
        $user = $user['id_user'];

        $secureKey = Help::checkSilabusAccess($user, $id);
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
            $secureKey = $secureKey[0];
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

        // echo $message['data']->konten; die;

        return $message;
    }

    public function auth(Request $request) {
        $req = $request->all();
        $message = [
            'title' => 'E - Syakl | Silabus Auth API',
            'code' => 401,
            'message' => 'Unauthorized'
        ];

        try {
            
            $user = User::select('id_user')
                ->where('api_token', $req['api_token'])
                ->first();

            if($user != null) {
                $user = $user->toArray();
                $userSilabus = Help::checkSilabusAccessUser($user['id_user'], $req['x-key']);

                if($userSilabus == null) {
                    $message['code'] = 409;
                    $message['message'] = 'Unauthorized register!';
                }else {
                    if($userSilabus['id_sub_kategori_silabus'] != $req['y-key'] && $userSilabus['id_sub_kategori_silabus'] < $req['y-key']) {
                        $silabus = new SilabusChecker();
                        $silabus->id_user = $user['id_user'];
                        $silabus->id_kategori_silabus = $req['x-key'];
                        $silabus->id_sub_kategori_silabus = $req['y-key'];
                        $silabus->save();
        
                        $message['code'] = 200;
                        $message['message'] = 'Auth register success!';
                    }else {
                        $message['code'] = 409;
                        $message['message'] = 'Already registered';
                    }
                }

            }
        }catch (Exception $e) {
            $error_handler = [
                "23503" => "Foreign key violates",
                "23505" => "Duplicate key"
            ];
            $data = json_encode($e);
            $data = json_decode($data);
            
            $message['status'] = $error_handler[$data->errorInfo[0]];
            $message['code'] = 409;
            $message['message'] = 'Already registered';

            switch($message['status']) {
                case "Foreign key violates":
                    $message['message'] = 'Illegal access detected ';
                    
                    break;
                case "Duplicate key":
                    $message['message'] = 'Already registered';
                    
                    break;
                default:
                    break;
            }

        }

        return $message;
    }
}
