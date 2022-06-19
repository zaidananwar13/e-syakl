<?php

namespace App\Http\Controllers\API;

use App\Helper as Help;
use App\Http\Controllers\Controller;
use App\Models\ClassProgress;
use App\Models\CompletedClass;
use App\Models\Kategori;
use App\Models\Kategori_Silabus;
use App\Models\User;
use App\Models\KelasChecker;
use Illuminate\Http\Request;

use App\Models\Kelas;
use App\Models\LearningPath;
use App\Models\LearningPathClass;
use App\Models\SilabusChecker;
use App\Models\Sub_Kategori_Silabus;
use Hamcrest\Type\IsString;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class KelasController extends Controller
{

    public function index($id = null) {
        if(!is_numeric($id)) {
            abort(404);
        }

        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Kelas API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $kelas = Kelas::select('id_kelas', 'id_reviewer', 'judul', 'gambar', 'langkah', 'level', 'durasi', 'deskripsi_singkat', 'deskripsi_kelas')
            ->where('id_kelas', '=', $id)
            ->get();

        foreach($kelas as $kel) {
            $kel->jumlah_user = DB::table('kelas_user')
            ->where('id_kelas', '=', $kel->id_kelas)
            ->count();

            $komentar = DB::table('kelas_user')
            ->select('id_kelas_user', 'id_kelas', 'id_user', 'point_review', 'komentar_review')
            ->where('id_kelas', '=', $kel->id_kelas)
            ->get();

            
            foreach($komentar as $kom) {
                $nama_komentar = DB::table('user')
                ->select('name', 'avatar_original')
                ->where('id_user', '=', $kom->id_user)
                ->first();
    
                $kom->nama = $nama_komentar->name;
                $kom->img = $nama_komentar->avatar_original;
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

            $kel->komentar = $komentar;

            $kel->silabus = DB::table('kategori_silabus')
            ->select('id_kategori_silabus', 'judul', 'deskripsi')
            ->where('id_kelas', '=', $kel->id_kelas)
            ->get();
            
            foreach($kel->silabus as $silabus) {
                $silabus->materi = DB::table('sub_kategori_silabus')
                ->select('id_sub_kategori_silabus', 'judul', 'deskripsi')
                ->where('id_kategori_silabus', '=', $silabus->id_kategori_silabus)
                ->get();
            }

            $kel->tim_reviewer = DB::table('reviewer')
            ->select('id_reviewer', 'nama', 'foto', 'jabatan', 'portofolio')
            ->where('id_reviewer', '=', $kel->id_reviewer)
            ->get();
        }

        if(count($kelas) > 0) {
            $message = [            'title' => 'E - Syakl | Kategori API',            'title' => 'E - Syakl | Kategori API',
            'title' => 'E - Syakl | Kelas API',
                'code'=> 200,
                'message'=> 'Retrieving data successful!',
                'data' => $kelas
            ];
        }
        
        return $message;
    }

    public function kelas() {

        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Kelas API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $kelas = Kelas::select('id_kategori', 'id_kelas', 'id_reviewer', 'judul', 'gambar', 'langkah', 'level', 'durasi', 'deskripsi_singkat', 'deskripsi_kelas')
            ->get();

        foreach($kelas as $kel) {
            $kategori = Kategori::select('judul')
                ->where('id_kategori', $kel->id_kategori)
                ->first()
                ->toArray();

            $kel->kategori = $kategori['judul'];
            unset($kel->id_kategori);

            $kel->jumlah_user = DB::table('kelas_user')
            ->where('id_kelas', '=', $kel->id_kelas)
            ->count();

            $komentar = DB::table('kelas_user')
            ->select('id_kelas_user', 'id_kelas', 'id_user', 'point_review', 'komentar_review')
            ->where('id_kelas', '=', $kel->id_kelas)
            ->get();

            
            foreach($komentar as $kom) {
                $nama_komentar = DB::table('user')
                ->select('name', 'avatar_original')
                ->where('id_user', '=', $kom->id_user)
                ->first();
    
                $kom->nama = $nama_komentar->name;
                $kom->img = $nama_komentar->avatar_original;
            }

            $ratings = [];
            $rating = 0;
            
            foreach($komentar as $kom) {
                $ratings[]= $kom->point_review;
            }
            
            foreach($ratings as $rat) {
                $rating += $rat;
            }

            $learningPath = LearningPathClass::where("id_kelas",$kel->id_kelas)->first();

            $kel->rating = (float) number_format($rating /= ((count($ratings) == 0) ? 1 : count($ratings)), 2);
            $kel->komentar = $komentar;
            $kel->learningPath = LearningPath::select("name")
                ->where("id_learning_path", $learningPath->id_learning_path)->first();
            $kel->learningPath = $kel->learningPath->name;
            $kel->classType = "free";

            $kel->silabus = DB::table('kategori_silabus')
            ->select('id_kategori_silabus', 'judul', 'deskripsi')
            ->where('id_kelas', '=', $kel->id_kelas)
            ->get();
            
            foreach($kel->silabus as $silabus) {
                $silabus->materi = DB::table('sub_kategori_silabus')
                ->select('id_sub_kategori_silabus', 'judul', 'deskripsi')
                ->where('id_kategori_silabus', '=', $silabus->id_kategori_silabus)
                ->get();
            }

            $kel->tim_reviewer = DB::table('reviewer')
            ->select('id_reviewer', 'nama', 'foto', 'jabatan', 'portofolio')
            ->where('id_reviewer', '=', $kel->id_reviewer)
            ->get();
        }

        if(count($kelas) > 0) {
            $message = [            'title' => 'E - Syakl | Kategori API',            'title' => 'E - Syakl | Kategori API',
            'title' => 'E - Syakl | Kelas API',
                'code'=> 200,
                'message'=> 'Retrieving data successful!',
                'data' => $kelas
            ];
        }
        
        return $message;
    }

    public function filter(Request $request, $keywords = null) {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Kelas API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        
        $filters = json_decode($request->getContent(), true);
        $filters = $filters['filters'];

        $filtered = [];
        $kelas = Kelas::all()->toArray();

        if($keywords != null) {
            $keywords = strtolower($keywords);
            $kelas = Kelas::select('*')
                ->orWhere(DB::raw('lower(judul)'), 'like', '%' . $keywords . '%')
                ->orWhere(DB::raw('lower(level)'), 'like', '%' . $keywords . '%')
                ->orWhere(DB::raw('lower(deskripsi_singkat)'), 'like', '%' . $keywords . '%')
                ->orWhere(DB::raw('lower(deskripsi_kelas)'), 'like', '%' . $keywords . '%')
                ->orWhere(DB::raw('lower(durasi)'), 'like', '%' . $keywords . '%')
                ->get();

            $kelas = $kelas->toArray();
        }

        foreach($kelas as $kel) {
            $stats = [];

            foreach($filters['rules'] as $f_key => $f_value) {
                if(strtolower($kel[$f_key]) == strtolower($f_value)) {
                    $stats[]= true;
                }else {
                    $stats[]= false;
                }
            }

            $pointer = count($stats);
            foreach($stats as $stat) {
                if($stat == true) {
                    $pointer--;
                }
            }

            if($pointer == 0) {
                $filtered[]= $kel;
            }
        }

        if(count($filtered) > 0) {
            $message = [
            'title' => 'E - Syakl | Kelas API',
                'code'=> 200,
                'message'=> 'Retrieving data successful!',
                'data' => $filtered
            ];
        }
        
        return $message;
    }

    public function search(Request $request, $keyword) {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Search API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $kelas = [];

        if($keyword != null) {
            $keyword = strtolower($keyword);
            $keyword = explode(' ', $keyword);
            
            foreach($keyword as $key) {
                $data = Kelas::select('*')
                    ->where(DB::raw('lower(judul)'), 'like', '%' . $key . '%')
                    ->orWhere(DB::raw('lower(level)'), 'like', '%' . $key . '%')
                    ->orWhere(DB::raw('lower(deskripsi_singkat)'), 'like', '%' . $key . '%')
                    ->orWhere(DB::raw('lower(deskripsi_kelas)'), 'like', '%' . $key . '%')
                    ->orWhere(DB::raw('lower(durasi)'), 'like', '%' . $key . '%')
                    ->get();

                array_push($kelas, $data);
            }
        }

        if(count($kelas) > 0) {
            $message = [
            'title' => 'E - Syakl | Kelas API',
                'code'=> 200,
                'message'=> 'Retrieving data successful!',
                'data' => $kelas
            ];
        }
        
        return $message;
    }

    public function authKelas(Request $request) {
        $req = $request->all();
        $message = [
            'title' => 'E - Syakl | Silabus Auth API',
            'code' => 401,
            'message' => 'Unauthorized'
        ];

        try {
            
            $user = User::select('id_user')
                ->where('api_token', $req['api_token'])
                ->first();

            if($user != null) {
                $user = $user->toArray();
                $userKelas = Help::checkKelasAccessUser($user['id_user'], $req['kelas']);

                if($userKelas == null) {
                    $kelasCheck = Kelas::select('id_kelas')
                        ->where('id_kelas', $req['kelas'])->get()->toArray();
                    
                    if($kelasCheck != null) {
                        $progress = new ClassProgress();
                        $progress->id_user = $user["id_user"];
                        $progress->id_kelas = $req['kelas'];
                        $progress->progress = "5";
                        $progress->save();

                        $silabus = Kategori_Silabus::select("id_kategori_silabus")
                            ->first()
                            ->where("id_kelas", $req['kelas'])->get()->toArray();
			
			// bakal error kalo silabus kosong
                        $silabus = $silabus[0];

                        $subSilabus = Sub_Kategori_Silabus::select("id_sub_kategori_silabus")
                        ->first()
                        ->where("id_kategori_silabus", $silabus['id_kategori_silabus'])->get()->toArray();
                        $subSilabus = $subSilabus[0];

                        $kelasChecker = new KelasChecker();
                        $kelasChecker->id_user = $user['id_user'];
                        $kelasChecker->id_kelas = $req['kelas'];
                        $kelasChecker->save();

                        $silabuscheck = new SilabusChecker;
                        $silabuscheck->id_user = $user['id_user'];
                        $silabuscheck->id_kategori_silabus = $silabus['id_kategori_silabus'];
                        $silabuscheck->id_sub_kategori_silabus = $subSilabus['id_sub_kategori_silabus'];
                        $silabuscheck->id_bahasa = $subSilabus['id_sub_kategori_silabus'];
                        $silabuscheck->save();

                        $message['code'] = 200;
                        $message['message'] = 'Class register success!';

                        return $message;
                    }else {
                        $message['code'] = 410;
                        $message['message'] = 'Illegal class Access!';
                    }
                }else {
                    $message['code'] = 409;
                    $message['message'] = 'Already registered';
                }

            }
        }catch (Exception $e) {
            $error_handler = [
                "23503" => "Foreign key violates",
                "23505" => "Duplicate key"
            ];
            $data = json_encode($e);
            $data = json_decode($data);
            
            $message['status'] = $error_handler[$data->errorInfo[0]];
            $message['code'] = 409;
            $message['message'] = 'Already registered';

            switch($message['status']) {
                case "Foreign key violates":
                    $message['message'] = 'Illegal access detected ';
                    
                    break;
                case "Duplicate key":
                    $message['message'] = 'Already registered';
                    
                    break;
                default:
                    break;
            }

        }

        return $message;
    }

    
    public function checkKelas(Request $request) {
        $req = $request->all();
        $message = [
            'title' => 'E - Syakl | Silabus Auth API',
            'code' => 401,
            'message' => 'Unauthorized'
        ];
            
        $user = User::select('id_user')
            ->where('api_token', $req['api_token'])
            ->first();
            
        $user = $user->toArray();
        $userKelas = Help::checkKelasAccessUser($user['id_user'], $req['kelas']);

        if($userKelas == null) {
            $message['code'] = 1919;
            $message['message'] = "Haven't enlisted yet";
        }else {
            $message['code'] = 409;
            $message['message'] = 'Already registered';
        }

        return $message;
    }

    public function completeClass(Request $request) {
        $message = [
            'title' => 'E - Syakl | Silabus Auth API',
            'code' => 401,
            'message' => 'Unauthorized'
        ];

        $user = User::select("id_user")->where("api_token", $request->input("api_token"))->first()->toArray();
        ClassProgress::where("id_user", $user["id_user"])->where("id_kelas", $request->input("kelas"))
            ->update(["progress" => "100"]);
            

        $class = new CompletedClass();
        $class->id_user = $user["id_user"];
        $class->id_kelas = $request->input("kelas");
        
        if($class->save()) {
            $message = [
                'title' => 'E - Syakl | Kelas Auth API',
                'code' => 200,
                'message' => "Class Completed!"
            ];
        }

        return $message;
    }

    public function myClass(Request $request) {
        $api = [
            'title' => 'E - Syakl | Kelas API',
            'code' => 404,
            'message' => "User's Class Not Found"
        ];

        
        // $class = Kelas::select("judul")->where("")

        return $api;
    }
}
