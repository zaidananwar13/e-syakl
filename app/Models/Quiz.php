<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    
    protected $table = 'quiz';
    protected $primaryKey = 'id_quiz';
    protected $fillable = [
        'soal', 'id_quiz_container', 'tipe_soal', 'pilihan', 'kunci', 'created_at', 'updated_at'
    ];
}
