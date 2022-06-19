<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $primaryKey = "id_project";
    protected $table = "project";
    protected $fillable = [
        'id_kelas', 'judul', 'deskripsi', 'created_at', 'updated_at'
    ];
}
