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
// Search by name
Route::get('/patients/search/{name}', [PatientController::class, 'search']);
