<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kelas_User;
use App\Models\Overview as ModelsOverview;
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
        $rating = Kelas_User::select("point_review")->where("id_kelas", 1)->get()->toArray();

        $reviews = 0;
        $review_count = 0;
        foreach ($rating as $review) {
            $reviews += $review["point_review"];
            $review_count++;
        }

        $overview = $overview[0];
        $overview["rating"] = ($reviews / $review_count) . "/5";
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
        $overview["items"] = "on working";

        return $overview;
    }

    private function overviewFour()
    {
        $overview = ModelsOverview::select("title", "desc")
            ->where("id_overview", 4)->get();

        $overview = $overview[0];
        $overview["items"] = "on working";

        return $overview;
    }

    private function overviewFive()
    {
        $overview = ModelsOverview::select("title", "desc")
            ->where("id_overview", 5)->get();

        $overview = $overview[0];
        $overview["items"] = "on working";

        return $overview;
    }
}
