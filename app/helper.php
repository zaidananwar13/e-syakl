<?php

namespace App;

use App\Models\SilabusChecker;
use App\Models\KelasChecker;

class Helper {
  public static function setCookie($key, $val){
    setcookie($key, $val, time() + (3600 * 30), "/");
  }

  public static function getCookie($key){
    return $_COOKIE[$key];
  }

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
  
  public static function checkKelasAccessUser($id_user, $id_kelas) { 
    $result = KelasChecker::select('id_user', 'id_kelas')
    ->where([
      'id_user' => $id_user,
      'id_kelas' => $id_kelas,
    ])
    ->orderBy('id_kelas_checker', 'desc')
    ->first();

    if($result != null) $result = $result->toArray();
    
    return $result;
  }

  public static function generateQuiz($params) {
    $data = [];
    $array = [];

    foreach($params as $param => $value) {
      $temp = [];
      if((strpos($param, "pilihan")) !== false) {
        $temp["pilihan"] = $value;
      }else if((strpos($param, "id_quiz")) !== false) {
        $temp["id_quiz"] = $value;
      }

      if(count($temp) > 0) {
        array_push($data, $temp);
      }
    }

    for($i = 0; $i < count($data); $i = $i + 2) {
      $temp = [
        "id_quiz" => $data[$i]["id_quiz"],
        "pilihan" => $data[$i + 1]["pilihan"]
      ];
      array_push($array, $temp);
    }

    return $array;
  }
}


