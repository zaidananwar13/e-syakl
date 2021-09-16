<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori_Silabus extends Model
{
    use HasFactory;
    protected $table = 'kategori_silabus';
    protected $primaryKey = 'id_kategori_silabus';
    protected $fillable = [
        'id_kelas', 'judul'
    ];
    public $timestamps = false;
}
