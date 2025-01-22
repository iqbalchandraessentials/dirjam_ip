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
    Route::resource('template_jabatan', TemplateJabatanController::class);
    Route::get('template_jabatan/draft/{id}', [TemplateJabatanController::class, 'draft'])->name('template_jabatan.draft');
    Route::get('template_jabatan/export-excel/{id}', [ExportController::class, 'exportExcel'])->name('template_jabatan.export_excel');
    Route::get('template_jabatan/export-pdf/{id}', [TemplateJabatanController::class, 'exportPdf'])->name('template_jabatan.export_pdf');
    // import data
    Route::prefix('import')->group(function () {
        Route::post('templateJabatan', [ImportController::class, 'import'])->name('import.templateJabatan');
        Route::post('masterKompetensiTeknis', [ImportController::class, 'masterKompetensiTeknis'])->name('import.masterKompetensiTeknis');
        Route::post('masterKompetensiNonTeknis', [ImportController::class, 'masterKompetensiNonTeknis'])->name('import.masterKompetensiNonTeknis');
        Route::post('mappingKompetensiNonTeknis', [ImportController::class, 'mappingKompetensiNonTeknis'])->name('import.mappingKompetensiNonTeknis');
        Route::post('mappingKeterampilanTeknis', [ImportController::class, 'mappingKeterampilanTeknis'])->name('import.mappingKeterampilanTeknis');
        Route::post('masterDefaultData', [ImportController::class, 'masterDefaultData'])->name('import.masterDefaultData');
    });
    Route::prefix('export')->group(function () {
        Route::get('masterKompetensiNonTeknis', [ExportController::class, 'exportMasterKompetensiNonTeknis'])->name('export.MasterKompetensiNonTeknis');
        Route::get('masterKompetensiTeknis', [ExportController::class, 'exportMasterKompetensiTeknis'])->name('export.MasterKompetensiTeknis');
        Route::get('MappingKompetensiNonTeknis', [ExportController::class, 'exportMappingKompetensiNonTeknis'])->name('export.MappingKompetensiNonTeknis');
        Route::get('MappingKompetensiTeknis', [ExportController::class, 'exportMappingKompetensiTeknis'])->name('export.MappingKompetensiTeknis');
        Route::get('MasterJabatanUnit', [ExportController::class, 'exportMasterJabatanUnit'])->name('export.MasterJabatanUnit');
        Route::get('MasterDefaultData', [ExportController::class, 'exportMasterDefaultData'])->name('export.MasterDefaultData');
    });

    // Master Data Routes
    Route::prefix('master_data')->group(function () {
        Route::get('indikator', [MasterDataController::class, 'indikator'])->name('master.indikator');
        Route::get('pendidikan', [MasterDataController::class, 'pendidikan'])->name('master.pendidikan');
        Route::post('pendidikan/create', [MasterDataController::class, 'createPendidikan'])->name('master.pendidikan.create');
        Route::post('pendidikan/update', [MasterDataController::class, 'updatePendidikan'])->name('master.pendidikan.update');
        Route::post('pendidikan/delete', [MasterDataController::class, 'deletePendidikan'])->name('master.pendidikan.delete');
        Route::get('tugasPokokGenerik', [MasterDataController::class, 'tugasPokokGenerik'])->name('master.tugasPokokGenerik');
        Route::post('TugasPokokGenerikStore', [MasterDataController::class, 'TugasPokokGenerikStore'])->name('master.TugasPokokGenerikStore');
        Route::post('TugasPokokGenerikUpdate', [MasterDataController::class, 'TugasPokokGenerikUpdate'])->name('master.TugasPokokGenerikUpdate');
        Route::post('TugasPokokGenerikDestroy', [MasterDataController::class, 'TugasPokokGenerikDestroy'])->name('master.TugasPokokGenerikDestroy');
        Route::get('defaultMasterData', [MasterDataController::class, 'defaultMasterData'])->name('master.defaultMasterData');
        Route::get('komptensiTeknis', [MasterDataController::class, 'masterKompetensiTeknis'])->name('master.masterKompetensiTeknis');
        Route::get('komptensiTeknis/{id}', [MasterDataController::class, 'detailMasterKompetensiTeknis'])->name('master.detailMasterKompetensiTeknis');
        Route::get('mappingkomptensiNonTeknis', [MasterDataController::class, 'mappingkomptensiNonTeknis'])->name('master.mappingkomptensiNonTeknis');
        Route::get('mappingkomptensiTeknis', [MasterDataController::class, 'mappingkomptensiTeknis'])->name('master.mappingkomptensiTeknis');
        Route::get('komptensiNonTeknis', [MasterDataController::class, 'masterKompetensiNonTeknis'])->name('master.masterKompetensiNonTeknis');
        Route::get('masterJabatan', [MasterDataController::class, 'masterJabatan'])->name('master.masterJabatan');
        Route::get('jenjangJabatan', [MasterDataController::class, 'jenjangJabatan'])->name('master.jenjangJabatan');
        Route::get('unit', [MasterDataController::class, 'unit'])->name('master.unit');
        Route::get('users', [UserController::class, 'index'])->name('users.index');
    });

    // User Management Routes
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    
    Route::post('users/{user}/assign-permission', [UserController::class, 'assignPermission'])->name('users.assignPermission');
    Route::post('users/{user}/updateRolesPermissions', [UserController::class, 'updateRolesPermissions'])->name('users.updateRolesPermissions');
    Route::resource('roles', RoleController::class);
});

Route::put('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.updatePermissions');
Route::middleware(['auth'])->group(function () {
    Route::resource('permissions', PermissionController::class);
    Route::post('permissions/assign/{user}', [PermissionController::class, 'assignPermission'])->name('permissions.assign');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
