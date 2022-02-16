<?php

use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');

Route::any('/ckfinder/examples/{example?}', 'CKSource\CKFinderBridge\Controller\CKFinderController@examplesAction')
->name('ckfinder_examples');


Route::get('/', function () {
    return redirect('login');
});
Route::get('/get', function () {
    return 'Tes route dengan method HTTP get';
});
Route::resource('kelas', 'KelasController');
Route::get('kelas/delete/{id}', 'KelasController@delete');
Route::post('kelas/update', 'KelasController@update');

Route::resource('kategori', 'KategoriController');
Route::get('kategori/delete/{id}', 'KategoriController@delete');
Route::post('kategori/update', 'KategoriController@update');

Route::resource('reviewer', 'ReviewerController');
Route::get('reviewer/delete/{id}', 'ReviewerController@delete');
Route::post('reviewer/update', 'ReviewerController@update');

Route::resource('instansi', 'InstansiController');
Route::get('instansi/delete/{id_instansi}', 'InstansiController@delete');
Route::post('instansi/update', 'InstansiController@update');

Route::resource('kelas_user', 'Kelas_UserController');
Route::get('kelas_user/delete/{id}', 'Kelas_UserController@delete');
Route::post('kelas_user/update', 'Kelas_UserController@update');

Route::resource('quiz', 'QuizController');
Route::get('quiz/delete/{id}', 'QuizController@delete');
Route::post('quiz/update', 'QuizController@update');

Route::resource('products', 'ProductController');
Route::resource('kategori_silabus', 'Kategori_SilabusController');
Route::get('kategori_silabus/delete/{id}', 'Kategori_SilabusController@delete');
Route::post('kategori_silabus/update', 'Kategori_SilabusController@update');

Route::resource('sub_kategori_silabus', 'Sub_Kategori_SilabusController');
Route::get('sub_kategori_silabus/delete/{id}', 'Sub_Kategori_SilabusController@delete');
Route::post('sub_kategori_silabus/update', 'Sub_Kategori_SilabusController@update');
Route::resource('login', 'LoginController');
Route::post('loginPost', 'LoginController@loginPost');
Route::get('logout', 'LoginController@logout');
Route::get('register', 'LoginController@register');
Route::post('registerPost', 'LoginController@registerPost');
Route::get('/home', 'LoginController@indexHome');

Route::get('/quiz/simulation/{id}', [QuizController::class, 'simulation']);
