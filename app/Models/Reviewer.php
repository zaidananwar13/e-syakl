<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    use HasFactory;
    protected $table = 'reviewer';
    protected $primaryKey = 'id_reviewer';
    protected $fillable = [
        'nama', 'jabatan', 'foto', 'portofolio'
    ];
    public $timestamps = false;
}
