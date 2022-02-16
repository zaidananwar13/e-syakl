<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedClass extends Model
{
    use HasFactory;

    protected $table = 'completed_classes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user', 'id_kelas', 'created_at', 'updated_at'
    ];
}
