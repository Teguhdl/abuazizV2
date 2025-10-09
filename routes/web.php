<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, AkunController, SekolahController, SiswaController, KelasController, PotonganBiayaController , RincianBiayaController , TransaksiPendaftaranController ,  TransaksiDaftarUlangController , PendapatanController , PembayaranBebanController, JurnalUmumController , BukuBesarController};



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

Route::get('/', [AuthController::class, 'showLogin'])->name('login');

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
Route::get('/transaksi_pendaftaran/{id}/bayar', [TransaksiPendaftaranController::class, 'bayar'])->name('transaksi_pendaftaran.bayar');
Route::post('/transaksi_pendaftaran/{id}/bayar', [TransaksiPendaftaranController::class, 'bayarStore'])->name('transaksi_pendaftaran.bayar.store');

Route::resource('transaksi_daftar_ulang', TransaksiDaftarUlangController::class)->middleware('auth');
Route::get('/transaksi_daftar_ulang/{id}/bayar', [TransaksiDaftarUlangController::class, 'bayar'])->name('transaksi_daftar_ulang.bayar');
Route::post('/transaksi_daftar_ulang/{id}/bayar', [TransaksiDaftarUlangController::class, 'bayarStore'])->name('transaksi_daftar_ulang.bayar.store');


Route::resource('pendapatan', PendapatanController::class)->middleware('auth');
Route::resource('pembayaran_beban', PembayaranBebanController::class)->middleware('auth');
Route::get('jurnal', [JurnalUmumController::class, 'index'])->middleware('auth')->name('jurnal');
Route::get('buku_besar', [BukuBesarController::class, 'index'])->middleware('auth')->name('buku_besar');

// contoh halaman setelah login
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
