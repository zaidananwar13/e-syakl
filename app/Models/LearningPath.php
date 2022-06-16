<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningPath extends Model
{
    use HasFactory;
    
    protected $table = 'learning_path';
    protected $primaryKey = 'id_learning_path';
}
