<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\PrayerController::class, 'index']);
Route::get('/athkar', [App\Http\Controllers\PrayerController::class, 'athkar']);
Route::get('/quran', [App\Http\Controllers\PrayerController::class, 'quran']);
Route::get('/quran/{number}', [App\Http\Controllers\PrayerController::class, 'surah']);
Route::get('/tajweed', [App\Http\Controllers\PrayerController::class, 'tajweed']);
