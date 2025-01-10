<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MasterDataController;
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

// Route dengan middleware auth dan verified untuk uraian_jabatan
Route::middleware(['auth'])->group(function () {
    Route::resource('uraian_jabatan', UraianJabatanController::class); 
        // Route untuk export PDF
    Route::get('uraian_jabatan/export-pdf/{id}', [UraianJabatanController::class, 'exportPdf'])
    ->name('uraian_jabatan.export_pdf');
    Route::get('uraian_jabatan/export-excel/{id}', [ExportController::class, 'exportExcel'])
    ->name('uraian_jabatan.export_excel');
});

// Route dengan middleware auth untuk uraian_jabatan_template
Route::middleware(['auth'])->group(function () {
    // Resource route untuk UraianMasterJabatanController
    Route::resource('uraian_jabatan_template', UraianMasterJabatanController::class);

    // Route untuk draft uraian jabatan
    Route::get('uraian_jabatan_template/draft/{id}', [UraianMasterJabatanController::class, 'draft'])
         ->name('uraian_jabatan_template.draft'); 

    // Route untuk export Excel
    Route::get('uraian_jabatan_template/export-excel/{id}', [ExportController::class, 'exportExcel'])
         ->name('uraian_jabatan_template.export_excel');

    // Route untuk export PDF
    Route::get('uraian_jabatan_template/export-pdf/{id}', [UraianMasterJabatanController::class, 'exportPdf'])
         ->name('uraian_jabatan_template.export_pdf');
});



Route::middleware(['auth'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::post('/users/{user}/assign-role', [UserRoleController::class, 'assignRole'])->name('users.assignRole');
});

Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');

Route::middleware(['auth'])->group(function () {
    Route::resource('permissions', PermissionController::class);
    Route::post('permissions/assign/{user}', [PermissionController::class, 'assignPermission'])->name('permissions.assign');
});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/import', [ImportController::class, 'showForm'])->name('import.form');
Route::post('/import', [ImportController::class, 'import'])->name('import.excel');


Route::middleware(['auth'])->group(function () {
    // Master Data Routes
    Route::prefix('master_data')->group(function () {
        Route::get('indikator', [MasterDataController::class, 'indikator'])->name('master.indikator');
        Route::get('pendidikan', [MasterDataController::class, 'pendidikan'])->name('master.pendidikan');
        Route::get('tugasPokokGenerik', [MasterDataController::class, 'tugasPokokGenerik'])->name('master.tugasPokokGenerik');
        Route::get('masalahDanWewenang', [MasterDataController::class, 'masalahDanWewenang'])->name('master.masalahDanWewenang');
        Route::get('komptensiTeknis', [MasterDataController::class, 'masterKompetensiTeknis'])->name('master.masterKompetensiTeknis');
        Route::get('komptensiTeknis/{id}', [MasterDataController::class, 'detailMasterKompetensiTeknis'])->name('master.detailMasterKompetensiTeknis');
        Route::get('komptensiNonTeknis', [MasterDataController::class, 'masterKompetensiNonTeknis'])->name('master.masterKompetensiNonTeknis');
    });

    // User Management Routes
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::post('users/{user}/assign-permission', [UserController::class, 'assignPermission'])->name('users.assignPermission');
    Route::post('users/{user}/updateRolesPermissions', [UserController::class, 'updateRolesPermissions'])->name('users.updateRolesPermissions');
});




require __DIR__.'/auth.php';
