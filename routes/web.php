<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\PermissionController;


Route::get('/', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified']);

Route::get('/home', function () {
    return view('pages.home');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/uraian_jabatan', function () {
    return view('pages.uraian_jabatan');
})->middleware(['auth', 'verified'])->name('uraian_jabatan');

Route::get('/approval_list', function () {
    return view('pages.approval_list');
})->middleware(['auth', 'verified'])->name('approval_list');

Route::get('/uraian_jabatan_template', function () {
    return view('pages.revisi_jobdesc');
})->middleware(['auth', 'verified'])->name('uraian_jabatan_template');

Route::get('/export-excel', [App\Http\Controllers\ExportController::class, 'exportExcel'])->name('export.excel');

Route::get('/export-pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');

Route::middleware(['auth'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::post('/users/{user}/assign-role', [UserRoleController::class, 'assignRole'])->name('users.assignRole');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('permissions', PermissionController::class);
    Route::post('permissions/assign/{user}', [PermissionController::class, 'assignPermission'])->name('permissions.assign');
});



Route::middleware(['auth'])->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::post('users/{user}/assign-permission', [UserController::class, 'assignPermission'])->name('users.assignPermission');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
