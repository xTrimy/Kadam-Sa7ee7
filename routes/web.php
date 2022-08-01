<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientFieldResearchController;
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
        Route::get('/create', [PatientController::class, 'create'])->name('.create');
        Route::post('/store', [PatientController::class, 'store'])->name('.store');
        Route::get('/{id}/edit', [PatientController::class, 'edit'])->name('.edit');
        Route::put('/{id}/update', [PatientController::class, 'update'])->name('.update');
        Route::delete('/{id}/delete', [PatientController::class, 'delete'])->name('.delete');
        Route::prefix('/{id}/field_research')->as('.field_research')->group(function(){
            Route::get('/', [PatientFieldResearchController::class, 'create'])->name('.create');
            Route::post('/', [PatientFieldResearchController::class, 'store'])->name('.create');
        });
    });
});
