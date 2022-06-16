<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LearningPath;
use App\Models\LearningPathClass;
use Illuminate\Http\Request;

class LearningPathController extends Controller
{
    public function index()
    {
        header('Content-Type: application/json; charset=utf-8');
        $api = [
            'title' => 'E - Syakl API V2 | Learning Path API',
            'code' => 200,
            'message' => "This is an API for Arabic-Go's Learning Path.",
        ];

        // category: {
        //     title: "judul",
        //     desc: "deskripsi",
        //     classes: 5,
        //     link: "url"
        //   }

        $learningPath = LearningPath::select("id_learning_path", "name", "desc")
            ->get();

        foreach($learningPath as $path) {
            $classes = LearningPathClass::where("id_learning_path", $path->id_learning_path)
                ->get()->count();
            $path->classes = $classes;
            $path->link = "/class?id=" . $path->id_learning_path;
            $path->title = $path->name;
            unset($path->id_learning_path);
            unset($path->name);
        }

        $api["data"] = $learningPath;

        return $api;
    }
}
