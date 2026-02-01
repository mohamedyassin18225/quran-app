<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $surah['englishName'] ?? 'Surah' }} | Holy Quran</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #1e293b;
            --secondary: #334155;
            --accent: #10b981;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --card-bg: rgba(30, 41, 59, 0.7);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            color: var(--text-light);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 30px;
        }

        .back-btn {
            position: absolute;
            left: 0;
            top: 20px;
            color: var(--text-dim);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .back-btn:hover {
            color: var(--accent);
        }

        h1 {
            margin: 10px 0 5px 0;
            font-size: 2.5rem;
            font-weight: 600;
        }

        .translation {
            color: var(--text-dim);
            font-size: 1.1rem;
        }

        .bismillah {
            text-align: center;
            font-family: 'Amiri', serif;
            font-size: 2.2rem;
            margin: 30px 0 50px 0;
            color: #fbbf24;
        }

        .ayah-container {
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 20px;
        }

        .quran-text {
            direction: rtl;
            font-family: 'Amiri', serif;
            font-size: 2.2rem;
            line-height: 2.5;
            text-align: justify;
            color: #e2e8f0;
            margin-bottom: 10px;
        }

        .tafsir-text {
            direction: rtl;
            font-family: 'Amiri', serif;
            font-size: 1.1rem;
            color: var(--text-dim);
            text-align: justify;
            background: rgba(0, 0, 0, 0.2);
            padding: 15px;
            border-radius: 10px;
            margin-top: 15px;
            border-right: 3px solid var(--accent);
            display: none;
            /* Hidden by default */
        }

        .ayah-number {
            display: inline-block;
            font-size: 1.2rem;
            color: var(--accent);
            border: 1px solid var(--accent);
            border-radius: 50%;
            width: 35px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            margin: 0 5px;
            font-family: 'Outfit', sans-serif;
        }

        .surah-info {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
            font-size: 0.9rem;
            color: var(--accent);
        }

        .controls {
            margin-top: 20px;
        }

        .btn-toggle {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: var(--text-light);
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .btn-toggle:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .btn-toggle.active {
            background: rgba(16, 185, 129, 0.2);
            border-color: var(--accent);
            color: var(--accent);
        }
    </style>
</head>

<body>

    <div class="container">
        @if(!$surah)
            <div style="text-align:center; padding: 50px;">
                <h2>Surah not found or API error.</h2>
                <a href="/quran" class="back-btn" style="position:static; justify-content:center; margin-top:20px;">Back to
                    List</a>
            </div>
        @else
            <div class="header">
                <a href="/quran" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Back to List
                </a>
                <h1>{{ $surah['englishName'] }}</h1>
                <div class="translation">{{ $surah['englishNameTranslation'] }} - {{ $surah['name'] }}</div>
                <div class="surah-info">
                    <span>{{ $surah['numberOfAyahs'] }} Ayahs</span>
                    <span>•</span>
                    <span>{{ $surah['revelationType'] }}</span>
                </div>
                <div class="controls">
                    <button class="btn-toggle" onclick="toggleTafsir(this)">
                        👁️ Show Tafsir (Jalalayn)
                    </button>
                </div>
            </div>

            <!-- Bismillah (skip for Surah 9 At-Tawbah) -->
            @if($surah['number'] != 9)
                <div class="bismillah">بِسْمِ ٱللَّهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ</div>
            @endif

            <div class="quran-content">
                @foreach($surah['ayahs'] as $index => $ayah)
                    <!-- Filter Bismillah from start of ayah text if API includes it (commonly done for first ayah) except Fatiha -->
                    @php
                        $text = $ayah['text'];
                        if ($surah['number'] != 1 && $ayah['numberInSurah'] == 1) {
                            // Regex to match Bismillah with variable diacritics including small alifs and shaddas
                            // \p{M} matches marks (diacritics). We allow optional spaces \s*
                            // Matching simplified: start with Ba, Sin, Mim... with arbitrary marks in between
                            $text = preg_replace('/^[\x{0600}-\x{06FF}\s]{0,50}ٱلرَّحِيمِ\s?/u', '', $text);
                        }
                    @endphp

                    <div class="ayah-container">
                        <div class="quran-text">
                            {{ $text }} <span class="ayah-number">{{ $ayah['numberInSurah'] }}</span>
                        </div>

                        @if(isset($audio['ayahs'][$index]))
                            <div class="audio-container">
                                <audio controls preload="none" style="width: 100%; height: 30px; margin-top: 10px; opacity: 0.8;">
                                    <source src="{{ $audio['ayahs'][$index]['audio'] }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        @endif

                        @if(isset($tafsir['ayahs'][$index]))
                            <div class="tafsir-text">
                                <strong>تفسير:</strong> {{ $tafsir['ayahs'][$index]['text'] }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        function toggleTafsir(btn) {
            const tafsirs = document.querySelectorAll('.tafsir-text');
            const isActive = btn.classList.contains('active');

            if (isActive) {
                // Hide
                tafsirs.forEach(el => el.style.display = 'none');
                btn.classList.remove('active');
                btn.innerHTML = '👁️ Show Tafsir (Jalalayn)';
            } else {
                // Show
                tafsirs.forEach(el => el.style.display = 'block');
                btn.classList.add('active');
                btn.innerHTML = '👁️ Hide Tafsir';
            }
        }
    </script>
</body>

</html>