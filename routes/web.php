<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, AkunController, SekolahController, SiswaController, KelasController, PotonganBiayaController , RincianBiayaController , TransaksiPendaftaranController ,  TransaksiDaftarUlangController};



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


Route::resource('akun', AkunController::class)->middleware('auth');
Route::resource('kelas', KelasController::class)->parameters([
    'kelas' => 'kelas' 
])->middleware('auth');

Route::resource('siswa', SiswaController::class)->middleware('auth');
Route::resource('sekolah', SekolahController::class)->middleware('auth');
Route::resource('rincian_biaya', RincianBiayaController::class)->parameters([
    'rincian_biaya' => 'rincian_biaya'
])->middleware('auth');

Route::resource('potongan_biaya', PotonganBiayaController::class)->parameters([
    'potongan_biaya' => 'potongan_biaya'
])->middleware('auth');
Route::resource('transaksi_pendaftaran', TransaksiPendaftaranController::class)->middleware('auth');
Route::resource('transaksi_daftar_ulang', TransaksiDaftarUlangController::class)->middleware('auth');

// contoh halaman setelah login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
