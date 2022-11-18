<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

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


# membuat Routes untuk Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

# membuat route patients menggunakan method apiResource
# sudah mencakup function store, index, show, update, destroy
# menambahkan ->middleware('auth:sanctum') untuk protected routes
# dengan menambahkan middleware harus melakukan autentikasi terlebih dahulu
Route::apiResource('/patients', PatientController::class)->middleware('auth:sanctum');

# karena apiResource tidak mencakup hal lain dari yang diatas
# maka membuat route dengan manual
# Search Resource by name
Route::get('/patients/search/{name}', [PatientController::class, 'search'])->middleware('auth:sanctum');

# Search Status Positive Resource
Route::get('/patients/status/positive', [PatientController::class, 'positive'])->middleware('auth:sanctum');

# Search Status Recovered Resource
Route::get('/patients/status/recovered', [PatientController::class, 'recovered'])->middleware('auth:sanctum');

# Search Status Dead Resource
Route::get('/patients/status/dead', [PatientController::class, 'dead'])->middleware('auth:sanctum');
