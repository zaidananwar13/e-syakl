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

        $kelas = Kelas::select('id_kelas', 'judul', 'gambar', 'deskripsi_singkat', 'deskripsi_kelas')
            ->where('id_kelas', '=', $id)
            ->get();

        foreach($kelas as $kel) {
            $kel->jumlah_user = DB::table('kelas_user')
            ->where('id_kelas', '=', $kel->id_kelas)
            ->count();

            $kel->silabus = DB::table('kategori_silabus')
            ->where('id_kelas', '=', $kel->id_kelas)
            ->get();

            $kel->tim_reviewer = DB::table('reviewer')
            ->where('id_reviewer', '=', $kel->id_reviewer)
            ->get();
        }
        
        return $kelas;
    }
}
