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

        return $kategori;
    }
}
