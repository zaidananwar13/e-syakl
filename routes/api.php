<?php

use App\Http\Controllers\API\CertificateController;
use App\Http\Controllers\API\FEAuthController;
use App\Http\Controllers\API\KategoriController;
use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\LearningPathController;
use App\Http\Controllers\API\SilabusController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\Migrasi;
use App\Http\Controllers\API\Overview;
use App\Http\Controllers\API\QuizController;
use App\Http\Controllers\API\QuizProgressController;
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

Route::get('overview-{id}', [Overview::class, 'index']);

Route::get('kategori', [KategoriController::class, 'index']);
Route::get('kelas', [KelasController::class, 'kelas']);
Route::get('kelas/{id}', [KelasController::class, 'index']);
Route::get('getusertoken', [UserController::class, 'index']);

Route::get('migrasi', [Migrasi::class, 'index']);
Route::get('migrasi/{mode}', [Migrasi::class, 'index']);

Route::get('register', [UserController::class, 'register']);
Route::post('registerPost', [UserController::class, 'registerPost']);

Route::get('user-register', [UserController::class, 'register']);
Route::post('user-registerPost', [UserController::class, 'registerPost']);

Route::post('kelas/filter', [KelasController::class, 'filter']);
Route::post('kelas/filter/{keywords}', [KelasController::class, 'filter']);

Route::post('kelas/search/{keywords}', [KelasController::class, 'search']);

Route::get('learningpath', [LearningPathController::class, 'index']);
Route::get('learningpath/{id}', [LearningPathController::class, 'index']);

// Route::middleware('checkapitoken')->get('/materi/{id}', [SilabusController::class, 'silabus']);

Route::middleware(['checkapitoken'])->group(function () {
    Route::get('/silabus/{id_kelas}', [SilabusController::class, 'index']);
    Route::get('/silabus/materi/{id}', [SilabusController::class, 'silabus']);
    
    Route::post('/kelas/auth', [KelasController::class, 'authKelas']);
    Route::post('/kelas/check', [KelasController::class, 'checkKelas']);
    Route::post('/kelas/complete', [KelasController::class, 'completeClass']);
    Route::post('/kelas/user/update/', [FEAuthController::class, 'feAuthorizer']);
    Route::post('/auth/silabus', [SilabusController::class, 'authKategori']);
    Route::post('/auth/materi', [SilabusController::class, 'authSubKategori']);
    
    Route::post('/quiz', [QuizController::class, 'index']);
    Route::post('/quiz/submit', [QuizController::class, 'submit']);
    Route::post('/quiz/clear', [QuizProgressController::class, 'index']);
    Route::post('/quiz/is-clear', [QuizProgressController::class, 'isClear']);

    Route::post('/certificate', [CertificateController::class, 'index']);
    // Route::post('/certificate/create', [CertificateController::class, 'create']);

    // Route::post('/my-class', [KelasController::class, 'myClasss']);
    
    // Route::post('/user/profile', [UserController::class, 'profile']);
    Route::post('/my-class', [UserController::class, 'profile']);
    Route::post('/my-class/classroom', [UserController::class, 'classroom']);


    Route::post('/auth/syllabus', [FEAuthController::class, 'index']);
});


Route::group(['middleware' => ['web']], function () {
    Route::get('/auth/redirect', [LoginController::class, 'redirectToProvider']);
    Route::get('/auth/callback', [LoginController::class, 'handleProviderCallback']);
});
