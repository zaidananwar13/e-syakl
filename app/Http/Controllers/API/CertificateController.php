<?php

namespace App\Http\Controllers\API;

use App\Helper as Help;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CertificateController extends Controller
{

    public function index(Request $request)
    {
        header('Content-Type: application/json; charset=utf-8');
        $api = [
            'title' => 'E - Syakl | Certificate API',
            'code' => 404,
            'message' => 'Not Found, You have nothing achieved yet.'
        ];


        $token = $request->input("api_token");
        $class = $request->input("class");
        if ($token != null) {
            $user = User::select("id_user", "name")->where("api_token", $token)->first();

            if ($class == null) {
                $certificate = Certificate::select("id_kelas", "created_at")
                    ->where("id_user", $user->id_user)
                    ->get();

                foreach ($certificate as $cert) {
                    $kelas = Kelas::select("judul")->where("id_kelas", $cert->id_kelas)->first();
                    $cert->user = $user->name;
                    $cert->title = $kelas->judul;
                    $cert->date = Carbon::parse($cert->created_at)->format('d F Y');

                    unset($cert->created_at);
                }
            } else {
                $certificate = Certificate::select("id_kelas", "created_at")
                    ->where("id_user", $user->id_user)
                    ->where("id_kelas", $class)
                    ->first();

                $kelas = Kelas::select("judul")->where("id_kelas", $certificate->id_kelas)->first();
                $certificate->user = $user->name;
                $certificate->title = $kelas->judul;
                $certificate->date = Carbon::parse($certificate->created_at)->format('d F Y');

                unset($certificate->created_at);
            }

            var_dump($certificate->toArray());
            die;
        } else {
            return Help::unauthorized("Certificate");
        }

        return response($api, $api["response"]);
    }

    public static function create($user, $class)
    {
        header('Content-Type: application/json; charset=utf-8');
        $cert = Certificate::select("token")
            ->where("id_user", $user)
            ->where("id_kelas", $class)
            ->first();

        if ($cert == null) {
            $cert = new Certificate();
            $cert->id_user = $user;
            $cert->id_kelas = $class;
            $cert->token = hash('sha256', Str::random(60));
            $cert->created_at = Carbon::now()->format('Y-m-d H:i:s');
            $cert->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $cert->save();

            return true;
        }else {
            return false;
        }
    }
}
