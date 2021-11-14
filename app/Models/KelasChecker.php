<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasChecker extends Model
{
    use HasFactory;
    
    protected $table = 'kelas_checker';
    protected $primaryKey = 'id_kelas_checker';
    protected $fillable = [
        'id_user', 'id_kelas', 'created_at', 'updated_at'
    ];
}
