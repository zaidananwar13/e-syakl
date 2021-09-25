<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        header('Content-Type: application/json; charset=utf-8');

        return User::all()->toArray();
    }
}
