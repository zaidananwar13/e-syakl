<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Kelas_User;
use App\Models\Overview as ModelsOverview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use KelasUser;

class Overview extends Controller
{
    public function index($slideNumber)
    {
        header('Content-Type: application/json; charset=utf-8');
        $api = [
            'title' => 'E - Syakl API V2 | Overview API',
            'code' => 200,
            'message' => "This is an API for Arabic-Go's Overview Page $slideNumber.",
        ];

        $overview = $this->overviewRoute($slideNumber);

        $api['data'] = $overview;

        return $api;
    }

    private function overviewRoute($slideNumber)
    {
        switch ($slideNumber) {
            case 1:
                return $this->overviewOne();
            case 2:
                return $this->overviewTwo();
            case 3:
                return $this->overviewThree();
            case 4:
                return $this->overviewFour();
            case 5:
                return $this->overviewFive();
            default:
                return "unknown request";
        }
    }

    private function overviewOne()
    {
        $overview = ModelsOverview::select("title", "desc")
            ->where("id_overview", 1)->get();
        $rating = Kelas_User::select("point_review")->where("id_kelas", 5)->get()->toArray();

        $reviews = 0;
        $review_count = 0;
        foreach ($rating as $review) {
            $reviews += $review["point_review"];
            $review_count++;
        }

        $overview = $overview[0];
        $overview["rating"] = ($reviews != 0) ? (number_format(($reviews / $review_count), 1, ".", "") . "/5") : 0;
        $overview["votes"] = $review_count;

        return $overview;
    }

    private function overviewTwo()
    {
        $overview = ModelsOverview::select("title", "desc")
            ->where("id_overview", 2)->get();

        $overview = $overview[0];
        $overview["items"] = [
            [
                "title" => "100%",
                "subTitle" => "COMPLETION RATE",
                "desc" => "For context, typical online courses have a 12.6% completion rate. We're proud to have a 100% completion rate.",
                "image" => "Sports medal.svg",
            ],
            [
                "title" => "$0",
                "subTitle" => "WE'RE FUNDING",
                "desc" => "We're fully bootstrapped & take pride in growing organically ensure we serve our community vs investor interests.",
                "image" => "Money with wings.svg",
            ],
            [
                "title" => "500+",
                "subTitle" => "OUR ALUMNI",
                "desc" => "We have taught over 500 students online and our awesome alumni have gone on to work Google and more.",
                "image" => "student.svg",
            ],
        ];

        return $overview;
    }

    private function overviewThree()
    {
        $overview = ModelsOverview::select("title", "desc")
            ->where("id_overview", 3)->get();

        $overview = $overview[0];
        $kelas = Kelas::select('id_kelas', 'judul', 'gambar', 'langkah', 'level')
        ->get();

        foreach($kelas as $kel) {
            $kel->link = "/class?id=" . $kel->id_kelas;

            $komentar = DB::table('kelas_user')
            ->select('id_kelas_user', 'id_kelas', 'id_user', 'point_review', 'komentar_review')
            ->where('id_kelas', '=', $kel->id_kelas)
            ->get();

            
            foreach($komentar as $kom) {
                $nama_komentar = DB::table('user')
                ->select('name')
                ->where('id_user', '=', $kom->id_user)
                ->first();
    
                $kom->nama = $nama_komentar->name;
            }

            $ratings = [];
            $rating = 0;
            
            foreach($komentar as $kom) {
                $ratings[]= $kom->point_review;
            }
            
            foreach($ratings as $rat) {
                $rating += $rat;
            }

            $kel->rating = 0;

            if($rating != 0) {
                $kel->rating = (float) number_format($rating /= count($ratings), 2);
            }
            unset($kel->id_kelas);
        } 

        $overview["items"] = $kelas;


        return $overview;
    }

    private function overviewFour()
    {
        $overview = ModelsOverview::select("title", "desc")
            ->where("id_overview", 4)->get();

        $overview = $overview[0];
        $review = Kelas_User::first();
        $user = User::where('id_user', '=', $review->id_user)->first();

        $overview["items"] = [
            "title" => "Learning is easier with the giving harakat featured",
            "desc" => "Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore mag.",
            "link" => "https://e-syakl.org/",
            "comments" => [
                "name" => $user->name,
                "comment" => $review->komentar_review,
                "img" => $user->avatar_original,
            ],
        ];
        return $overview;
    }

    private function overviewFive()
    {
        $overview = ModelsOverview::select("title", "desc")
            ->where("id_overview", 5)->get();

        $overview = $overview[0];
        $overview["items"] = "on working";

        $review = Kelas_User::select("id_user", "komentar_review", "point_review")->get();
        foreach($review as $view) {
            $view->comment = $view->komentar_review;
            unset($view->komentar_review);
            
            $view->rating = $view->point_review;
            unset($view->point_review);

            $user = User::where('id_user', '=', $view->id_user)->first();
            $view->name = $user->name;
            $view->img = $user->avatar_original;
        }

        $overview["items"] = $review;

        return $overview;
    }
}
