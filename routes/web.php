<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // Resource route dengan penamaan manual agar sesuai dengan view kamu
    Route::resource('admin/members', MemberController::class)->names([
        'index'   => 'members.index',
        'create'  => 'members.create',
        'store'   => 'members.store',
        'edit'    => 'members.edit',
        'update'  => 'members.update',
        'destroy' => 'members.destroy',
    ]);
    Route::resource('admin/laporan', LaporanController::class)
        ->names([
            'index'   => 'laporan.index',
            'show'    => 'laporan.show',
            'update'  => 'laporan.update',
            'destroy' => 'laporan.destroy',
        ])
        ->only(['index', 'show', 'update', 'destroy']);

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('admin/laporan-export', [LaporanController::class, 'export'])
        ->name('laporan.export');
});

require __DIR__ . '/auth.php';
