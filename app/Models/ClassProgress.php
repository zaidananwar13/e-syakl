<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassProgress extends Model
{
    use HasFactory;

    protected $table = 'class_progress';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user', 'id_kelas', 'progress', 'created_at', 'updated_at'
    ];
}
