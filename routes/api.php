<?php

use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\SilabusController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\LoginController;
use Facade\FlareClient\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:api')->get('/user', [UserController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);

Route::get('kategori', [KategoriController::class, 'index']);
Route::get('kelas', [KelasController::class, 'kelas']);
Route::get('kelas/{id}', [KelasController::class, 'index']);
Route::get('getusertoken', [UserController::class, 'index']);

Route::post('kelas/filter', [KelasController::class, 'filter']);
Route::post('kelas/filter/{keywords}', [KelasController::class, 'filter']);

// Route::middleware('checkapitoken')->get('/sub-silabus/{id}', [SilabusController::class, 'silabus']);

Route::middleware(['checkapitoken'])->group(function () {
    Route::get('/kategori-silabus/{id_kelas}', [SilabusController::class, 'index']);
    Route::get('/sub-silabus/{id}', [SilabusController::class, 'silabus']);
    
    Route::post('/kelas/auth', [KelasController::class, 'authKelas']);
    Route::post('/silabus/auth/kategori', [SilabusController::class, 'authKategori']);
    Route::post('/silabus/auth/sub-kategori', [SilabusController::class, 'authSubKategori']);
});


Route::group(['middleware' => ['web']], function () {
    Route::get('/auth/redirect', [LoginController::class, 'redirectToProvider']);
    Route::get('/auth/callback', [LoginController::class, 'handleProviderCallback']);
});
