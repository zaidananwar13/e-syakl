<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\QuizProgress;
use App\Models\User;
use Illuminate\Http\Request;

class QuizProgressController extends Controller
{
    public function index(Request $request) {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Quiz Progress API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $user = User::select("id_user")
            ->where("api_token", $request->input("api_token"))
            ->first()->toArray();

        $quiz = QuizProgress::where("id_user", $user["id_user"])->get()->toArray();
        
        if(count($quiz) > 0) {
            $message = [
                'title' => 'E - Syakl | Quiz API',
                'code'=> 200,
                'message'=> 'Retrieving data successful!',
                'data' => $quiz
            ];
        }

        return $message;
    }
    
    public function isClear(Request $request) {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Quiz Progress API',
            'code' => 402,
            'message' => 'Quiz not completed'
        ];

        $user = User::select("id_user")
            ->where("api_token", $request->input("api_token"))
            ->first()->toArray();

        $quiz = QuizProgress::where("id_user", $user["id_user"])
            ->where("id_kategori_silabus", $request->input("y-key"))
            ->get()
            ->toArray();
        
        if(count($quiz) > 0) {
            $message = [
                'title' => 'E - Syakl | Quiz API',
                'code'=> 200,
                'message'=> 'Quiz has been completed!'
            ];
        }

        return $message;
    }
}
