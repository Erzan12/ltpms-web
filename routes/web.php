<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LivestockController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\VaccinationController;

/*
|--------------------------------------------------------------------------
| Public / Basic Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'));

Auth::routes();

Route::get('/home', [LivestockController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Auth Custom Routes (only if you REALLY need custom controllers)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logoutView'])->name('logout.view');

Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('guest');
Route::post('/forgot-password', [AuthController::class, 'sendEmailPassword'])
    ->middleware('guest')
    ->name('password.forgot');

/*
|--------------------------------------------------------------------------
| LIVESTOCK (RESOURCE ROUTE)
|--------------------------------------------------------------------------
*/

Route::resource('livestocks', LivestockController::class);

/*
|--------------------------------------------------------------------------
| QR CODE
|--------------------------------------------------------------------------
*/

Route::get('/livestock/{livestock}/qr', [QrCodeController::class, 'generate'])
    ->name('livestock.qr');

/*
|--------------------------------------------------------------------------
| MEDICAL RECORDS (SEPARATE RESOURCE)
|--------------------------------------------------------------------------
*/
Route::get('/livestock/{livestock}/medical/create', [MedicalRecordController::class, 'create'])
    ->name('livestock.medical.create');

Route::resource('medicals', MedicalRecordController::class)->except(['create']);

/*
|--------------------------------------------------------------------------
| VACCINATIONS (SEPARATE RESOURCE)
|--------------------------------------------------------------------------
*/
Route::get('/livestock/{livestock}/vaccination/create', [VaccinationController::class, 'create'])
    ->name('livestock.vaccination.create');

Route::resource('vaccinations', VaccinationController::class)->except(['create']);

/*
|--------------------------------------------------------------------------
| CUSTOM LIVESTOCK RELATED ACTIONS
|--------------------------------------------------------------------------
*/

// Deleted records view
Route::get('/livestocks/deleted', [LivestockController::class, 'showdeleted'])
    ->name('livestocks.deleted');

/*
|--------------------------------------------------------------------------
| LIFESTOCK DETAIL PAGES (FIXED STRUCTURE)
|--------------------------------------------------------------------------
| IMPORTANT: NO DUPLICATES OF /livestock/{id}
*/

Route::get('/livestock/{livestock}/medical', [MedicalRecordController::class, 'index'])
    ->name('livestock.medical');

Route::get('/livestock/{livestock}/vaccination', [VaccinationController::class, 'index'])
    ->name('livestock.vaccination');
    