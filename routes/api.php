<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\DoctorController;
use App\Http\Controllers\Api\V1\LeaveController;
use App\Http\Controllers\Api\V1\ScheduleController;
use App\Http\Controllers\Api\V1\PatientController;
use App\Http\Controllers\Api\V1\HospitalController;
use App\Http\Controllers\Api\V1\AppointmentController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function () {
    Route::apiResource('hospitals', HospitalController::class);
    Route::apiResource('doctors', DoctorController::class);
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('appointments', AppointmentController::class);
    Route::post('schedules', [ScheduleController::class, 'store']);
    Route::post('leaves', [LeaveController::class, 'store']);
    Route::post('appointments/check-availability', [AppointmentController::class, 'availability']);
});

Route::get('/check', function () {
    return response()->json(['status' => 'api is working']);
});
Route::get('doctors/expertise/{type}', [DoctorController::class, 'filterByExpertise']);
