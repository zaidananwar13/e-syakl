<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificate';
    protected $primaryKey = 'id_certificate';
    protected $fillable = [
        'id_user', 'id_kelas', 'token', 'created_at', 'updated_at'
    ];
}
