<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TemplateJabatanController;
use App\Http\Controllers\UraianJabatanController;

Route::get('/', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified']);


Route::get('/bidang-studi', function () {
    return view('pages.masterData.bidangStudi.index');
})->middleware(['auth', 'verified']);

Route::get('/home', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/approval_list', function () {
    return view('pages.approval_list');
})->middleware(['auth', 'verified'])->name('approval_list');

Route::middleware(['auth'])->group(function () {
    Route::resource('uraian_jabatan', UraianJabatanController::class);
    Route::get('filter-uraian_jabatan/', [UraianJabatanController::class, 'filterData'])->name('filter-jabatan');
    Route::get('uraian_jabatan/export-pdf/{id}', [UraianJabatanController::class, 'exportPdf'])->name('uraian_jabatan.export_pdf');
    Route::get('uraian_jabatan/export-excel/{id}', [ExportController::class, 'exportExcel'])->name('uraian_jabatan.export_excel');
    // template jabatan
    Route::resource('uraian_jabatan_template', TemplateJabatanController::class);
    Route::get('uraian_jabatan_template/draft/{id}', [TemplateJabatanController::class, 'draft'])
        ->name('uraian_jabatan_template.draft');
    Route::get('uraian_jabatan_template/export-excel/{id}', [ExportController::class, 'exportExcel'])
        ->name('uraian_jabatan_template.export_excel');
    Route::get('uraian_jabatan_template/export-pdf/{id}', [TemplateJabatanController::class, 'exportPdf'])
        ->name('uraian_jabatan_template.export_pdf');
    // import data
    Route::prefix('import')->group(function () {
        Route::post('templateJabatan', [ImportController::class, 'import'])->name('import.templateJabatan');
        Route::post('masterKompetensiTeknis', [ImportController::class, 'masterKompetensiTeknis'])->name('import.masterKompetensiTeknis');
        Route::post('mappingKompetensiTeknis', [ImportController::class, 'mappingKompetensiTeknis'])->name('import.mappingKompetensiTeknis');
        Route::post('masterKompetensiNonTeknis', [ImportController::class, 'masterKompetensiNonTeknis'])->name('import.masterKompetensiNonTeknis');
        Route::post('mappingKompetensiNonTeknis', [ImportController::class, 'mappingKompetensiNonTeknis'])->name('import.mappingKompetensiNonTeknis');
    });
    Route::prefix('export')->group(function () {
        Route::get('masterKompetensiNonTeknis', [MasterDataController::class, 'exportMasterKompetensiNonTeknis'])->name('export.exportMasterKompetensiNonTeknis');
        Route::get('masterKompetensiTeknis', [MasterDataController::class, 'exportMasterKompetensiTeknis'])->name('export.exportMasterKompetensiTeknis');
        Route::get('MappingKompetensiNonTeknis', [MasterDataController::class, 'exportMappingKompetensiNonTeknis'])->name('export.exportMappingKompetensiNonTeknis');
        Route::get('MappingKompetensiTeknis', [MasterDataController::class, 'exportMappingKompetensiTeknis'])->name('export.exportMappingKompetensiTeknis');
    });
    
    // Master Data Routes
    Route::prefix('master_data')->group(function () {
        Route::get('indikator', [MasterDataController::class, 'indikator'])->name('master.indikator');
        Route::get('pendidikan', [MasterDataController::class, 'pendidikan'])->name('master.pendidikan');
        Route::get('tugasPokokGenerik', [MasterDataController::class, 'tugasPokokGenerik'])->name('master.tugasPokokGenerik');
        Route::get('masalahDanWewenang', [MasterDataController::class, 'masalahDanWewenang'])->name('master.masalahDanWewenang');
        Route::get('komptensiTeknis', [MasterDataController::class, 'masterKompetensiTeknis'])->name('master.masterKompetensiTeknis');
        Route::get('mappingkomptensiTeknis', [MasterDataController::class, 'mappingkomptensiTeknis'])->name('master.mappingkomptensiTeknis');
        Route::get('komptensiTeknis/{id}', [MasterDataController::class, 'detailMasterKompetensiTeknis'])->name('master.detailMasterKompetensiTeknis');
        Route::get('mappingkomptensiNonTeknis', [MasterDataController::class, 'mappingkomptensiNonTeknis'])->name('master.mappingkomptensiNonTeknis');
        Route::get('komptensiNonTeknis', [MasterDataController::class, 'masterKompetensiNonTeknis'])->name('master.masterKompetensiNonTeknis');
        Route::get('masterJabatan', [MasterDataController::class, 'masterJabatan'])->name('master.masterJabatan');
    });

    // User Management Routes
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::post('users/{user}/assign-permission', [UserController::class, 'assignPermission'])->name('users.assignPermission');
    Route::post('users/{user}/updateRolesPermissions', [UserController::class, 'updateRolesPermissions'])->name('users.updateRolesPermissions');
    Route::resource('roles', RoleController::class);
    Route::post('/users/{user}/assign-role', [UserRoleController::class, 'assignRole'])->name('users.assignRole');
});


Route::middleware(['auth'])->group(function () {
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




require __DIR__ . '/auth.php';
