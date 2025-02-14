<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TemplateJabatanController;
use App\Http\Controllers\UraianJabatanController;

Route::post('/login-dirjab', [LoginController::class, 'login'])->name('login.dirjab');

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
    Route::post('filter-uraian_jabatan/', [UraianJabatanController::class, 'filterData'])->name('uraian_jabatan.filter');
    // template jabatan
    Route::resource('template-jabatan', TemplateJabatanController::class);
    Route::get('template-jabatan/{encoded_name}/{unit_kd?}', [TemplateJabatanController::class, 'show'])->name('template_jabatan.show');
    Route::get('filter-template-jabatan/', [TemplateJabatanController::class, 'filterData'])->name('template_jabatan.filter');    
    Route::get('template-jabatan/draft/{id}', [TemplateJabatanController::class, 'draft'])->name('template_jabatan.draft');
    // import data
    Route::prefix('import')->group(function () {
        Route::post('template-jabatan', [ImportController::class, 'import'])->name('import.templateJabatan');
        Route::post('kompetensi-teknis', [ImportController::class, 'masterKompetensiTeknis'])->name('import.kompetensi_teknis');
        Route::post('kompetensi-non-teknis', [ImportController::class, 'masterKompetensiNonTeknis'])->name('import.kompetensi_non_teknis');
        Route::post('mapping-kompetensi-non-teknis', [ImportController::class, 'mappingKompetensiNonTeknis'])->name('import.mapping_kompetensi_non_teknis');
        Route::post('mapping-kompetensi-teknis', [ImportController::class, 'mappingKeterampilanTeknis'])->name('import.mapping_kompetensi_teknis');
        Route::post('default-data', [ImportController::class, 'masterDefaultData'])->name('import.default_data');
    });
    Route::prefix('export')->group(function () {
        Route::get('kompetensi-non-teknis', [ExportController::class, 'exportMasterKompetensiNonTeknis'])->name('export.kompetensi_non_teknis');
        Route::get('kompetensi-teknis', [ExportController::class, 'exportMasterKompetensiTeknis'])->name('export.kompetensi_teknis');
        Route::get('mapping-kompetensi-non-teknis', [ExportController::class, 'exportMappingKompetensiNonTeknis'])->name('export.mapping_kompetensi_non_teknis');
        Route::get('mapping-kompetensi-teknis', [ExportController::class, 'exportMappingKompetensiTeknis'])->name('export.mapping_kompetensi_teknis');
        Route::get('jabatan-unit', [ExportController::class, 'exportMasterJabatanUnit'])->name('export.jabatan_unit');
        Route::get('default-data', [ExportController::class, 'exportMasterDefaultData'])->name('export.default_data');
        Route::get('uraian-jabatan-PDF/{id}', [ExportController::class, 'exportUraianJabatanPdf'])->name('export.uraian_jabatan_PDF');
        Route::get('uraian-jabatan-Excel/{id}', [ExportController::class, 'exportUraianJabatanExcel'])->name('export.uraian_jabatan_Excel');
        Route::get('template-jabatan-Excel/{encoded_name}/{unit_kd?}', [ExportController::class, 'exportExcelTemplateJabatan'])->name('export.template_jabatan_Excel');    
        Route::get('template-jabatan-PDF/{encoded_name}/{unit_kd?}', [ExportController::class, 'exportTemplateJabatanPdf'])->name('export.template_jabatan_PDF');
    });
    // Master Data Routes
    Route::prefix('master_data')->group(function () {
        Route::get('indikator', [MasterDataController::class, 'indikator'])->name('master.indikator');
        Route::post('indikator/create', [MasterDataController::class, 'storeIndikator'])->name('master.indikator.store');
        Route::post('indikator/edit', [MasterDataController::class, 'updateIndikator'])->name('master.indikator.update');
        Route::post('indikator/delete', [MasterDataController::class, 'deleteIndikator'])->name('master.indikator.delete');
        Route::get('pendidikan', [MasterDataController::class, 'pendidikan'])->name('master.pendidikan');
        Route::post('pendidikan/create', [MasterDataController::class, 'createPendidikan'])->name('master.pendidikan.create');
        Route::post('pendidikan/update', [MasterDataController::class, 'updatePendidikan'])->name('master.pendidikan.update');
        Route::post('pendidikan/delete', [MasterDataController::class, 'deletePendidikan'])->name('master.pendidikan.delete');
        Route::get('tugas-pokok-generik', [MasterDataController::class, 'tugasPokokGenerik'])->name('master.tugas_pokok_generik.index');
        Route::post('tugas-pokok-generik/store', [MasterDataController::class, 'TugasPokokGenerikStore'])->name('master.tugas_pokok_generik.store');
        Route::post('tugas-pokok-generik/update', [MasterDataController::class, 'TugasPokokGenerikUpdate'])->name('master.tugas_pokok_generik.update');
        Route::post('tugas-pokok-generik/delete', [MasterDataController::class, 'TugasPokokGenerikDestroy'])->name('master.tugas_pokok_generik.delete');
        Route::get('default-master-data', [MasterDataController::class, 'defaultMasterData'])->name('master.defaultData');
        Route::get('kompetensi-teknis', [MasterDataController::class, 'masterKompetensiTeknis'])->name('master.kompetensi-teknis');
        Route::get('kompetensi-teknis/{id}', [MasterDataController::class, 'detailMasterKompetensiTeknis'])->name('master.kompetensi-detail-teknis');
        Route::get('mapping-komptensi-non-teknis', [MasterDataController::class, 'mappingkomptensiNonTeknis'])->name('master.mapping-komptensi-non-teknis');
        Route::get('mapping-komptensi-teknis', [MasterDataController::class, 'mappingkomptensiTeknis'])->name('master.mapping-komptensi-teknis');
        Route::get('kompetensi-non-teknis', [MasterDataController::class, 'masterKompetensiNonTeknis'])->name('master.kompetensi-non-teknis');
        Route::get('jabatan', [MasterDataController::class, 'masterJabatan'])->name('master.jabatan');
        Route::get('jenjang-jabatan', [MasterDataController::class, 'jenjangJabatan'])->name('master.jenjang-jabatan');
        Route::get('unit', [MasterDataController::class, 'unit'])->name('master.unit');
        Route::get('users', [UserController::class, 'index'])->name('users.index');
    });
    // User Management Routes
    Route::post('users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
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
