<?php

use App\Http\Controllers\Auth\MainController as AuthMainController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\System\CalculateDataController;
use App\Http\Controllers\System\MainController as SystemMainController;
use App\Http\Controllers\System\RoleController;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\System\DataAvailabilityController;
use App\Http\Controllers\System\WilayahController;
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
})->name('login')->middleware(['guest']);
Route::post('login', [\App\Http\Controllers\Auth\MainController::class, 'login'])->name('action_login');

Route::middleware(['auth', 'user.active'])->group(function () {
    Route::get('/', function () {
        return view('dashboard.home');
    })->name('home');
    //dataJson
    Route::get('data_json/dashboard',[MainController::class,'dataDashboard']);
    //layout view side bar
    Route::get('{codeView}/index-rumah-data', [MainController::class, 'index'])->name('index_rumah_data');
    Route::group(['middleware' => ['can:import_data']], function () {
        Route::get('/form-import', function () {
            return view('pengaturan.import_data.form_input');
        })->name('import_data_excel');
        Route::post('system/import-data', [SystemMainController::class, 'importData'])->name('import_data');
    });
    Route::group(['middleware' => ['can:pengaturan']], function () {
        Route::resource('role', RoleController::class);
        Route::resource('user', UserController::class);
        Route::patch('user/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggle_status');
    });
    //auth
    Route::post('logout', [AuthMainController::class, 'logout'])->name('logout');
    Route::post('change-password', [AuthMainController::class, 'changePassword'])->name('change_password');
    // ── Data Availability ───────────────────────────────────────────────────
    // check: semua user login (respons disesuaikan berdasarkan role di controller)
    Route::get('data-availability/check', [DataAvailabilityController::class, 'check'])
        ->name('data_availability.check');
    // dashboard & summary: admin only (can:pengaturan)
    Route::group(['middleware' => ['can:pengaturan']], function () {
        Route::get('data-availability/dashboard', [DataAvailabilityController::class, 'dashboard'])
            ->name('data_availability.dashboard');
        Route::get('data-availability/summary', [DataAvailabilityController::class, 'summary'])
            ->name('data_availability.summary');
    });
    // ── Wilayah ─────────────────────────────────────────────────────────────
    //wilayah kelurahan
    Route::get('json/wilayah-kecamatan', [WilayahController::class, 'indexKecamatan']);
    Route::get('json/wilayah-kelurahan',  [WilayahController::class, 'indexKelurahan']);
    //search master data
    Route::post('json/search-data/{jenisData}', [SystemMainController::class, 'searchData'])->name('search_data');
});


Route::get('/layout', function () {
    return view('costum_date_range.disabilitas_pendidikan');
});

