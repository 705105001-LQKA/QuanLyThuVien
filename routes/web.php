<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SachController;
use App\Http\Controllers\DocGiaController;
use App\Http\Controllers\PhieuController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\PageController;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [PageController::class, 'index'])->name('index');

Route::get('/quan-ly-doc-gia', [DocGiaController::class, 'quanLyDocGia'])->name('quanLyDocGia');
Route::post('/them-doc-gia', [DocGiaController::class, 'store'])->name('docgia.store');
Route::delete('/docgia/{id}', [DocGiaController::class, 'destroy'])->name('docgia.destroy');
Route::get('/docgia/search', [DocGiaController::class, 'search'])->name('docgia.search');
Route::get('/docgia/{id}', [DocGiaController::class, 'show'])->name('docgia.show');
Route::put('/docgia/{id}', [DocGiaController::class, 'update'])->name('docgia.update');

Route::get('/quan-ly-kho-sach', [SachController::class, 'quanLyKhoSach'])->name('quanLyKhoSach');
Route::post('/them-sach', [SachController::class, 'store'])->name('sach.store');
Route::delete('/sach/{id}', [SachController::class, 'destroy'])->name('sach.destroy');
Route::get('/sach/search', [SachController::class, 'search'])->name('sach.search');
Route::get('/sach/{id}', [SachController::class, 'show']);
Route::put('/sach/{id}', [SachController::class, 'update']);

Route::get('/quan-ly-phieu', [PhieuController::class, 'quanLyPhieu'])->name('quanLyPhieu');
Route::post('/tao-phieu', [PhieuController::class, 'store'])->name('phieu.store');
Route::get('/in/{id}', [PhieuController::class, 'inPhieu'])->name('phieu.in');
Route::post('/quan-ly-phieu/{id}/tra-sach', [PhieuController::class, 'traSach'])->name('phieu.tra-sach');
Route::get('/quan-ly-phieu/sach/search', [PhieuController::class, 'search'])->name('phieu.search');
Route::get('/hoa-don', [PhieuController::class, 'showHoaDon'])->name('hoa-don');

Route::get('/lich-su-muon-sach', [PageController::class, 'lichSuMuonSach'])->name('lichSuMuonSach');

Route::get('/thong-ke', [ThongKeController::class, 'thongKe'])->name('thongKe');


require __DIR__.'/auth.php';