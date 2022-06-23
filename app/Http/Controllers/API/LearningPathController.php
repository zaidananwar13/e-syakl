<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\LearningPath;
use App\Models\LearningPathClass;
use Illuminate\Http\Request;

class LearningPathController extends Controller
{
    public function index($id = null)
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

        if ($id != null) {
            $learningPath = LearningPath::select("id_learning_path")
                ->where("id_learning_path", $id)
                ->first();

            if ($learningPath == null)
                return response($api = [
                    'title' => 'E - Syakl API V2 | Learning Path API',
                    'code' => 404,
                    'message' => "The learning path is found nowhere.",
                ], $api['code']);

            $learningClass = LearningPathClass::select('id_kelas')
                ->where("id_learning_path", $learningPath->id_learning_path)->get();

            $temp = [];
            foreach($learningClass as $learning) {
                $learning = Kelas::select("id_kelas", "judul", "deskripsi_singkat", "gambar")
                    ->where("id_kelas", $learning->id_kelas)->first();

                $learning->link = "/class?id=" . $learning->id_kelas;
                $learning->img = $learning->gambar;
                unset($learning->id_kelas);
                unset($learning->gambar);
                array_push($temp, $learning->toArray());
            }

            if($learningClass == null)
                return response($api = [
                    'title' => 'E - Syakl API V2 | Learning Path API',
                    'code' => 404,
                    'message' => "There are no classes on this path yet :(.",
                ], $api['code']);

            $api["data"] = $temp;
            return response($api, $api['code']);
        }

        foreach ($learningPath as $path) {
            $classes = LearningPathClass::where("id_learning_path", $path->id_learning_path)
                ->get()->count();
            $path->classes = $classes;
            $path->link = "/learning-path?id=" . $path->id_learning_path;
            $path->title = $path->name;
            unset($path->id_learning_path);
            unset($path->name);
        }

        $api["data"] = $learningPath;

        return response($api, $api['code']);
    }
}
