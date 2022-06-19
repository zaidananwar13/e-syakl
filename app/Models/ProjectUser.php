<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    use HasFactory;
    protected $primaryKey = "id_project_user";
    protected $table = "project_user";
    protected $fillable = [
        'id_user', 'id_project', 'expired', 'created_at', 'updated_at'
    ];
}
