<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizProgress extends Model
{
    use HasFactory;
    
    protected $table = 'quiz_progress';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_kategori_silabus', 'id_user', 'created_at', 'updated_at'
    ];
}
