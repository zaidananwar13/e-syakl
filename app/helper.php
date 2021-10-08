<?php

namespace App;

use App\Models\SilabusChecker;

class Helper {
  public static function checkSilabusAccess($id_user, $id_sub) { return SilabusChecker::select('id_sub_kategori_silabus')->where('id_user', $id_user)->where('id_sub_kategori_silabus', $id_sub)->get()->toArray(); }
  
  public static function checkSilabusAccessUser($id_user, $id_kategori_silabus, $id_sub_kategori_silabus = null) { 

    if($id_sub_kategori_silabus == null) {
      $result = SilabusChecker::select('id_user', 'id_kategori_silabus', 'id_sub_kategori_silabus')
        ->where([
          'id_user' => $id_user,
          'id_kategori_silabus' => $id_kategori_silabus
        ])
        ->orderBy('id_silabus_checker', 'desc')
        ->first();

    }else {
      $result = SilabusChecker::select('id_user', 'id_kategori_silabus', 'id_sub_kategori_silabus')
        ->where([
          'id_user' => $id_user,
          'id_kategori_silabus' => $id_kategori_silabus,
          'id_sub_kategori_silabus' => $id_sub_kategori_silabus
        ])
        ->orderBy('id_silabus_checker', 'desc')
        ->first();
    }

    if($result != null) $result = $result->toArray();
    
    return $result;
  }
}


