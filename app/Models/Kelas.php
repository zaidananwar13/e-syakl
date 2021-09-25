<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $fillable = [
        'id_kategori', 'id_reviewer', 'judul', 'langkah', 'level', 'deskripsi_singkat', 'durasi', 'deskripsi_kelas', 'gambar', 'tipe_kelas'
    ];
    public $timestamps = false;
}
