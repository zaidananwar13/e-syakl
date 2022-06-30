<?php

namespace App\Http\Controllers\API;

use App\Helper as Help;
use App\Http\Controllers\Controller;
use App\Models\Kategori_Silabus;
use App\Models\Kelas;
use App\Models\KelasHistory;
use App\Models\SilabusChecker;
use App\Models\Sub_Kategori_Silabus;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function Ramsey\Uuid\v1;

class SilabusController extends Controller
{
    public function index(Request $request, $id)
    {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Silabus API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $user = User::select("id_user")
            ->where("api_token", $request->input("api_token"))->first();

        $history = KelasHistory::select("id_sub_kategori_silabus")
            ->where("id_user", $user["id_user"])
            ->where("id_kategori_silabus", $id)
            ->first();

        if($history == null) {
            $history["id_sub_kategori_silabus"] = 0;
        }



        $kategori_silabus = Kategori_Silabus::select('id_kategori_silabus', 'id_kelas', 'judul')
            ->where('id_kelas', $id)->get();

        foreach ($kategori_silabus as $k_silabus) {
            $k_silabus->sub_kategori_silabus = Sub_Kategori_Silabus::select('id_sub_kategori_silabus', 'id_kategori_silabus', 'judul', 'konten')
                ->where('id_kategori_silabus', $k_silabus->id_kategori_silabus)->get();
        }

        if (count($kategori_silabus) > 0) {
            $message = [
                'title' => 'E - Syakl | Silabus API',
                'code' => 200,
                'message' => 'Retrieving data successful!',
                'last_material' => $history["id_sub_kategori_silabus"],
                'data' => $kategori_silabus
            ];
        }

        return $message;
    }

    public function silabus(Request $request, $id)
    {

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

        if ($secureKey == null) {
            if ($id == 1) {
                $materi = Sub_Kategori_Silabus::select("id_kategori_silabus", "id_sub_kategori_silabus")
                    ->where("id_sub_kategori_silabus", $id)
                    ->get()
                    ->toArray();
                $materi = $materi[0];

                $secureKey = [
                    ["id_sub_kategori_silabus" => $materi["id_sub_kategori_silabus"]],
                ];

                $silabusChecker = new SilabusChecker();
                $silabusChecker->id_user = $user;
                $silabusChecker->id_kategori_silabus = $materi["id_kategori_silabus"];
                $silabusChecker->id_sub_kategori_silabus = $materi["id_sub_kategori_silabus"];
                $silabusChecker->save();
            } else {
                $materi = Sub_Kategori_Silabus::select("id_kategori_silabus", "id_sub_kategori_silabus")
                    ->where("id_sub_kategori_silabus", $id)
                    ->get()
                    ->toArray();
                $materi = $materi[0];

                $response = Http::post('https://dashboard.e-syakl.org/api/silabus/auth/sub-kategori', [
                    'api_token' => $request->input("api_token"),
                    'x-key' => $materi["id_kategori_silabus"],
                    'y-key' => $materi["id_sub_kategori_silabus"],
                ]);

                if ($response->body() == "\"Invalid Token\"") {
                    header('Content-Type: application/json; charset=utf-8');

                    $message['code'] = '401';
                    $message['message'] = 'Unauthorized User';

                    return $message;
                } else {
                    $secureKey = [
                        ["id_sub_kategori_silabus" => $materi["id_sub_kategori_silabus"]],
                    ];
                }
            }
        }

        $secureKey = $secureKey[0];

        if ($secureKey['id_sub_kategori_silabus'] == $id) {
            $silabus = Sub_Kategori_Silabus::select('id_sub_kategori_silabus', 'id_kategori_silabus', 'judul', 'konten')
                ->where('id_sub_kategori_silabus', $id)->first();

            if ($silabus != null) {
                $message = [
                    'title' => 'E - Syakl | Silabus API',
                    'code' => 200,
                    'message' => 'Retrieving data successful!',
                    'data' => $silabus
                ];
            }
        }

        // echo $message['data']->konten; die;

        return $message;
    }

    public function authKategori(Request $request)
    {
        echo "still demo version";
        die;

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

            if ($user != null) {
                $user = $user->toArray();
                $userSilabus = Help::checkSilabusAccessUser($user['id_user'], $req['x-key']);

                if ($userSilabus == null) {
                    $message['code'] = 409;
                    $message['message'] = 'Unauthorized register!';
                } else {
                    if ($userSilabus['id_sub_kategori_silabus'] != $req['y-key'] && $userSilabus['id_sub_kategori_silabus'] < $req['y-key']) {
                        $silabus = new SilabusChecker();
                        $silabus->id_user = $user['id_user'];
                        $silabus->id_kategori_silabus = $req['x-key'];
                        $silabus->id_sub_kategori_silabus = $req['y-key'];
                        $silabus->save();

                        $message['code'] = 200;
                        $message['message'] = 'Auth register success!';
                    } else {
                        $message['code'] = 409;
                        $message['message'] = 'Already registered';
                    }
                }
            }
        } catch (Exception $e) {
            $error_handler = [
                "23503" => "Foreign key violates",
                "23505" => "Duplicate key"
            ];
            $data = json_encode($e);
            $data = json_decode($data);

            $message['status'] = $error_handler[$data->errorInfo[0]];
            $message['code'] = 409;
            $message['message'] = 'Already registered';

            switch ($message['status']) {
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

    public function authSubKategori(Request $request)
    {
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

            if ($user != null) {
                $user = $user->toArray();
                $userSilabus = Help::checkSilabusAccessUser($user['id_user'], $req['x-key']);

                if ($userSilabus == null) {
                    $message['code'] = 409;
                    $message['message'] = 'Unauthorized register!';

                    if ($user != null) {
                        $silabus = new SilabusChecker();
                        $silabus->id_user = $user['id_user'];
                        $silabus->id_kategori_silabus = $req['x-key'];
                        $silabus->id_sub_kategori_silabus = $req['y-key'];
                        $silabus->save();

                        $message['code'] = 200;
                        $message['message'] = 'Auth register success!';
                    }
                } else {
                    if ($userSilabus['id_sub_kategori_silabus'] != $req['y-key'] && $userSilabus['id_sub_kategori_silabus'] < $req['y-key']) {
                        $silabus = new SilabusChecker();
                        $silabus->id_user = $user['id_user'];
                        $silabus->id_kategori_silabus = $req['x-key'];
                        $silabus->id_sub_kategori_silabus = $req['y-key'];
                        $silabus->save();

                        $message['code'] = 200;
                        $message['message'] = 'Auth register success!';
                    } else {
                        $message['code'] = 409;
                        $message['message'] = 'Already registered';
                    }
                }
            }
        } catch (Exception $e) {
            $error_handler = [
                "23503" => "Foreign key violates",
                "23505" => "Duplicate key"
            ];
            $data = json_encode($e);
            $data = json_decode($data);

            $message['status'] = $error_handler[$data->errorInfo[0]];
            $message['code'] = 409;
            $message['message'] = 'Already registered';

            switch ($message['status']) {
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
