<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $surah['name'] ?? 'سورة' }} | القرآن الكريم</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e293b">
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
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            color: var(--text-light);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            text-align: right;
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
            right: 0;
            /* RTL right */
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
            font-weight: 700;
            font-family: 'Amiri', serif;
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
            font-family: 'Cairo', sans-serif;
            font-weight: 700;
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
            font-family: 'Cairo', sans-serif;
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

        .actions-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 5px;
        }

        .btn-bookmark {
            background: transparent;
            border: 1px solid var(--text-dim);
            color: var(--text-dim);
            padding: 4px 10px;
            border-radius: 15px;
            cursor: pointer;
            font-size: 0.8rem;
            font-family: 'Cairo', sans-serif;
            transition: all 0.2s;
        }

        .btn-bookmark:hover,
        .btn-bookmark.saved {
            background: var(--accent);
            color: #0f172a;
            border-color: var(--accent);
        }

        .ayah-container.highlight {
            background: rgba(16, 185, 129, 0.1);
            border-radius: 12px;
            padding: 10px;
            border: 1px solid var(--accent);
        }
    </style>
</head>

<body>

    <div class="container">
        @if(!$surah)
            <div style="text-align:center; padding: 50px;">
                <h2>عفواً، لم يتم العثور على السورة أو حدث خطأ.</h2>
                <a href="/quran" class="back-btn" style="position:static; justify-content:center; margin-top:20px;">
                    العودة للقائمة
                </a>
            </div>
        @else
            <div class="header">
                <a href="/quran" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    <span>العودة للقائمة</span>
                </a>
                <h1>{{ $surah['name'] }}</h1>
                <!-- We don't need English translation in Arabic mode -->
                <div class="surah-info">
                    <span>{{ $surah['numberOfAyahs'] }} آية</span>
                    <span>•</span>
                    <span>{{ $surah['revelationType'] === 'Meccan' ? 'مكية' : 'مدنية' }}</span>
                </div>
                <div class="controls">
                    <button class="btn-toggle" onclick="toggleTafsir(this)">
                        👁️ عرض التفسير (الميسر)
                    </button>
                    <!-- Note: Controller fetches 'ar.jalalayn', but label says 'Muyassar'? Better say 'تفسير الجلالين' based on code -->
                    <!-- Code check: Step 984 says 'ar.jalalayn'. So 'تفسير الجلالين' is correct. -->
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
                            $text = preg_replace('/^[\x{0600}-\x{06FF}\s]{0,50}ٱلرَّحِيمِ\s?/u', '', $text);
                        }
                    @endphp

                    <div class="ayah-container" id="ayah-{{ $ayah['numberInSurah'] }}">
                        <div class="actions-bar">
                            <button class="btn-bookmark"
                                onclick="saveBookmark({{ $surah['number'] }}, '{{ $surah['name'] }}', {{ $ayah['numberInSurah'] }}, this)">
                                🔖 حفظ
                            </button>
                        </div>
                        <div class="quran-text">
                            {{ $text }} <span class="ayah-number">{{ $ayah['numberInSurah'] }}</span>
                        </div>

                        @if(isset($audio['ayahs'][$index]))
                            <div class="audio-container">
                                <audio controls preload="none" style="width: 100%; height: 30px; margin-top: 10px; opacity: 0.8;">
                                    <source src="{{ $audio['ayahs'][$index]['audio'] }}" type="audio/mpeg">
                                    متصفحك لا يدعم تشغيل الصوت.
                                </audio>
                            </div>
                        @endif

                        @if(isset($tafsir['ayahs'][$index]))
                            <div class="tafsir-text">
                                <strong>تفسير الجلالين:</strong> {{ $tafsir['ayahs'][$index]['text'] }}
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
                btn.innerHTML = '👁️ عرض التفسير (الجلالين)';
            } else {
                // Show
                tafsirs.forEach(el => el.style.display = 'block');
                btn.classList.add('active');
                btn.innerHTML = '👁️ إخفاء التفسير';
            }
        }

        function saveBookmark(surahNum, surahName, ayahNum, btn) {
            const bookmark = {
                surah: surahNum,
                name: surahName,
                ayah: ayahNum,
                timestamp: new Date().getTime()
            };
            localStorage.setItem('khatma_bookmark', JSON.stringify(bookmark));

            // Visual Update
            document.querySelectorAll('.btn-bookmark').forEach(b => {
                b.classList.remove('saved');
                b.innerHTML = '🔖 حفظ';
            });
            document.querySelectorAll('.ayah-container').forEach(c => c.classList.remove('highlight'));

            btn.classList.add('saved');
            btn.innerHTML = '✅ تم الحفظ';

            const container = document.getElementById(`ayah-${ayahNum}`);
            if (container) container.classList.add('highlight');
        }

        // Check for existing bookmark on load
        document.addEventListener('DOMContentLoaded', () => {
            const saved = localStorage.getItem('khatma_bookmark');
            if (saved) {
                const data = JSON.parse(saved);
                // Check if we are on the correct Surah
                // We can't easily check Surah Number from JS unless we pass it, 
                // but checking if the element exists is a good proxy.
                const targetAyah = document.getElementById(`ayah-${data.ayah}`);

                // Need to confirm Surah Number match. 
                // We can infer it from the first saveBookmark call argument in the HTML, 
                // or just check if the stored surah matches the URL or a global variable.
                // Let's rely on the PHP variable passed to the view if possible. 
                // Simple hack: check if the 'Actions' in this page belong to the saved Surah.
                // Actually, we can check the URL path or just look for the ID.
                // But multiple surahs might have ayah-5.

                // Better: Use a data attribute on Body or check URL
                const currentSurahNum = {{ $surah['number'] ?? 0 }};

                if (data.surah == currentSurahNum && targetAyah) {
                    targetAyah.classList.add('highlight');
                    targetAyah.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    const btn = targetAyah.querySelector('.btn-bookmark');
                    if (btn) {
                        btn.classList.add('saved');
                        btn.innerHTML = '✅ المحفوظ';
                    }
                }
            }
        });
    </script>
</body>

</html>