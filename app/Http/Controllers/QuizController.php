<?php

namespace App\Http\Controllers;

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
                'quiz' => $quiz,
                'action' => 'quiz.store'
            ];
            
            return view('quiz.form', $data);
        }
    }
}
