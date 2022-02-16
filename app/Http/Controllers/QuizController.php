<?php

namespace App\Http\Controllers;

use App\Models\Kategori_Silabus;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    public function index(Request $request) {
        if (!Session::get('login')) {
            return redirect('login');
        } else {
            $quiz = Quiz::all();
            $data['quiz'] = $quiz;

            return view('quiz.index', $data);
        }
    }

    public function create() {
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $count = intval($request->input("count"));
        $bank_soal = [];

        for($i = 0; $i < $count; $i++) {
            $soal = $request->input("soal-" . $i);
            $tipe_soal = $request->input("tipe_soal-" . $i);
            $pilihan = json_decode($request->input("pilihan-" . $i));
            $kunci = json_decode($request->input("kunci-" . $i));
            $pilihanStr = $kunciStr = "";

            for($j = 0; $j < count($pilihan); $j++) {
                $pilihanStr .= $pilihan[$j]->value;
                $pilihanStr .= ($j == (count($pilihan) - 1)) ? "" : ",";    
            }

            for($j = 0; $j < count($kunci); $j++) {
                $kunciStr .= $kunci[$j]->value;
                $kunciStr .= ($j == (count($kunci) - 1)) ? "" : ",";    
            }
            
            $input = [
                "soal" => $soal,
                "id_sub_kategori_silabus" => $request->input('id_silabus'),
                "tipe_soal" => $tipe_soal,
                "pilihan" => $pilihanStr,
                "kunci" => $kunciStr
            ];

            array_push($bank_soal, $input);
            Quiz::create($input);
        }
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
            $quiz = Quiz::select('id_quiz', 'soal', 'tipe_soal', 'pilihan')
            ->where('id_sub_kategori_silabus', $id)->get();
            $data['quizzes'] = $quiz;
            $data['id'] = $id;

            return view('quiz.simulation', $data);
        }
    }
}
