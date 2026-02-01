<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prayer Times | {{ $location ?? 'Unknown' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" href="/icon.png">
    <link rel="apple-touch-icon" href="/icon.png">
    <meta name="theme-color" content="#1e293b">
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
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
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
            letter-spacing: 2px;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .time-display {
            font-size: 3.5rem;
            font-weight: 300;
            margin: 10px 0;
            text-shadow: 0 0 20px var(--accent-glow);
        }

        .date-info {
            color: var(--text-dim);
            font-size: 0.95rem;
        }

        .hijri-date {
            margin-top: 5px;
            color: #e2e8f0;
            font-weight: 500;
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
            font-weight: 600;
            font-size: 1.1rem;
        }

        .prayer-time {
            font-family: 'Outfit', sans-serif;
            font-variant-numeric: tabular-nums;
            font-size: 1.2rem;
            color: var(--text-light);
        }

        .error-message {
            color: #ef4444;
            text-align: center;
            padding: 20px;
            background: rgba(239, 68, 68, 0.1);
            border-radius: 12px;
        }

        /* Next Prayer Indicator */
        .next-prayer-badge {
            font-size: 0.75rem;
            background: var(--accent);
            color: #0f172a;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 10px;
            vertical-align: middle;
            font-weight: bold;
        }

        /* Audio Controls */
        .audio-controls {
            position: absolute;
            top: 20px;
            right: 20px;
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
            font-weight: 600;
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.5);
            transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 100;
            opacity: 0;
        }

        .adhan-toast.visible {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="audio-controls">
            <button id="enableAudio" class="btn-audio" title="Enable Adhan Audio" onclick="toggleAudio()">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="off-icon">
                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                    <line x1="23" y1="9" x2="17" y2="15"></line>
                    <line x1="17" y1="9" x2="23" y2="15"></line>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="on-icon" style="display:none;">
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
                <div class="location">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        style="display:inline-block; vertical-align:text-top; margin-right:4px;">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    {{ $location }}
                </div>
                <div class="time-display" id="currentTime">--:--</div>
                <div class="date-info">{{ $date['gregorian']['weekday']['en'] }}, {{ $date['gregorian']['day'] }}
                    {{ $date['gregorian']['month']['en'] }} {{ $date['gregorian']['year'] }}
                </div>
                <div class="hijri-date">{{ $date['hijri']['day'] }} {{ $date['hijri']['month']['en'] }}
                    {{ $date['hijri']['year'] }}
                </div>
            </div>

            <div class="prayers-list">
                @foreach(['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'] as $prayer)
                    <div class="prayer-item" id="row-{{ $prayer }}">
                        <div class="prayer-name">{{ $prayer }}</div>
                        <div class="prayer-time">{{ $timings[$prayer] }}</div>
                    </div>
                @endforeach
            </div>
            <div class="footer-links"
                style="text-align:center; margin-top:25px; display:flex; gap:10px; justify-content:center;">
                <a href="/athkar"
                    style="color:var(--text-dim); text-decoration:none; font-size:0.9rem; border:1px solid rgba(255,255,255,0.1); padding:8px 16px; border-radius:30px; transition:all 0.3s;">
                    📖 Morning & Evening Adhkar
                </a>
                <a href="/quran"
                    style="color:var(--text-dim); text-decoration:none; font-size:0.9rem; border:1px solid rgba(255,255,255,0.1); padding:8px 16px; border-radius:30px; transition:all 0.3s;">
                    ☪️ Holy Quran
                </a>
                <a href="/tajweed"
                    style="color:var(--text-dim); text-decoration:none; font-size:0.9rem; border:1px solid rgba(255,255,255,0.1); padding:8px 16px; border-radius:30px; transition:all 0.3s;">
                    📘 Tajweed Rules
                </a>
            </div>
        @endif
    </div>

    <!-- Adhan Audio Source -->
    <audio id="adhanAudio" src="https://www.islamcan.com/audio/adhan/azan1.mp3" preload="auto"></audio>

    <!-- Notification Toast -->
    <div id="adhanToast" class="adhan-toast">
        It's time for prayer
    </div>

    <script>
        let audioEnabled = false;
        let lastPlayedMinute = -1;

        function toggleAudio() {
            const audio = document.getElementById('adhanAudio');
            const btn = document.getElementById('enableAudio');
            const offIcon = btn.querySelector('.off-icon');
            const onIcon = btn.querySelector('.on-icon');

            if (!audioEnabled) {
                // Try playing muted first - this is always allowed
                audio.muted = true;

                audio.play().then(() => {
                    // Audio started (muted)
                    audio.pause();
                    audio.currentTime = 0;
                    audio.muted = false; // Unmute for future use
                    audioEnabled = true;

                    btn.classList.add('enabled');
                    offIcon.style.display = 'none';
                    onIcon.style.display = 'block';

                    showToast('Adhan audio enabled');
                }).catch(e => {
                    console.error("Audio unlock failed", e);
                    alert('Could not enable audio: ' + e.message);
                });
            } else {
                audioEnabled = false;
                audio.pause();
                audio.currentTime = 0;
                btn.classList.remove('enabled');
                offIcon.style.display = 'block';
                onIcon.style.display = 'none';
            }
        }

        function playAdhan(prayerName) {
            if (audioEnabled) {
                const audio = document.getElementById('adhanAudio');
                audio.currentTime = 0;
                audio.play();
            }
            showToast("It's time for " + prayerName);
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
            const timeString = now.toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });
            document.getElementById('currentTime').innerText = timeString;

            // Allow time for server times to be rendered
            checkPrayerTime(now);
            highlightNextPrayer();
        }

        function checkPrayerTime(now) {
            // Using 24h format HH:MM
            const currentHM = now.toLocaleTimeString('en-US', { hour12: false, hour: '2-digit', minute: '2-digit' });

            // Prevent playing multiple times in the same minute
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
                // Clean the time string (remove timezone info if any, e.g., "12:00 (EET)")
                let pTime = p.time.split(' ')[0];

                if (pTime === currentHM) {
                    playAdhan(p.name);
                    lastPlayedMinute = currentMinuteVals;
                }
            });
        }

        function highlightNextPrayer() {
            // Simple logic to highlight: requires converting 'HH:MM' strings to Date objects
            // For MVP visual only - improved logic would compare actual timestamps
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
                const [h, m] = p.time.split(' ')[0].split(':'); // Aladhan returns HH:MM (24h) usually, sometimes with timezone
                const prayerMinutes = parseInt(h) * 60 + parseInt(m);

                const row = document.getElementById('row-' + p.name);
                if (row) row.classList.remove('active');

                if (!activeFound && prayerMinutes > currentMinutes) {
                    if (row) row.classList.add('active');
                    activeFound = true;
                }
            });

            // If no next prayer found today, it means next is Fajr tomorrow
            if (!activeFound) {
                const row = document.getElementById('row-Fajr');
                if (row) row.classList.add('active');
            }
        }

        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>

</html>