<?php

use App\Http\Controllers\Auth\MainController as AuthMainController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\System\UserController;
use Illuminate\Routing\RouteGroup;
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

Route::get('login', function () {
    return view('auth.login');
})->name('login');
Route::post('login',[\App\Http\Controllers\Auth\MainController::class,'login'])->name('action_login');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('{codeView}/index-rumah-data',[MainController::class,'index'])->name('index_rumah_data');
    // Route::post('/store/user',[UserController::class,'store'])->name('user_store');
    Route::resource('user', UserController::class);
    Route::post('logout',[AuthMainController::class,'logout'])->name('logout');

});

Route::get('/layout-desain', function () {
    return view('agregat_dkb.disabilitas.pekerjaan_index');
})->name('layout-desaind');