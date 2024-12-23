<?php

use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UraianJabatanController;
use App\Http\Controllers\UraianMasterJabatanController;

Route::get('/', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified']);


Route::get('/bidang-studi', function () {
    return view('pages.masterData.bidangStudi.index');
})->middleware(['auth', 'verified']);

Route::get('/home', function () {
    return view('pages.home');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/approval_list', function () {
    return view('pages.approval_list');
})->middleware(['auth', 'verified'])->name('approval_list');

Route::get('/uraian_jabatan_template', function () {
    return view('pages.revisi_jobdesc');
})->middleware(['auth', 'verified'])->name('uraian_jabatan_template');

Route::get('/export-excel', [App\Http\Controllers\ExportController::class, 'exportExcel'])->name('export.excel');

Route::get('/export-pdf/{id}', [UraianMasterJabatanController::class, 'exportPdf'])->name('export.pdf');
Route::get('/uraian_master_jabatan_draft/{id}', [UraianMasterJabatanController::class, 'draft'])->name('uraianJabatan.draft');


Route::middleware(['auth'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::post('/users/{user}/assign-role', [UserRoleController::class, 'assignRole'])->name('users.assignRole');
});

Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');

Route::middleware(['auth'])->group(function () {
    Route::resource('permissions', PermissionController::class);
    Route::post('permissions/assign/{user}', [PermissionController::class, 'assignPermission'])->name('permissions.assign');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('uraian_jabatan', UraianMasterJabatanController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::post('users/{user}/assign-permission', [UserController::class, 'assignPermission'])->name('users.assignPermission');
    Route::post('users/{user}/updateRolesPermissions', [UserController::class, 'assignPermission'])->name('users.updateRolesPermissions');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/import', [ImportController::class, 'showForm'])->name('import.form');
Route::post('/import', [ImportController::class, 'import'])->name('import.excel');



Route::get('/master_data/indikator', [ImportController::class, 'showForm'])->name('master.indikator');



require __DIR__.'/auth.php';
