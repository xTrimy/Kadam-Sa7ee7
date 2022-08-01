<?php

use App\Http\Controllers\API\ChronicDiseaseController;
use App\Http\Controllers\API\GovernorateController;
use App\Http\Controllers\API\HospitalController;
use App\Http\Controllers\API\PatientRecordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/patients',[PatientController::class,'view_api']);
    Route::post('/patient',[PatientController::class,'add_api']);
    Route::delete('/patient/{id}',[PatientController::class,'delete_api']);
    Route::put('/patient/{id}',[PatientController::class,'edit_api']);
    Route::get('/patient/{id}',[PatientController::class,'view_single_api']);

    // Patient Records
    Route::get('/patient/{id}/records',[PatientController::class, 'get_records_api']);
    Route::post('/patient/record',[PatientRecordController::class, 'add']);
    Route::delete('/patient/record/{id}',[PatientRecordController::class, 'delete']);

    //Governorate routes
    Route::get('/governorates',[GovernorateController::class,'all']);
    Route::get('/governorate/{id}',[GovernorateController::class,'get']);
    Route::post('/governorate',[GovernorateController::class,'add']);
    Route::put('/governorate/{id}',[GovernorateController::class,'edit']);
    Route::delete('/governorate/{id}',[GovernorateController::class,'delete']);

    //Hospital routes
    Route::get('/hospitals',[HospitalController::class,'all']);
    Route::get('/hospital/{id}',[HospitalController::class,'get']);
    Route::post('/hospital',[HospitalController::class,'add']);
    Route::put('/hospital/{id}',[HospitalController::class,'edit']);
    Route::delete('/hospital/{id}',[HospitalController::class,'delete']);

    //Chronic Disease routes
    Route::get('/diseases',[ChronicDiseaseController::class,'all']);
    Route::get('/disease/{id}',[ChronicDiseaseController::class,'get']);
    Route::post('/disease',[ChronicDiseaseController::class,'add']);
    Route::put('/disease/{id}',[ChronicDiseaseController::class,'edit']);
    Route::delete('/disease/{id}',[ChronicDiseaseController::class,'delete']);


});


Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);
