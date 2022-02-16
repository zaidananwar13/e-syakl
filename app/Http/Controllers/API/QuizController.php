<?php

namespace App\Http\Controllers\API;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request) {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Quiz API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $silabus = $request->input("silabus");

        $quiz = Quiz::select('id_quiz', 'soal', 'tipe_soal', 'pilihan')
            ->where('id_sub_kategori_silabus', $silabus)
            ->get()
            ->toArray();

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

    public function submit(Request $request) {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Quiz API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $quizzes = Helper::generateQuiz($request->all());
        $counter = count($quizzes); $grade = 0; $rightChoice = 0;
        
        foreach($quizzes as $quiz) {
            $answer = Quiz::find($quiz["id_quiz"]);
            
            if($quiz["pilihan"] == $answer->kunci) {
                $rightChoice++;
            }
        }

        if($counter != 0) {
            $grade = $rightChoice / $counter * 100;

            $message = [
                'title' => 'E - Syakl | Quiz API',
                'code' => 200,
                'message' => "Congrats, you answer precisely $rightChoice out of $counter!",
                "grade" => $grade
            ];
        }else {
            $message = [
                'title' => 'E - Syakl | Quiz API',
                'code' => 500,
                'message' => "Sorry, something went wrong :(",
            ];
        }

        return $message;
    }
}
