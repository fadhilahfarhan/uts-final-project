<?php

use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// membuat route patients menggunakan method apiResource
Route::apiResource('/patients', PatientController::class);

// Search Resource by name
Route::get('/patients/search/{name}', [PatientController::class, 'search']);

// Search Status Positive Resource
Route::get('/patients/status/positive', [PatientController::class, 'positive']);

// Search Status Recovered Resource
Route::get('/patients/status/recovered', [PatientController::class, 'recovered']);

// Search Status Dead Resource
Route::get('/patients/status/dead', [PatientController::class, 'dead']);
