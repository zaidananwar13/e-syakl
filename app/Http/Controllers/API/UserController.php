<?php

namespace App\Http\Controllers\API;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\ClassProgress;
use App\Models\CompletedClass;
use App\Models\Kelas;
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
            return redirect('api/register')->with('info', 'Email sudah terdaftar');
        } elseif ($request->password != $request->repassword) {
            return redirect('api/register')->with('warning', 'Password harus diisi sama');
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
                
            return redirect('api/register')->with('success', 'Kamu berhasil Register');
        }
    }

    public function profile(Request $request) {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Quiz API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $user = User::select("id_user", "name", "email", "created_at")
            ->where("api_token", $request->input("api_token"))
            ->first()->toArray();
        
        $classProgress = ClassProgress::select("id_kelas", "progress")->distinct()
            ->where("id_user", $user["id_user"])
            ->where("progress", "!=", "100")->get()->toArray();

        $classCompleted = CompletedClass::where("id_user", $user["id_user"])->get()->toArray();

        $temp = [];
        if(count($classProgress) > 0) {
            foreach($classProgress as $class) {
                $class_temp = Kelas::select("id_kelas", "gambar", "judul")->where("id_kelas", $class["id_kelas"])->first()->toArray();
                $class_temp["days_left"] = 59;
                $class_temp["progress"] = $class["progress"];
                array_push($temp, $class_temp);
            }
        }

        $temp2 = [];
        if(count($classCompleted) > 0) {
            foreach($classCompleted as $class) {
                $class_temp = Kelas::select("id_kelas", "gambar", "judul")->where("id_kelas", $class["id_kelas"])->first()->toArray();
                $class_temp["days_left"] = 59;
                $class_temp["progress"] = $class["progress"];
                array_push($temp2, $class_temp);
            }
        }

        $profile = [
            "name" => $user["name"],
            "email" => $user["email"],
            "joined" => "Joined since " . Helper::time_elapsed_string($user["created_at"]),
            "class_on_progress" => count($classProgress),
            "completed_classes" => count($classCompleted),
            "class_progress" => $temp,
            "class_completed" => $temp2
        ];

        
        $message = [
            'title' => 'E - Syakl | User API',
            'code' => 200,
            'message' => 'Ok.',
            'data' => $profile
        ];

        return $message;
    }
}
