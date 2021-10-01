<?php

namespace App;

use App\Models\SilabusChecker;

class Helper {
  public static function checkSilabusAccess($id_user) { return (count(SilabusChecker::where('id_user', $id_user)->get()) > 0) ? true : false; }
  
  public static function checkSilabusAccessUser($id_user, $id_kategori_silabus, $id_sub_kategori_silabus = null) { 
    $result = SilabusChecker::select('id_user', 'id_kategori_silabus', 'id_sub_kategori_silabus')
      ->where([
        'id_user' => $id_user,
        'id_kategori_silabus' => $id_kategori_silabus,
        'id_sub_kategori_silabus' => $id_sub_kategori_silabus
      ])
      ->orderBy('id_silabus_checker', 'desc')
      ->first();

    if($result != null) $result = $result->toArray();
    
    return $result;
  }
}


