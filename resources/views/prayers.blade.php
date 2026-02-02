<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مواقيت الصلاة | {{ $location ?? 'غير معروف' }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" href="/icon.png">
    <link rel="apple-touch-icon" href="/icon.png">
    <meta name="theme-color" content="#1e293b">
    <script src="/js/theme.js"></script>
    <style>
        :root {
            --primary: #1e293b;
            --secondary: #334155;
            --accent: #10b981;
            /* Emerald Green */
            --accent-glow: rgba(16, 185, 129, 0.4);
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --card-bg: rgba(30, 41, 59, 0.7);
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            text-align: right;
        }

        .container {
            width: 100%;
            max-width: 480px;
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .location {
            font-size: 1.1rem;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .time-display {
            font-size: 3.5rem;
            font-weight: 700;
            margin: 10px 0;
            text-shadow: 0 0 20px var(--accent-glow);
            font-family: 'Cairo', sans-serif;
            direction: ltr;
            /* Time numbers usually look better LTR */
        }

        .date-info {
            color: var(--text-dim);
            font-size: 0.95rem;
        }

        .hijri-date {
            margin-top: 5px;
            color: #e2e8f0;
            font-weight: 600;
        }

        .prayers-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .prayer-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .prayer-item:hover {
            background: rgba(255, 255, 255, 0.07);
            transform: translateY(-2px);
        }

        .prayer-item.active {
            background: rgba(16, 185, 129, 0.1);
            border-color: var(--accent);
            box-shadow: 0 0 15px var(--accent-glow);
        }

        .prayer-name {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .prayer-time {
            font-family: 'Cairo', sans-serif;
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--text-light);
            direction: ltr;
        }

        .error-message {
            color: #ef4444;
            text-align: center;
            padding: 20px;
            background: rgba(239, 68, 68, 0.1);
            border-radius: 12px;
        }

        /* Audio Controls */
        .audio-controls {
            position: absolute;
            top: 20px;
            left: 20px;
            /* Swapped for RTL */
            right: auto;
        }

        .btn-audio {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: var(--text-dim);
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-audio:hover {
            background: rgba(255, 255, 255, 0.2);
            color: var(--text-light);
        }

        .btn-audio.enabled {
            color: var(--accent);
            background: rgba(16, 185, 129, 0.1);
        }

        /* Toast for Adhan */
        .adhan-toast {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: var(--accent);
            color: #0f172a;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 700;
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.5);
            transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 100;
            opacity: 0;
        }

        .adhan-toast.visible {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        /* Dashboard Grid */
        .tools-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 30px;
        }

        .tool-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 12px 5px;
            text-align: center;
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            aspect-ratio: 1;
        }

        .tool-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            border-color: var(--accent);
        }

        .tool-icon {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .tool-name {
            font-size: 0.75rem;
            color: var(--text-dim);
            font-weight: 600;
            line-height: 1.1;
        }

        @media (max-width: 380px) {
            .tools-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="audio-controls">
            <button id="enableAudio" class="btn-audio enabled" title="تشغيل/إيقاف الآذان" onclick="toggleAudio()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="off-icon" style="display:none;">
                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                    <line x1="23" y1="9" x2="17" y2="15"></line>
                    <line x1="17" y1="9" x2="23" y2="15"></line>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="on-icon">
                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                    <path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                </svg>
            </button>
        </div>

        @if(isset($error))
            <div class="error-message">
                {{ $error }}
            </div>
        @else
            <div class="header">
                <div class="location" onclick="requestLocation()" style="cursor: pointer;" title="تحديث الموقع">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        style="display:inline-block; vertical-align:text-top; margin-left:4px;">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    {{ $location }}
                    <span style="font-size: 0.8rem; opacity: 0.7; margin-right: 5px;">(تحديث)</span>
                </div>
                <div class="time-display" id="currentTime">--:--</div>

                <div class="date-info">
                    {{ $date['gregorian']['day'] }} {{ $date['gregorian']['month']['en'] }} {{ $date['gregorian']['year'] }}
                </div>
                <div class="hijri-date">
                    {{ $date['hijri']['day'] }} {{ $date['hijri']['month']['ar'] ?? $date['hijri']['month']['en'] }}
                    {{ $date['hijri']['year'] }}
                </div>
            </div>

            <div class="prayers-list">
                @php
                    $prayerNames = [
                        'Fajr' => 'الفجر',
                        'Dhuhr' => 'الظهر',
                        'Asr' => 'العصر',
                        'Maghrib' => 'المغرب',
                        'Isha' => 'العشاء'
                    ];
                @endphp
                @foreach(['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'] as $prayer)
                    <div class="prayer-item" id="row-{{ $prayer }}">
                        <div class="prayer-name">{{ $prayerNames[$prayer] }}</div>
                        <div class="prayer-time">{{ $timings[$prayer] }}</div>
                    </div>
                @endforeach
            </div>

            <div class="tools-grid">
                <a href="/quran" class="tool-item">
                    <div class="tool-icon">📖</div>
                    <div class="tool-name">القرآن</div>
                </a>
                <a href="/tasbih" class="tool-item">
                    <div class="tool-icon">📿</div>
                    <div class="tool-name">التسبيح</div>
                </a>
                <a href="/names" class="tool-item">
                    <div class="tool-icon">🤲</div>
                    <div class="tool-name">الأسماء الحسنى</div>
                </a>
                <a href="/athkar" class="tool-item">
                    <div class="tool-icon">🌙</div>
                    <div class="tool-name">الأذكار</div>
                </a>
                <a href="/hijri" class="tool-item">
                    <div class="tool-icon">📅</div>
                    <div class="tool-name">التاريخ الهجري</div>
                </a>
                <a href="/qibla" class="tool-item">
                    <div class="tool-icon">🧭</div>
                    <div class="tool-name">القبلة</div>
                </a>
                <a href="/tajweed" class="tool-item">
                    <div class="tool-icon">📘</div>
                    <div class="tool-name">التجويد</div>
                </a>
                <a href="/zakat" class="tool-item">
                    <div class="tool-icon">💰</div>
                    <div class="tool-name">الزكاة</div>
                </a>
                <a href="/calendar" class="tool-item">
                    <div class="tool-icon">📅</div>
                    <div class="tool-name">المناسبات</div>
                </a>
                <a href="/settings" class="tool-item">
                    <div class="tool-icon">⚙️</div>
                    <div class="tool-name">الإعدادات</div>
                </a>
            </div>
        @endif
    </div>

    <!-- Adhan Audio Source -->
    <audio id="adhanAudio" src="https://www.islamcan.com/audio/adhan/azan1.mp3" preload="auto"></audio>

    <!-- Notification Toast -->
    <div id="adhanToast" class="adhan-toast">
        حان الآن موعد الصلاة
    </div>

    <script>
        let audioEnabled = true; // Enabled by default
        let lastPlayedMinute = -1;

        // Unlock audio context on first interaction
        function unlockAudio() {
            const audio = document.getElementById('adhanAudio');
            if (audio) {
                audio.muted = true;
                audio.play().then(() => {
                    audio.pause();
                    audio.currentTime = 0;
                    audio.muted = false;
                }).catch(e => console.log("Unlock failed (waiting for interaction)", e));
            }
            document.removeEventListener('click', unlockAudio);
            document.removeEventListener('touchstart', unlockAudio);
        }
        document.addEventListener('click', unlockAudio);
        document.addEventListener('touchstart', unlockAudio);


        function toggleAudio() {
            const audio = document.getElementById('adhanAudio');
            const btn = document.getElementById('enableAudio');
            const offIcon = btn.querySelector('.off-icon');
            const onIcon = btn.querySelector('.on-icon');

            if (!audioEnabled) {
                // Enable
                audioEnabled = true;
                btn.classList.add('enabled');
                offIcon.style.display = 'none';
                onIcon.style.display = 'block';
                showToast('تم تفعيل صوت الآذان');

                audio.muted = true;
                audio.play().then(() => { audio.pause(); audio.currentTime = 0; audio.muted = false; });
            } else {
                // Disable
                audioEnabled = false;
                audio.pause();
                audio.currentTime = 0;
                btn.classList.remove('enabled');
                offIcon.style.display = 'block';
                onIcon.style.display = 'none';
                showToast('تم إيقاف صوت الآذان');
            }
        }

        function playAdhan(prayerName) {
            if (audioEnabled) {
                const audio = document.getElementById('adhanAudio');
                audio.currentTime = 0;
                const playPromise = audio.play();

                if (playPromise !== undefined) {
                    playPromise.catch(error => {
                        console.log("Autoplay blocked:", error);
                        showToast("اضغط لتشغيل الآذان");
                    });
                }
            }
            // Arabize prayer name for toast?
            const prayerNamesAr = {
                'Fajr': 'الفجر',
                'Dhuhr': 'الظهر',
                'Asr': 'العصر',
                'Maghrib': 'المغرب',
                'Isha': 'العشاء'
            };
            showToast("حان الآن موعد صلاة " + (prayerNamesAr[prayerName] || prayerName));
        }

        function showToast(message) {
            const toast = document.getElementById('adhanToast');
            toast.innerText = message;
            toast.classList.add('visible');
            setTimeout(() => {
                toast.classList.remove('visible');
            }, 5000);
        }

        function updateTime() {
            const now = new Date();
            // Use en-US for consistent time format HH:MM
            const timeString = now.toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });
            document.getElementById('currentTime').innerText = timeString;

            checkPrayerTime(now);
            highlightNextPrayer();
        }

        function checkPrayerTime(now) {
            const currentHM = now.toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });
            const currentMinuteVals = now.getHours() * 60 + now.getMinutes();
            if (currentMinuteVals === lastPlayedMinute) return;

            const prayers = [
                { name: 'Fajr', time: '{{ $timings['Fajr'] ?? "00:00" }}' },
                { name: 'Dhuhr', time: '{{ $timings['Dhuhr'] ?? "00:00" }}' },
                { name: 'Asr', time: '{{ $timings['Asr'] ?? "00:00" }}' },
                { name: 'Maghrib', time: '{{ $timings['Maghrib'] ?? "00:00" }}' },
                { name: 'Isha', time: '{{ $timings['Isha'] ?? "00:00" }}' }
            ];

            prayers.forEach(p => {
                let pTime = p.time.split(' ')[0];
                if (pTime === currentHM) {
                    playAdhan(p.name);
                    lastPlayedMinute = currentMinuteVals;
                }
            });
        }

        function highlightNextPrayer() {
            const now = new Date();
            const currentMinutes = now.getHours() * 60 + now.getMinutes();

            const prayers = [
                { name: 'Fajr', time: '{{ $timings['Fajr'] ?? "00:00" }}' },
                { name: 'Dhuhr', time: '{{ $timings['Dhuhr'] ?? "00:00" }}' },
                { name: 'Asr', time: '{{ $timings['Asr'] ?? "00:00" }}' },
                { name: 'Maghrib', time: '{{ $timings['Maghrib'] ?? "00:00" }}' },
                { name: 'Isha', time: '{{ $timings['Isha'] ?? "00:00" }}' }
            ];

            let activeFound = false;

            prayers.forEach(p => {
                const [h, m] = p.time.split(' ')[0].split(':');
                const prayerMinutes = parseInt(h) * 60 + parseInt(m);

                const row = document.getElementById('row-' + p.name);
                if (row) row.classList.remove('active');

                if (!activeFound && prayerMinutes > currentMinutes) {
                    if (row) row.classList.add('active');
                    activeFound = true;
                }
            });

            if (!activeFound) {
                const row = document.getElementById('row-Fajr');
                if (row) row.classList.add('active');
            }
        }

        function requestLocation() {
            if (navigator.geolocation) {
                document.querySelector('.location').innerHTML = '...جارِ تحديد الموقع';

                navigator.geolocation.getCurrentPosition(
                    async (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        let city = '';

                        try {
                            const response = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=ar`);
                            const data = await response.json();
                            city = data.city || data.locality || data.principalSubdivision || '';
                        } catch (e) {
                            console.error("Geocoding failed", e);
                        }

                        // Reload with coordinates and city
                        const url = `/?lat=${lat}&lng=${lng}` + (city ? `&city=${encodeURIComponent(city)}` : '');
                        window.location.href = url;
                    },
                    (error) => {
                        alert('تعذر الوصول إلى الموقع. يرجى تفعيل GPS.');
                        location.reload();
                    }
                );
            } else {
                alert('المتصفح لا يدعم تحديد الموقع.');
            }
        }

        setInterval(updateTime, 1000);
        updateTime();
    </script>
    <div id="reminder-banner"
        style="display:none; position:fixed; bottom:20px; left:50%; transform:translateX(-50%); background:var(--accent); color:#0f172a; padding:15px 25px; border-radius:30px; box-shadow:0 10px 25px rgba(0,0,0,0.5); z-index:100; cursor:pointer; font-weight:bold; width: 90%; max-width: 400px; text-align: center;">
        <span id="reminder-text">🔔 لا تنس أذكار الصباح</span>
    </div>

    <script>
        function checkReminders() {
            const now = new Date();
            const hour = now.getHours();
            const today = now.toISOString().split('T')[0];
            const banner = document.getElementById('reminder-banner');
            const text = document.getElementById('reminder-text');

            let type = null;
            // Morning: 5 AM - 11 AM
            if (hour >= 5 && hour < 11) type = 'morning';
            // Evening: 3 PM - 9 PM
            else if (hour >= 15 && hour < 21) type = 'evening';

            if (!type) return;

            const key = `saw_${type}_athkar_${today}`;
            if (!localStorage.getItem(key)) {
                text.innerText = type === 'morning' ? '🔔 لا تنس أذكار الصباح' : '🔔 لا تنس أذكار المساء';
                banner.style.display = 'block';

                banner.onclick = () => {
                    localStorage.setItem(key, 'true');
                    window.location.href = `/athkar?tab=${type}`;
                };
            }
        }

        setInterval(checkReminders, 60000); // Check every minute
        checkReminders(); // Check immediately
    </script>
</body>

</html>