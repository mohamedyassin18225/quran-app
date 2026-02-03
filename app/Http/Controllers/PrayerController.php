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

            // Use City param if available, otherwise try timezone, otherwise generic
            $cityParam = $request->query('city') ?? $request->cookie('city_name');
            $locationLabel = "موقعي الحالي";

            if ($cityParam) {
                $locationLabel = $cityParam;
            } elseif ($response->successful()) {
                $json = $response->json();
                if (isset($json['data']['meta']['timezone'])) {
                    $timezone = $json['data']['meta']['timezone'];
                    $parts = explode('/', $timezone);
                    $locationLabel = str_replace('_', ' ', end($parts));
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

            // Store lat/lng/city in cookie if passed via query to persist it
            if ($request->query('lat') && $request->query('lng')) {
                // Laravel cookies (queued for response)
                cookie()->queue(cookie()->forever('lat', $lat));
                cookie()->queue(cookie()->forever('lng', $lng));

                if ($request->query('city')) {
                    cookie()->queue(cookie()->forever('city_name', $request->query('city')));
                }
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

    public function quranSearch()
    {
        return view('quran.search');
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

    public function zakat()
    {
        return view('zakat');
    }

    public function calendar()
    {
        // Simple manual list of key Islamic dates (Hijri)
        // 1 Muharram: Islamic New Year
        // 10 Muharram: Ashura
        // 12 Rabi Al-Awwal: Mawlid
        // 27 Rajab: Isra Wal Miraj
        // 15 Shaban: Mid-Shaban
        // 1 Ramadan: Start of Fasting
        // 1 Shawwal: Eid Al-Fitr
        // 9 Dhul Hijjah: Arafat
        // 10 Dhul Hijjah: Eid Al-Adha

        $events = [
            ['month' => 1, 'day' => 1, 'name' => 'رأس السنة الهجرية'],
            ['month' => 1, 'day' => 10, 'name' => 'يوم عاشوراء'],
            ['month' => 3, 'day' => 12, 'name' => 'المولد النبوي الشريف'],
            ['month' => 7, 'day' => 27, 'name' => 'الإسراء والمعراج'],
            ['month' => 8, 'day' => 15, 'name' => 'ليلة النصف من شعبان'],
            ['month' => 9, 'day' => 1, 'name' => 'بداية شهر رمضان'],
            ['month' => 10, 'day' => 1, 'name' => 'عيد الفطر المبارك'],
            ['month' => 12, 'day' => 9, 'name' => 'يوم عرفة'],
            ['month' => 12, 'day' => 10, 'name' => 'عيد الأضحى المبارك'],
        ];

        // Get current Hijri date to show "Next Event"
        // We rely on client-side or simple API fetch in view for current date, 
        // or just render the static list for now.

        return view('calendar', ['events' => $events]);
    }

    public function hadith()
    {
        return view('hadith');
    }

    public function quiz()
    {
        return view('quiz');
    }

    public function ramadan()
    {
        return view('ramadan');
    }

    public function mosques()
    {
        return view('mosques');
    }

    public function tracker()
    {
        return view('tracker');
    }

    public function khatma()
    {
        return view('quran.khatma');
    }
}
