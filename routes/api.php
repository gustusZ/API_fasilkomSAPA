<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\LaporanController;
use App\Models\Member;

Route::get('/kabinet-info', [ProfileController::class, 'index']);


Route::get('/members', [ProfileController::class, 'getMembers']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/laporan', [LaporanController::class, 'store']);
Route::get('/laporan/{trackingId}', [LaporanController::class, 'show']);