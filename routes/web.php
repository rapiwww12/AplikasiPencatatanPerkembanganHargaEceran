<?php

use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [BahanBakuController::class, 'dashboard'])->name('dashboard');

    route::resource('permission', PermissionController::class);
    route::resource('role', RoleController::class);
    route::resource('user', UserController::class);
    route::resource('items', BahanBakuController::class);
    route::get('items/{id}/harga', [BahanBakuController::class, 'createHarga']);
    route::post('items/{id}/harga/store', [BahanBakuController::class, 'storeHarga']);
    route::get('items/harga/{hargaId}/edit', [BahanBakuController::class, 'editHarga']);
    route::put('items/harga/{hargaId}/update', [BahanBakuController::class, 'updateHarga']);
    route::get('items/{id}/show', [BahanBakuController::class, 'showHarga']);
    route::get('laporan', [LaporanController::class, 'index']);
    route::post('laporan/generate', [LaporanController::class, 'store']);
    route::get('laporan/download/{id}', [LaporanController::class, 'downloadLaporan']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
