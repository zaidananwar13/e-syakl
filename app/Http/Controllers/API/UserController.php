<?php

namespace App\Http\Controllers\API;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\ClassProgress;
use App\Models\CompletedClass;
use App\Models\FEAuthorizer;
use App\Models\Kategori_Silabus;
use App\Models\Kelas;
use App\Models\KelasHistory;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\QuizProgress as ModelsQuizProgress;
use App\Models\Reviewer;
use App\Models\Sub_Kategori_Silabus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use QuizProgress;

class UserController extends Controller
{
    public function index()
    {
        header('Content-Type: application/json; charset=utf-8');

        return User::all()->toArray();
    }

    public function register()
    {
        return view('test.register');
    }

    public function registerPost(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'repassword' => 'required',
            'agreeTerms' => 'checked'
        ]);

        $data = User::where('email', $request->email)->first();

        if ($data) {
            return redirect('api/register')->with('info', 'Email sudah terdaftar');
        } elseif ($request->password != $request->repassword) {
            return redirect('api/register')->with('warning', 'Password harus diisi sama');
        } else {
            $name = explode('@', $request->email);
            $name = $name[0];

            $data =  new User();
            $data->name = $name;
            $data->email = $request->email;
            $data->google_id = "default";
            $data->password = bcrypt($request->password);
            $data->api_token = hash('sha256', Str::random(60));
            $data->save();

            return redirect('api/register')->with('success', 'Kamu berhasil Register');
        }
    }

    public function profile(Request $request)
    {
        // header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Quiz API',
            'code' => 403,
            'message' => 'Not Found'
        ];

        if ($request->input("api_token") == null) {
            $message["message"] = "Access Forbidden! What are you looking for?";
            return $message;
        }

        $user = User::select("id_user", "name", "email", "created_at")
            ->where("api_token", $request->input("api_token"))
            ->first()->toArray();

        $classProgress = ClassProgress::select("id_kelas", "progress")->distinct()
            ->where("id_user", $user["id_user"])
            ->where("progress", "!=", "100")->get();

        $classCompleted = CompletedClass::where("id_user", $user["id_user"])->get()->toArray();

        $temp = [];
        if (count($classProgress) > 0) {
            foreach ($classProgress as $class) {

                $class_temp = Kelas::select("id_kelas", "gambar", "judul")->where("id_kelas", $class["id_kelas"])->first()->toArray();
                $history = KelasHistory::select("id_sub_kategori_silabus", "id_kategori_silabus")
                    ->where("id_user", $user["id_user"])
                    ->where("id_kelas", $class["id_kelas"])
                    ->first();

                $class_temp["last_material"] = "You haven't taken a syllabus yet";

                if ($history != null) {
                    $class_temp["last_material"] = $history->id_sub_kategori_silabus;
                }

                $project = Project::select("id_project")->where("id_kelas", $class["id_kelas"])
                    ->first();

                if ($project != null) {
                    $classProject = ProjectUser::select("id_project", "expired")
                        ->where("id_project", $project->id_project)
                        ->where("id_user", $user["id_user"])->first();
                } else {
                    $classProject = null;
                }

                $class_temp["project_class"] = $classProject;
                if ($classProject != null) {
                    $projectID = Project::select("judul")->where("id_project", $classProject["id_project"])->first();
                    $class_temp["project_class"]["title"] = $projectID->judul;
                    $class_temp["project_class"]["status"] = "";
                    $class_temp["project_class"]["due"] = "";

                    unset($class["id_project"]);

                    $present = Carbon::now();
                    $due = new Carbon($classProject->expired);

                    if ($present->toDayDateTimeString() > $due->toDayDateTimeString()) {
                        $class_temp["project_class"]["status"] = "expired";
                        $class_temp["project_class"]["due"] = "expired";
                    } else {
                        $diff = $due->diffInDays($present);

                        $class_temp["project_class"]["status"] = "on-progress";
                        $class_temp["project_class"]["due"] = "$diff days";
                        if ($diff <= 7) {
                            $class_temp["project_class"]["status"] = "alert";
                        } else if ($diff == 1) {
                            $class_temp["project_class"]["status"] = "today";
                            $class_temp["project_class"]["due"] = "Today";
                        }
                    }
                } else {
                    $class_temp["project_class"] = "No Project Yet";
                }

                $histories = KelasHistory::select("id_kategori_silabus")
                    ->where("id_kelas", $class->id_kelas)
                    ->where("id_user", $user["id_user"])
                    ->first();

                if ($histories == null) {
                    $histories["id_kategori_silabus"] = 0;
                } else {
                    $histories = $histories->toArray();
                }

                // chapter counter
                $silabus = Kategori_Silabus::select("id_kelas", "id_kategori_silabus")
                    ->where("id_kelas", $class["id_kelas"])
                    ->get()->toArray();

                $syllData = [];
                $feCounter = 1;
                foreach ($silabus as $syll) {
                    $material = Sub_Kategori_Silabus::select("id_sub_kategori_silabus")
                        ->where("id_kategori_silabus", $syll["id_kategori_silabus"])
                        ->get();

                    $temps = [];
                    for ($i = 1; $i <= count($material); $i++) {
                        array_push($temps, $feCounter);
                        $feCounter++;
                    }array_push($temps, $feCounter);$feCounter++;

                    array_push($syllData, $temps);
                }

                $feAuth = FEAuthorizer::select("unlocked")
                    ->where("id_user", $user["id_user"])
                    ->where("id_kelas", $class->id_kelas)
                    ->first();

                $chapter = 0;
                $chapters = count($silabus);
                $status = true;
                foreach ($syllData as $data) {
                    $chapter++;
                    for ($i = 0; $i < count($data); $i++) {
                        if ($feAuth->unlocked == $data[$i]) {
                            $status = false;
                        }
                    }
                    if ($status == false) break;
                }

                $class_temp["progress_class"] = "$chapter of $chapters chapters.";;
                array_push($temp, $class_temp);
            }
        }

        // var_dump($classProgress->toArray()); die;

        $projects = ProjectUser::select("id_project", "expired")
            ->where("id_user", $user["id_user"])->get();

        if (count($projects) > 0) {
            foreach ($projects as $userProject) {
                $projectID = Project::select("judul")->where("id_project", $userProject->id_project)->first();
                $userProject->title = $projectID->judul;
                $userProject->status = "";
                $userProject->due = "";
                unset($userProject->id_project);

                $present = Carbon::now();
                $due = new Carbon($userProject->expired);

                if ($present->toDayDateTimeString() > $due->toDayDateTimeString()) {
                    $userProject->status = "expired";
                    $userProject->due = "expired";
                } else {
                    $diff = $due->diffInDays($present);

                    $userProject->status = "on-progress";
                    $userProject->due = "$diff days";
                    if ($diff <= 7) {
                        $userProject->status = "alert";
                    } else if ($diff == 1) {
                        $userProject->status = "today";
                        $userProject->due = "Today";
                    }
                }
            }
        } else {
            $projects = "You haven't taken a project yet";
        }

        $temp2 = [];
        if (count($classCompleted) > 0) {
            foreach ($classCompleted as $class) {
                $class_temp = Kelas::select("id_kelas", "gambar", "judul")->where("id_kelas", $class["id_kelas"])->first()->toArray();
                $class_temp["date"] = CompletedClass::select("created_at")->where("id_kelas", $class["id_kelas"])
                    ->where("id_user", $user["id_user"])->first()->toArray();
                $class_temp["date"] = Helper::time_elapsed_string($class_temp["date"]["created_at"]);
                array_push($temp2, $class_temp);
            }
        }

        $profile = [
            "name" => $user["name"],
            "email" => $user["email"],
            "joined" => "Joined since " . Helper::time_elapsed_string($user["created_at"]),
            "class_on_progress" => count($classProgress),
            "completed_classes" => count($classCompleted),
            "class_progress" => $temp,
            "class_completed" => $temp2,
            "project" => $projects
        ];


        $message = [
            'title' => 'E - Syakl | User API',
            'code' => 200,
            'message' => 'Ok.',
            'data' => $profile
        ];

        return response($message, $message["code"]);
    }

    public function classroom(Request $request)
    {
        // header('Content-Type: application/json; charset=utf-8');
        $api = [
            'title' => 'E - Syakl | Classroom API',
            'code' => 200,
            'message' => 'Ok.'
        ];

        $token = $request->input("api_token");
        $kelas = $request->input("class");

        if ($token == null || $kelas == null) {
            $api["message"] = "Access Forbidden! What are you looking for?";
            $api["code"] = 401;
            return response($api, $api['code']);
        }

        $user = User::select("id_user", "name", "email", "created_at")
            ->where("api_token", $request->input("api_token"))
            ->first()->toArray();

        // quiz history
        $quizHistories = ModelsQuizProgress::select("id_kategori_silabus", "created_at", "grade")
            ->where("id_user", $user["id_user"])
            ->get();

        // teacher
        $class = Kelas::select("id_reviewer")
            ->where("id_kelas", $kelas)
            ->first();

        $teachers = Reviewer::select("id_reviewer", "nama", "foto")
            ->where("id_reviewer", $class->id_reviewer)
            ->get();

        foreach ($teachers as $teacher) {
            $teacher->id_teacher = $teacher->id_reviewer;
            unset($teacher->id_reviewer);
        }

        foreach ($quizHistories as $hist) {
            $syllabus = Kategori_Silabus::select("judul")
                ->where("id_kategori_silabus", $hist->id_kategori_silabus)
                ->first();

            $hist->quiz_title = $syllabus->judul;
            $hist->date = Carbon::parse($hist->created_at)->format('d F Y');
            $hist->score = number_format(($hist->grade), 1, ".", "");
            unset($hist->created_at);
            unset($hist->grade);
            unset($hist->id_kategori_silabus);
        }

        $classProgress = ClassProgress::select("id_kelas", "progress")->distinct()
            ->where("id_user", $user["id_user"])
            ->where("id_kelas", $kelas)->first();

        if ($classProgress == null)
            return response($api = [
                'title' => 'E - Syakl | Classroom API',
                'code' => 404,
                'message' => 'Your Class is Found in Nowhere? :/.'
            ], $api["code"]);

        $history = KelasHistory::select("id_sub_kategori_silabus")
            ->where("id_user", $user["id_user"])
            ->where("id_kelas", $classProgress["id_kelas"])
            ->first();
        $material = "";

        if ($history == null)
            $material = "You have never taken your class yet";
        else
            $material = $history->id_sub_kategori_silabus;

        $class = Kelas::select("judul", "id_kelas")
            // kalo error brati blum daftar kelas 
            ->where("id_kelas", $classProgress->id_kelas)->first();
        unset($classProgress->id_kelas);

        // class progress
        $histories = KelasHistory::select("id_kategori_silabus")
            ->where("id_kelas", $class->id_kelas)
            ->where("id_user", $user["id_user"])
            ->first();

        if ($histories == null) {
            $histories["id_kategori_silabus"] = 0;
        } else {
            $histories = $histories->toArray();
        }

        // chapter counter
        $silabus = Kategori_Silabus::select("id_kelas", "id_kategori_silabus")
            ->where("id_kelas", $class["id_kelas"])
            ->get()->toArray();

        $syllData = [];
        $feCounter = 1;
        foreach ($silabus as $syll) {
            $material = Sub_Kategori_Silabus::select("id_sub_kategori_silabus")
                ->where("id_kategori_silabus", $syll["id_kategori_silabus"])
                ->get();

            $temps = [];
            for ($i = 1; $i <= count($material); $i++) {
                array_push($temps, $feCounter);
                $feCounter++;
            }

            array_push($syllData, $temps);
        }

        $feAuth = FEAuthorizer::select("unlocked")
            ->where("id_user", $user["id_user"])
            ->where("id_kelas", $class->id_kelas)
            ->first();

        $chapter = 0;
        $chapters = count($silabus);
        $status = true;
        foreach ($syllData as $data) {
            $chapter++;
            for ($i = 0; $i < count($data); $i++) {
                if ($feAuth->unlocked == $data[$i]) {
                    $status = false;
                }
            }
            if ($status == false) break;
        }

        $classProgress->progress = "$chapter of $chapters chapters.";

        // certificate
        $certificate = Certificate::select("created_at")
            ->where("id_user", $user["id_user"])
            ->where("id_kelas", $class["id_kelas"])
            ->first();

        if ($certificate != null) {
            $certificate->date = Carbon::parse($certificate->created_at)->format('d F Y');

            $expired = Carbon::createFromFormat('Y-m-d H:i:s', $certificate->created_at)->addYears(2)->format('d F Y');
            $certificate->expired = $expired;
            $certificate->status = ($expired < Carbon::now()->format('d F Y')) ? "expired" : "available";
            $certificate->message = ($expired < Carbon::now()->format('d F Y')) ? "Expired at $certificate->expired" : "Available until $certificate->expired";

            unset($certificate->created_at);
            unset($certificate->date);
            unset($certificate->expired);
        } else {
            $certificate = [
                "status" => "on-progress", "message" => "You haven't finish this class yet"
            ];
        }

        $api["data"] = [
            "class" => $class->judul,
            "teachers" => $teachers,
            "last_material" => $material,
            "learning_path" => "Nahwu Dummyy Path",
            "class_progress" => $classProgress->progress,
            "certificate" => $certificate,
            "quiz" => $quizHistories,
            "project" => [
                "project_title" => "Project Akhir: Nahwu Beginner",
                "date" => "2013-12-25",
                "status" => "on-progress"
            ]
        ];

        return response($api, $api['code']);
    }
}
