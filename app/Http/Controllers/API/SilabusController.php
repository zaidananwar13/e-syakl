<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kategori_Silabus;
use App\Models\Sub_Kategori_Silabus;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class SilabusController extends Controller
{
    public function index($id) {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Silabus API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $kategori_silabus = Kategori_Silabus::select('id_kategori_silabus', 'id_kelas', 'judul')
            ->where('id_kelas', $id)->get();

        foreach($kategori_silabus as $k_silabus) {
            $k_silabus->sub_kategori_silabus = Sub_Kategori_Silabus::select('id_sub_kategori_silabus', 'id_kategori_silabus', 'judul', 'konten')
                ->where('id_kategori_silabus', $k_silabus->id_kategori_silabus)->get();
        }

        if(count($kategori_silabus) > 0) {
            $message = [
                'title' => 'E - Syakl | Silabus API',
                'code'=> 200,
                'message'=> 'Retrieving data successful!',
                'data' => $kategori_silabus
            ];
        }

        return $message;
    }

    public function silabus($id)
    {
        header('Content-Type: application/json; charset=utf-8');
        $message = [
            'title' => 'E - Syakl | Silabus API',
            'code' => 404,
            'message' => 'Not Found'
        ];

        $silabus = Sub_Kategori_Silabus::select('id_sub_kategori_silabus', 'id_kategori_silabus', 'judul', 'konten')
            ->where('id_sub_kategori_silabus', $id)->first();
        
        if($silabus != null) {
            $message = [
                'title' => 'E - Syakl | Silabus API',
                'code'=> 200,
                'message'=> 'Retrieving data successful!',
                'data' => $silabus
            ];
        }

        return $message;
    }
}
