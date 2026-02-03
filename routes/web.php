<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\PrayerController::class, 'index']);
Route::get('/athkar', [App\Http\Controllers\PrayerController::class, 'athkar']);
Route::get('/quran', [App\Http\Controllers\PrayerController::class, 'quran']);
Route::get('/quran/search', [App\Http\Controllers\PrayerController::class, 'quranSearch']);
Route::get('/quran/{surah}', [App\Http\Controllers\PrayerController::class, 'surah']);
Route::get('/tajweed', [App\Http\Controllers\PrayerController::class, 'tajweed']);
Route::get('/tasbih', [App\Http\Controllers\PrayerController::class, 'tasbih']);
Route::get('/names', [App\Http\Controllers\PrayerController::class, 'names']);
Route::get('/hijri', [App\Http\Controllers\PrayerController::class, 'hijri']);
Route::get('/qibla', [App\Http\Controllers\PrayerController::class, 'qibla']);
Route::get('/settings', [App\Http\Controllers\PrayerController::class, 'settings']);
Route::get('/zakat', [App\Http\Controllers\PrayerController::class, 'zakat']);
Route::get('/calendar', [App\Http\Controllers\PrayerController::class, 'calendar']);
Route::get('/hadith', [App\Http\Controllers\PrayerController::class, 'hadith']);
Route::get('/quiz', [App\Http\Controllers\PrayerController::class, 'quiz']);
Route::get('/mosques', [App\Http\Controllers\PrayerController::class, 'mosques']);
Route::get('/tracker', [App\Http\Controllers\PrayerController::class, 'tracker']);
Route::get('/ramadan', [App\Http\Controllers\PrayerController::class, 'ramadan']);
