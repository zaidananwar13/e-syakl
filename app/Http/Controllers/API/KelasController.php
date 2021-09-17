<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kelas;
use Hamcrest\Type\IsString;
use Illuminate\Support\Facades\DB;

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

        $kelas = Kelas::select('id_kelas', 'id_reviewer', 'judul', 'gambar', 'deskripsi_singkat', 'deskripsi_kelas')
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
                ->select('username')
                ->where('id_user', '=', $kom->id_user)
                ->first();
    
                $kom->nama = $nama_komentar->username;
            }

            $ratings = [];
            $rating = 0;
            
            foreach($komentar as $kom) {
                $ratings[]= $kom->point_review;
            }
            
            foreach($ratings as $rat) {
                $rating += $rat;
            }


            $kel->rating = (float) number_format($rating /= count($ratings), 2);
            $kel->komentar = $komentar;

            $kel->silabus = DB::table('kategori_silabus')
            ->select('id_kategori_silabus', 'judul')
            ->where('id_kelas', '=', $kel->id_kelas)
            ->get();

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
            $kelas = Kelas::select('*')
                ->where('judul', 'like', '%' . $keywords . '%')
                ->get();

            $kelas = $kelas->toArray();
        }

        foreach($kelas as $kel) {
            $stats = [];

            foreach($filters['rules'] as $f_key => $f_value) {
                if($kel[$f_key] == $f_value) {
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
            $message = [                'title' => 'E - Syakl | Kategori API',                'title' => 'E - Syakl | Kategori API',
            'title' => 'E - Syakl | Kelas API',
                'code'=> 200,
                'message'=> 'Retrieving data successful!',
                'data' => $filtered
            ];
        }
        
        return $message;
    }
}
