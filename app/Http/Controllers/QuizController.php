<?php

namespace App\Http\Controllers;

use App\Models\Kategori_Silabus;
use App\Models\Quiz;
use App\Models\QuizContainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $quiz = QuizContainer::all();
            $data['quiz'] = $quiz;

            return view('quiz.index', $data);
        }
    }

    public function edit(Request $request, $id)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $quiz = QuizContainer::where("id_quiz_container", $id)
                ->first();

            $data = [
                'silabus' => Kategori_Silabus::all(),
                'quiz' => $quiz,
                'action' => 'quiz.edit'
            ];

            return view('quiz.edit', $data);
        }
    }

    public function create()
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $quiz = Quiz::all();
            $data = [
                'silabus' => Kategori_Silabus::all(),
                'quiz' => $quiz,
                'action' => 'quiz.store'
            ];

            return view('quiz.form', $data);
        }
    }

    /**
     * Update the selected resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        QuizContainer::where("id_kategori_silabus", $request->input("old_id_quiz_container"))
            ->where("id_quiz_container", $request->input("id_quiz_container"))
            ->update([
                "id_kategori_silabus" => $request->input("id_silabus"),
                "question" => $request->input("question"),
                "desc" => $request->input("desc")
            ]);
        return redirect('/quiz')->with('success', 'Data Update  Success!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $count = intval($request->input("count"));
        $bank_soal = [];

        $quizContainer = new QuizContainer();
        $quizContainer->id_kategori_silabus = $request->input("id_silabus");
        $quizContainer->desc = $request->input("desc");
        $quizContainer->save();

        for ($i = 0; $i < $count; $i++) {
            $soal = $request->input("soal-" . $i);
            $tipe_soal = $request->input("tipe_soal-" . $i);
            $pilihan = json_decode($request->input("pilihan-" . $i));
            $kunci = json_decode($request->input("kunci-" . $i));
            $pilihanStr = $kunciStr = "";

            for ($j = 0; $j < count($pilihan); $j++) {
                $pilihanStr .= $pilihan[$j]->value;
                $pilihanStr .= ($j == (count($pilihan) - 1)) ? "" : ",";
            }

            for ($j = 0; $j < count($kunci); $j++) {
                $kunciStr .= $kunci[$j]->value;
                $kunciStr .= ($j == (count($kunci) - 1)) ? "" : ",";
            }

            $input = [
                "soal" => $soal,
                "id_quiz_container" => $quizContainer->id_quiz_container,
                "tipe_soal" => $tipe_soal,
                "pilihan" => $pilihanStr,
                "kunci" => $kunciStr
            ];

            array_push($bank_soal, $input);
            Quiz::create($input);
        }

        return redirect('/quiz')->with('success', 'Data Input  Success!');
    }

    public function delete($id = "")
    {
        $kelas_user = Quiz::find($id);
        $kelas_user->delete();
        return redirect('/quiz')->with('success', 'Deleted');
    }

    public function simulation(Request $request, $id)
    {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $quizContainer = QuizContainer::where("id_kategori_silabus", $id)->get();

            $quiz = [];

            foreach ($quizContainer as $container) {
                $temp = Quiz::select('id_quiz', 'soal', 'tipe_soal', 'pilihan')
                    ->where('id_quiz_container', $container->id_quiz_container)
                    ->get();

                array_push($quiz, $temp);
            }

            $data['quizzes'] = $quiz;
            $data['id'] = $id;

            return view('quiz.simulation', $data);
        }
    }
}
