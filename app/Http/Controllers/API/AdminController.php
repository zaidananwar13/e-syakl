<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        header('Content-Type: application/json; charset=utf-8');

        return Admin::all()->toArray();
    }
}
