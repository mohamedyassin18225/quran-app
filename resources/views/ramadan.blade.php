<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وضع رمضان | تطبيق الصلاة</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e293b">
    <script src="/js/theme.js"></script>

    <style>
        :root {
            --primary: #1e293b;
            --secondary: #334155;
            --accent: #fbbf24;
            /* Gold/Amber for Ramadan */
            --accent-glow: rgba(251, 191, 36, 0.4);
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--primary);
            color: var(--text-light);
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            text-align: right;
            background-image: radial-gradient(circle at top, #2c3e50, var(--primary));
        }

        .container {
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        .header h1 {
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--accent);
            text-shadow: 0 0 20px var(--accent-glow);
        }

        .status-card {
            background: rgba(30, 41, 59, 0.8);
            border: 2px solid var(--accent);
            border-radius: 20px;
            padding: 40px 20px;
            margin: 30px 0;
            box-shadow: 0 0 30px rgba(251, 191, 36, 0.1);
        }

        .label {
            font-size: 1.2rem;
            color: var(--text-dim);
            margin-bottom: 15px;
        }

        .countdown {
            font-size: 4rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 10px;
            font-variant-numeric: tabular-nums;
        }

        .next-event {
            font-size: 1.5rem;
            color: var(--accent);
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-card {
            background: var(--secondary);
            padding: 20px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .info-time {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .info-label {
            font-size: 0.9rem;
            color: var(--text-dim);
        }

        .back-link {
            align-self: flex-end;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .loading {
            font-size: 1.2rem;
            color: var(--text-dim);
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&rarr;</a>

    <div class="container">
        <div class="header">
            <h1>رمضان كريم</h1>
            <p style="color:var(--text-dim)">تقبل الله منا ومنكم صالح الأعمال</p>
        </div>

        <div id="loading" class="loading">جارِ تحديد الموقع وحساب الأوقات...</div>

        <div id="content" style="display:none;">
            <div class="status-card">
                <div class="label" id="timer-label">المتبقي على الإفطار</div>
                <div class="countdown" id="timer">--:--:--</div>
                <div class="next-event" id="next-event-name">المغرب: 00:00</div>
            </div>

            <div class="info-grid">
                <div class="info-card">
                    <div class="info-time" id="iftar-time">--:--</div>
                    <div class="info-label">موعد الإفطار (المغرب)</div>
                </div>
                <div class="info-card">
                    <div class="info-time" id="suhoor-time">--:--</div>
                    <div class="info-label">موعد السحور (الفجر)</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let maghribToday, fajrTomorrow, fajrToday;

        function init() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(fetchTimes, error => {
                    alert("نحتاج إلى معرفة موقعك لحساب أوقات الإفطار والسحور.");
                    document.getElementById('loading').innerText = "تعذر تحديد الموقع";
                });
            } else {
                alert("المتصفح لا يدعم تحديد الموقع");
            }
        }

        async function fetchTimes(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const method = 5; // Default Egyptian

            try {
                // Fetch Today
                const today = new Date();
                const d1 = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();

                // Fetch Tomorrow
                const tomorrow = new Date(today);
                tomorrow.setDate(tomorrow.getDate() + 1);
                const d2 = tomorrow.getDate() + '-' + (tomorrow.getMonth() + 1) + '-' + tomorrow.getFullYear();

                const url = `https://api.aladhan.com/v1/timings/${d1}?latitude=${lat}&longitude=${lng}&method=${method}`;
                const url2 = `https://api.aladhan.com/v1/timings/${d2}?latitude=${lat}&longitude=${lng}&method=${method}`;

                const [res1, res2] = await Promise.all([fetch(url), fetch(url2)]);
                const data1 = await res1.json();
                const data2 = await res2.json();

                if (data1.code === 200 && data2.code === 200) {
                    const t1 = data1.data.timings;
                    const t2 = data2.data.timings;

                    // Parse Times
                    maghribToday = parseTime(d1, t1.Maghrib);
                    fajrToday = parseTime(d1, t1.Fajr);
                    fajrTomorrow = parseTime(d2, t2.Fajr); // For Suhoor Next Day

                    // Update UI
                    document.getElementById('iftar-time').innerText = formatTime(maghribToday);
                    document.getElementById('suhoor-time').innerText = formatTime(fajrToday); // Wait, Suhoor is Fajr. 
                    // Usually Suhoor visual is Fajr of TOMORROW if we are in evening, or Fajr of TODAY if we are in morning.
                    // But let's show upcoming Fajr always?
                    // Let's stick to standard: "Next Iftar" and "Next Suhoor".

                    startTimer();
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('content').style.display = 'block';
                }
            } catch (e) {
                console.error(e);
                document.getElementById('loading').innerText = "فشل الاتصال بالخادم";
            }
        }

        function parseTime(dateStr, timeStr) {
            // dateStr: DD-MM-YYYY, timeStr: HH:MM
            const [d, m, y] = dateStr.split('-');
            const [h, min] = timeStr.split(':');
            return new Date(y, m - 1, d, h, min, 0);
        }

        function formatTime(date) {
            let h = date.getHours();
            let m = date.getMinutes();
            let ampm = h >= 12 ? 'م' : 'ص';
            h = h % 12;
            h = h ? h : 12; // the hour '0' should be '12'
            m = m < 10 ? '0' + m : m;
            return h + ':' + m + ' ' + ampm;
        }

        function startTimer() {
            setInterval(updateTimer, 1000);
            updateTimer();
        }

        function updateTimer() {
            const now = new Date();
            let target;
            let mode = ""; // "iftar" or "suhoor"

            // Logic:
            // If Now < FajrToday -> Target = FajrToday (Suhoor)
            // If Now > FajrToday && Now < MaghribToday -> Target = MaghribToday (Iftar)
            // If Now > MaghribToday -> Target = FajrTomorrow (Suhoor)

            if (now < fajrToday) {
                target = fajrToday;
                mode = "suhoor";
            } else if (now < maghribToday) {
                target = maghribToday;
                mode = "iftar";
            } else {
                target = fajrTomorrow;
                mode = "suhoor";
            }

            const diff = target - now;

            // Labels
            const labelEl = document.getElementById('timer-label');
            const nextEventEl = document.getElementById('next-event-name');
            const suhoorBox = document.getElementById('suhoor-time');

            if (mode === 'iftar') {
                labelEl.innerText = "المتبقي على الإفطار";
                // labelEl.style.color = "var(--text-dim)";
                nextEventEl.innerText = "صلاة المغرب: " + formatTime(target);
                // Also update the Suhoor box to show NEXT suhoor (tomorrow) dynamically?
                // Currently it shows FajrToday. Let's update it.
                suhoorBox.innerText = formatTime(fajrTomorrow);
            } else {
                labelEl.innerText = "المتبقي على السحور (الإمساك)";
                // labelEl.style.color = "#ef4444"; // Red for urgency? or just same
                nextEventEl.innerText = "صلاة الفجر: " + formatTime(target);
                suhoorBox.innerText = formatTime(target); // Target is either fajrToday or fajrTomorrow
            }

            // Countdown Format
            if (diff > 0) {
                const hours = Math.floor(diff / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                document.getElementById('timer').innerText =
                    (hours < 10 ? "0" + hours : hours) + ":" +
                    (minutes < 10 ? "0" + minutes : minutes) + ":" +
                    (seconds < 10 ? "0" + seconds : seconds);
            } else {
                document.getElementById('timer').innerText = "00:00:00";
            }
        }

        init();
    </script>

</body>

</html>