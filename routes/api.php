<?php

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AdminScheduleController;

Route::post('/schedules', [ScheduleController::class, 'store']);
Route::get('/schedules/status', [ScheduleController::class, 'index']);
Route::get('/schedules/accepted', [ScheduleController::class, 'getAcceptedSchedules']);
Route::get('/admin/schedules', [AdminScheduleController::class, 'index']);
Route::post('/admin/schedules/{id}/accept', [AdminScheduleController::class, 'accept']);
Route::post('/admin/schedules/{id}/reject', [AdminScheduleController::class, 'reject']);
