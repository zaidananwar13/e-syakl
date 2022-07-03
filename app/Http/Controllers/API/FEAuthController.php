<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helper;
use App\Models\FEAuthorizer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FEAuthController extends Controller
{
    public function index(Request $request)
    {
        header('Content-Type: application/json; charset=utf-8');
        $api = [
            'title' => 'E - Syakl | Authorizer API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $token = $request->input("api_token");
        $class = $request->input("class");

        if ($token == null) return Helper::unauthorized("Authorizer");
        $user = User::select("id_user")
            ->where("api_token", $token)
            ->first();

        if ($user == null) return Helper::unauthorized("Authorizer");

        $feAuth = FEAuthorizer::select("id_kelas", "unlocked")
            ->where("id_kelas", $class)
            ->where("id_user", $user->id_user)
            ->first();

        return response($api = [
            'title' => 'E - Syakl | Authorizer API',
            'code' => 200,
            'data' => $feAuth
        ], $api["code"]);
    }

    public function feAuthorizer(Request $request)
    {
        // header('Content-Type: application/json; charset=utf-8');
        $api = [
            'title' => 'E - Syakl | Authorizer API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $token = $request->input("api_token");
        $class = $request->input("class");
        $material = $request->input("material");

        if ($token == null) return Helper::unauthorized("Authorizer");
        $user = User::select("id_user")
            ->where("api_token", $token)
            ->first();

        if ($user == null) return Helper::unauthorized("Authorizer");

        $feAuth = FEAuthorizer::select("id_kelas", "unlocked")
            ->where("id_kelas", $class)
            ->where("id_user", $user->id_user)
            ->first();

        if ($feAuth == null) {
            $feAuth = new FEAuthorizer();
            $feAuth->id_user = $user->id_user;
            $feAuth->id_kelas = $class;
            $feAuth->unlocked = 1;
            $feAuth->save();
        } else {
            FEAuthorizer::select("id_kelas", "unlocked")
                ->where("id_kelas", $class)
                ->where("id_user", $user->id_user)
                ->update([
                    "unlocked" => $material,
                    "updated_at" => Carbon::now(),
                ]);
        }

        return response($api = [
            'title' => 'E - Syakl | Authorizer API',
            'code' => 200,
            'message' => 'Success'
        ], $api["code"]);
    }
}
