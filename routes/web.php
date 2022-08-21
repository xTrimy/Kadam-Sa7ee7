<?php

use App\Http\Controllers\HospitalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientFieldResearchController;
use App\Http\Controllers\PatientRecordController;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\SupplyCategoriesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('website.home');
});



require __DIR__.'/auth.php';

Route::middleware('auth')->prefix('/dashboard')->as('dashboard')->group(function(){
    Route::get('/',  [DashboardController::class, 'index']);
    Route::prefix('/patients')->as('.patients')->group(function(){
        Route::middleware('permission:View patient')->get('/', [PatientController::class, 'index']);
        Route::middleware('permission:View patient')->get('/view/{id}', [PatientController::class, 'view_single'])->name('view_single');
        Route::middleware('permission:View patient')->get('/download/{id}', [PatientController::class, 'download_patient_data'])->name('download_data_pdf');
        Route::middleware('permission:View patient')->get('/download_t/{id}', [PatientController::class, 'download_patient_data_t'])->name('download_data_pdf_t');
        Route::get('/search', [PatientController::class, 'search'])->name('.search');
        Route::middleware('permission:Add patient')->get('/add', [PatientController::class, 'add_national_id'])->name('.create');
        Route::middleware('permission:Add patient')->post('/add', [PatientController::class, 'check_national_id'])->name('.search_id');
        Route::middleware('permission:Add patient')->get('/create', [PatientController::class, 'create'])->name('.create_new');
        Route::middleware('permission:Add patient')->post('/create', [PatientController::class, 'store'])->name('.store');
        Route::middleware('permission:Edit patient')->get('/{id}/edit', [PatientController::class, 'edit'])->name('.edit');
        Route::middleware('permission:Edit patient')->put('/{id}/edit', [PatientController::class, 'update'])->name('.update');
        Route::middleware('permission:Delete patient')->delete('/{id}/delete', [PatientController::class, 'delete'])->name('.delete');
        Route::middleware('permission:Add field research')->prefix('/{id}/field_research')->as('.field_research')->group(function(){
            Route::get('/', [PatientFieldResearchController::class, 'create'])->name('.create');
            Route::post('/', [PatientFieldResearchController::class, 'store'])->name('.create');
        });
        Route::prefix('/{id}/record')->as('.record')->group(function () {
            Route::middleware('permission:Add patient report')->get('/', [PatientRecordController::class, 'create'])->name('.create');
            Route::middleware('permission:Add patient report')->post('/', [PatientRecordController::class, 'store'])->name('.create');
            Route::middleware('permission:Edit patient report')->get('/{record_id}/edit', [PatientRecordController::class, 'edit'])->name('.edit');
            Route::middleware('permission:Edit patient report')->put('/{record_id}/edit', [PatientRecordController::class, 'update']);
        });
    });
    Route::prefix('/hospitals')->as('.hospitals')->group(function(){
        Route::middleware('permission:View hospital')->get('/', [HospitalController::class, 'index']);
        Route::middleware('permission:Add hospital')->get('/create', [HospitalController::class, 'create'])->name('.create');
        Route::middleware('permission:Add hospital')->post('/create', [HospitalController::class, 'store'])->name('.store');
        Route::middleware('permission:Edit hospital')->get('/{id}/edit', [HospitalController::class, 'edit'])->name('.edit');
        Route::middleware('permission:Edit hospital')->put('/{id}/edit', [HospitalController::class, 'update'])->name('.update');
        Route::middleware('permission:Delete hospital')->delete('/{id}/delete', [HospitalController::class, 'delete'])->name('.delete');
    });

    Route::middleware('permission:Add supplies')->prefix('/supplies')->as('.supplies')->group(function () {
        Route::prefix('/categories')->as('.categories')->group(function () {
            Route::get('/create', [SupplyCategoriesController::class, 'create'])->name('.create');
            Route::post('/create', [SupplyCategoriesController::class, 'store'])->name('.store');
            Route::delete('/{id}/delete', [SupplyCategoriesController::class, 'delete'])->name('.delete');
        });
        Route::get('/', [SuppliesController::class, 'index']);
        Route::post('/', [SuppliesController::class, 'edit_quantity']);
        Route::get('/create', [SuppliesController::class, 'create'])->name('.create');
        Route::post('/create', [SuppliesController::class, 'store'])->name('.store');
        Route::get('/{id}/edit', [SuppliesController::class, 'edit'])->name('.edit');
        Route::put('/{id}/update', [SuppliesController::class, 'update'])->name('.update');
        Route::delete('/{id}/delete', [SuppliesController::class, 'delete'])->name('.delete');
        Route::get('/transfer/{type}/{id?}', [SuppliesController::class, 'transfer'])->name('.transfer');
        Route::post('/transfer/{type?}/{id?}', [SuppliesController::class, 'transfer_store'])->name('.transfer');
    });

    Route::prefix('/users')->as('.users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::middleware('permission:Add user')->get('/create', [UserController::class, 'create'])->name('.create');
        Route::middleware('permission:Add user')->post('/create', [UserController::class, 'store'])->name('.store');
        Route::middleware('permission:Add user')->get('/{id}/edit', [UserController::class, 'edit'])->name('.edit');
        Route::middleware('permission:Add user')->put('/{id}/edit', [UserController::class, 'update'])->name('.edit');
        Route::middleware('permission:Delete users')->delete('/{id}/delete', [UserController::class, 'delete'])->name('.delete');
    });

    Route::prefix('/doctors')->as('.doctors')->group(function(){
        Route::get('/', [DoctorController::class, 'index']);
        Route::middleware('permission:Add doctor')->get('/create', [DoctorController::class, 'create'])->name('.create');
        Route::middleware('permission:Add doctor')->post('/create', [DoctorController::class, 'store'])->name('.store');
        Route::middleware('permission:Edit doctor')->get('/{id}/edit', [DoctorController::class, 'edit'])->name('.edit');
        Route::middleware('permission:Edit doctor')->put('/{id}/edit', [DoctorController::class, 'update'])->name('.update');
        Route::middleware('permission:Delete doctor')->delete('/{id}/delete', [DoctorController::class, 'delete'])->name('.delete');
    });

    Route::prefix('/nurses')->as('.nurses')->group(function () {
        Route::get('/', [NurseController::class, 'index']);
        Route::middleware('permission:Add nurse')->get('/create', [NurseController::class, 'create'])->name('.create');
        Route::middleware('permission:Add nurse')->post('/create', [NurseController::class, 'store'])->name('.store');
        Route::middleware('permission:Edit nurse')->get('/{id}/edit', [NurseController::class, 'edit'])->name('.edit');
        Route::middleware('permission:Edit nurse')->put('/{id}/edit', [NurseController::class, 'update'])->name('.update');
        Route::middleware('permission:Delete nurse')->delete('/{id}/delete', [NurseController::class, 'delete'])->name('.delete');
    });

    
});
