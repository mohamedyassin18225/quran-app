<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\PrayerController::class, 'index']);
Route::get('/athkar', [App\Http\Controllers\PrayerController::class, 'athkar']);
Route::get('/quran', [App\Http\Controllers\PrayerController::class, 'quran']);
Route::get('/quran/{number}', [App\Http\Controllers\PrayerController::class, 'surah']);
Route::get('/tajweed', [App\Http\Controllers\PrayerController::class, 'tajweed']);
Route::get('/tasbih', [App\Http\Controllers\PrayerController::class, 'tasbih']);
Route::get('/names', [App\Http\Controllers\PrayerController::class, 'names']);
Route::get('/hijri', [App\Http\Controllers\PrayerController::class, 'hijri']);
Route::get('/qibla', [App\Http\Controllers\PrayerController::class, 'qibla']);
Route::get('/settings', [App\Http\Controllers\PrayerController::class, 'settings']);
