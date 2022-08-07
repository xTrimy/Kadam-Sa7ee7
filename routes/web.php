<?php

use App\Http\Controllers\HospitalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientFieldResearchController;
use App\Http\Controllers\PatientRecordController;
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
    return view('welcome');
});



require __DIR__.'/auth.php';

Route::middleware('auth')->prefix('/dashboard')->as('dashboard')->group(function(){
    Route::get('/',  [DashboardController::class, 'index']);
    Route::prefix('/patients')->as('.patients')->group(function(){
        Route::get('/', [PatientController::class, 'index']);
        Route::get('/view/{id}', [PatientController::class, 'view_single'])->name('view_single');
        Route::get('/download/{id}', [PatientController::class, 'download_patient_data'])->name('download_data_pdf');
        Route::get('/download_t/{id}', [PatientController::class, 'download_patient_data_t'])->name('download_data_pdf_t');
        Route::get('/create', [PatientController::class, 'create'])->name('.create');
        Route::get('/search', [PatientController::class, 'search'])->name('.search');
        Route::post('/create', [PatientController::class, 'store'])->name('.store');
        Route::get('/{id}/edit', [PatientController::class, 'edit'])->name('.edit');
        Route::put('/{id}/update', [PatientController::class, 'update'])->name('.update');
        Route::delete('/{id}/delete', [PatientController::class, 'delete'])->name('.delete');
        Route::prefix('/{id}/field_research')->as('.field_research')->group(function(){
            Route::get('/', [PatientFieldResearchController::class, 'create'])->name('.create');
            Route::post('/', [PatientFieldResearchController::class, 'store'])->name('.create');
        });
        Route::prefix('/{id}/record')->as('.record')->group(function () {
            Route::get('/', [PatientRecordController::class, 'create'])->name('.create');
            Route::post('/', [PatientRecordController::class, 'store'])->name('.create');
        });
    });
    Route::prefix('/hospitals')->as('.hospitals')->group(function(){
        Route::get('/', [HospitalController::class, 'index']);
        Route::get('/create', [HospitalController::class, 'create'])->name('.create');
        Route::post('/create', [HospitalController::class, 'store'])->name('.store');
        Route::get('/{id}/edit', [HospitalController::class, 'edit'])->name('.edit');
        Route::put('/{id}/update', [HospitalController::class, 'update'])->name('.update');
        Route::delete('/{id}/delete', [HospitalController::class, 'delete'])->name('.delete');
    });
});
