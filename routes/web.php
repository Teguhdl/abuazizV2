<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, AkunController, SekolahController, SiswaController, KelasController};



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


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::resource('akun', AkunController::class);
Route::resource('kelas', KelasController::class)->parameters([
    'kelas' => 'kelas' 
]);

Route::resource('siswa', SiswaController::class);
Route::resource('sekolah', SekolahController::class);

// contoh halaman setelah login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
