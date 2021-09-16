<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index() {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Kategori API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $kategori = Kategori::select('id_kategori', 'judul', 'gambar', 'deskripsi')->get();


        foreach ($kategori as $k => $v) {
            $id_kelas = DB::table('kelas')
                ->select('id_kelas')
                ->where('id_kategori', $v->id_kategori)
                ->get();
        
            $v->jumlah_kelas = DB::table('kelas')
                ->where('id_kategori', '=', $v->id_kategori)
                ->count();

            $v->jumlah_user = 0;
            foreach($id_kelas as $kelas) {
                $v->jumlah_user += DB::table('kelas_user')
                ->where('id_kelas', '=', $kelas->id_kelas)
                ->count();
            }

            $v->kelas = DB::table('kelas')
            ->where('id_kategori', '=', $v->id_kategori)
            ->get();

        }
        
        if(count($kategori) > 0) {
            $message = [
                'title' => 'E - Syakl | Kategori API',
                'code'=> 200,
                'message'=> 'Retrieving data successful!',
                'data' => $kategori
            ];
        }

        return $message;
    }
}
