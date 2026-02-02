<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PrayerController extends Controller
{
    public function index(Request $request)
    {
        // Get method from Cookie or default to 5 (Egyptian)
        $method = $request->cookie('prayer_method', 5);

        // Check for Geolocation (Query Params or Cookie)
        $lat = $request->query('lat') ?? $request->cookie('lat');
        $lng = $request->query('lng') ?? $request->cookie('lng');

        if ($lat && $lng) {
            // Fetch by Coordinates
            $response = Http::get("http://api.aladhan.com/v1/timings", [
                'latitude' => $lat,
                'longitude' => $lng,
                'method' => $method,
            ]);

            // Try to extract city from timezone (e.g. "Africa/Cairo" -> "Cairo")
            $locationLabel = "موقعي الحالي"; // Default
            if ($response->successful()) {
                $json = $response->json();
                if (isset($json['data']['meta']['timezone'])) {
                    $timezone = $json['data']['meta']['timezone'];
                    // Get text after last / and replace _ with space
                    $parts = explode('/', $timezone);
                    $city = end($parts);
                    $locationLabel = str_replace('_', ' ', $city);
                }
            }
        } else {
            // Default location: Cairo, Egypt
            $city = 'Cairo';
            $country = 'Egypt';

            $response = Http::get('http://api.aladhan.com/v1/timingsByCity', [
                'city' => $city,
                'country' => $country,
                'method' => $method,
            ]);
            $locationLabel = "$city, $country";
        }

        $data = $response->json();

        if ($response->successful() && isset($data['data'])) {
            $timings = $data['data']['timings'];
            $date = $data['data']['date'];

            // Store lat/lng in cookie if passed via query to persist it
            if ($request->query('lat') && $request->query('lng')) {
                // Laravel cookies (queued for response)
                cookie()->queue(cookie()->forever('lat', $lat));
                cookie()->queue(cookie()->forever('lng', $lng));
            }

            return view('prayers', [
                'timings' => $timings,
                'date' => $date,
                'location' => $locationLabel
            ]);
        }

        // Fallback or error handling
        return view('prayers', [
            'error' => 'Unable to fetch prayer times. Please try again later.',
            'timings' => null
        ]);
    }

    public function athkar()
    {
        return view('athkar');
    }

    public function quran()
    {
        $response = Http::get('http://api.alquran.cloud/v1/surah');
        $surahs = $response->successful() ? $response->json()['data'] : [];

        return view('quran.index', ['surahs' => $surahs]);
    }

    public function surah($number)
    {
        // Fetch Surah with Arabic text AND Tafsir (Al-Jalalayn)
        // API allows comma-separated editions
        $response = Http::get("http://api.alquran.cloud/v1/surah/$number/editions/quran-uthmani,ar.jalalayn,ar.minshawi");

        if ($response->successful()) {
            $data = $response->json()['data']; // Array of 3 elements
            $surah = $data[0]; // quran-uthmani
            $tafsir = $data[1]; // ar.jalalayn
            $audio = $data[2]; // ar.minshawi

            return view('quran.show', [
                'surah' => $surah,
                'tafsir' => $tafsir,
                'audio' => $audio
            ]);
        }

        return view('quran.show', ['surah' => null, 'tafsir' => null]);
    }

    public function tajweed()
    {
        return view('tajweed');
    }

    public function tasbih()
    {
        return view('tasbih');
    }

    public function names()
    {
        // Fetch 99 Names from Aladhan API
        $response = Http::get('http://api.aladhan.com/v1/asmaAlHusna');
        $names = $response->successful() ? $response->json()['data'] : [];
        return view('names', ['names' => $names]);
    }

    public function hijri(Request $request)
    {
        $date = $request->input('date');
        $conversionResult = null;

        if ($date) {
            // Format date DD-MM-YYYY for API
            $formattedDate = date('d-m-Y', strtotime($date));
            $response = Http::get("http://api.aladhan.com/v1/gToH/$formattedDate");
            if ($response->successful()) {
                $conversionResult = $response->json()['data'];
            }
        }

        return view('hijri', ['conversionResult' => $conversionResult]);
    }

    public function qibla()
    {
        return view('qibla');
    }

    public function settings()
    {
        return view('settings');
    }
}
