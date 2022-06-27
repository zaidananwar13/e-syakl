<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizContainer extends Model
{
    use HasFactory;
    
    protected $table = 'quiz_container';
    protected $primaryKey = 'id_quiz_container';
    protected $fillable = [
        'desc', 'id_sub_kategori_silabus', 'created_at', 'updated_at'
    ];
}
