<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', function () {
    return view('auth.login');
})->name('login');
Route::get('/layout-desain', function () {
    return view('agregat_dkb.disabilitas.pekerjaan_index');
})->name('layout-desaind');
Route::get('{codeView}/index-rumah-data',[MainController::class,'index'])->name('index_rumah_data');