<?php

namespace App\Http\Controllers\API;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Kategori_Silabus;
use App\Models\Quiz;
use App\Models\QuizContainer;
use App\Models\QuizProgress;
use App\Models\Sub_Kategori_Silabus;
use App\Models\User;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        // header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Quiz API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $user = User::select("id_user")
            ->where("api_token", $request->input("api_token"))
            ->first();

        $silabus = $request->input("silabus");
        $materi = Kategori_Silabus::select("judul", "id_kategori_silabus")
            ->where("id_kategori_silabus", $silabus)->first();

        // quiz container must not be null
        $quizContainer = QuizContainer::select("id_quiz_container", "id_kategori_silabus", "desc")
            ->where('id_kategori_silabus', $silabus)
            ->get();

        foreach($quizContainer as $container) {
            $quizzez = Quiz::select('id_quiz', 'soal', 'tipe_soal', 'pilihan')
            ->where('id_quiz_container', $container->id_quiz_container)
            ->get()
            ->toArray();
            
            unset($container->id_quiz_container);
            unset($container->id_kategori_silabus);
            $container->quizzes = $quizzez;
        }

        $quizHistories = QuizProgress::select("id_kategori_silabus", "created_at", "grade")
            ->where("id_user", $user["id_user"])
            ->where('id_kategori_silabus', $materi->id_kategori_silabus)
            ->get();

        foreach ($quizHistories as $hist) {
            $hist->date = $hist->created_at;
            $hist->score = $hist->grade;
            $hist->status = ($hist->grade > 78) ? "Pass" : "Not Pass";
            unset($hist->created_at);
            unset($hist->grade);
            unset($hist->id_kategori_silabus);
        }

        if (count($quizContainer) > 0) {
            $message = [
                'title' => 'E - Syakl | Quiz API',
                'code' => 200,
                'message' => 'Retrieving data successful!',
                'data' => [
                    "title" => $materi->judul,
                    "quizzes" => $quizContainer,
                    "history" => $quizHistories,
                ]
            ];
        }

        return response($message, $message["code"]);
    }

    public function submit(Request $request)
    {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Quiz API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $user = User::select("id_user")
            ->where("api_token", $request->input("api_token"))
            ->first()
            ->toArray();

        $quizzes = Helper::generateQuiz($request->all());
        $counter = count($quizzes);
        $grade = 0;
        $rightChoice = 0;

        foreach ($quizzes as $quiz) {
            $answer = Quiz::find($quiz["id_quiz"]);

            if ($quiz["pilihan"] == $answer->kunci) {
                $rightChoice++;
            }
        }

        if ($counter != 0) {
            $grade = $rightChoice / $counter * 100;

            $quizProg = new QuizProgress();
            $quizProg->id_user = $user["id_user"];
            $quizProg->id_kategori_silabus = $request->input("id_silabus");
            $quizProg->grade = $grade;
            $quizProg->save();

            $message = [
                'title' => 'E - Syakl | Quiz API',
                'code' => 200,
                'message' => "Congrats, you answer precisely $rightChoice out of $counter!",
                "grade" => $grade,
                "status" => ($grade > 78) ? "Pass" : "Not Pass"
            ];
        } else {
            $message = [
                'title' => 'E - Syakl | Quiz API',
                'code' => 500,
                'message' => "Sorry, something went wrong :(",
            ];
        }

        return response($message, $message["code"]);
    }
}
