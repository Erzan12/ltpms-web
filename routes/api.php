<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\VaccinationController;
use App\Http\Controllers\LivestockController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('api-login', [AuthController::class, 'apiLogin']);
Route::post('livestock', [LivestockController::class, 'getLivestocks']);
Route::post('livestock-info', [LivestockController::class, 'getLivestockByQrCode']);
Route::get('medical-records/{id}', [MedicalRecordController::class, 'records']);
Route::get('vaccination-records/{id}', [VaccinationController::class, 'records']);
//medical and vaccination api
Route::post('add-medical-record', [MedicalRecordController::class, 'apiStore']);
Route::put('update-medical-record/{id}', [MedicalRecordController::class, 'apiUpdate']);
Route::post('add-vaccination-record', [VaccinationController::class, 'apiStore']);
Route::put('update-vaccination-record/{id}', [VaccinationController::class, 'apiUpdate']);

