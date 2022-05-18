<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kelas_User;
use App\Models\Overview as ModelsOverview;
use Illuminate\Http\Request;

class Overview extends Controller
{
    public function index($slideNumber) {
        header('Content-Type: application/json; charset=utf-8');
        $api = [
            'title' => 'E - Syakl API V2 | Overview API',
            'code' => 200,
            'message' => "This is an API for Arabic-Go's Overview Page $slideNumber.",
        ];

        $overview = ModelsOverview::where("id_overview", $slideNumber)->get();
        $overview->rating = Kelas_User::select("point_review")->get()->toArray();

        $reviews = 0;
        $review_count = 0;
        foreach($overview->rating as $review) {
            $reviews += $review["point_review"];
            $review_count++;
        }
        
        $overview->rating = $reviews / $review_count;

        $api['data'] = $overview;

        return $api;
    }
}
