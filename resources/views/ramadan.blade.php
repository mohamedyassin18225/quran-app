<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وضع رمضان | تطبيق الصلاة</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Amiri:wght@700&display=swap"
        rel="stylesheet">
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
            --success: #10b981;
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
            background-image: radial-gradient(circle at top, #2c3e50, 20%, var(--primary));
            background-attachment: fixed;
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
            font-family: 'Amiri', serif;
            font-size: 2.5rem;
        }

        .status-card {
            background: rgba(30, 41, 59, 0.8);
            border: 2px solid var(--accent);
            border-radius: 20px;
            padding: 30px 20px;
            margin: 30px 0;
            box-shadow: 0 0 30px rgba(251, 191, 36, 0.15);
            backdrop-filter: blur(10px);
        }

        .label {
            font-size: 1.1rem;
            color: var(--text-dim);
            margin-bottom: 15px;
        }

        .countdown {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 10px;
            font-variant-numeric: tabular-nums;
        }

        .next-event {
            font-size: 1.3rem;
            color: var(--accent);
            font-weight: 600;
        }

        .section-title {
            text-align: right;
            border-right: 4px solid var(--accent);
            padding-right: 15px;
            margin: 40px 0 20px;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-light);
            background: linear-gradient(90deg, rgba(251, 191, 36, 0.1), transparent);
            padding-top: 5px;
            padding-bottom: 5px;
            border-radius: 4px;
        }

        /* ----- Dua Card ----- */
        .dua-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dua-text {
            font-family: 'Amiri', serif;
            font-size: 1.4rem;
            line-height: 1.8;
            margin-bottom: 15px;
            color: #fff;
        }

        .dua-nav {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 15px;
        }

        .dua-btn {
            background: transparent;
            border: 1px solid var(--text-dim);
            color: var(--text-dim);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .dua-btn:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* ----- Checklist ----- */
        .checklist-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .checklist-item:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .checklist-item.checked {
            background: rgba(16, 185, 129, 0.15);
            border-color: var(--success);
        }

        .check-circle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid var(--text-dim);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .checklist-item.checked .check-circle {
            background: var(--success);
            border-color: var(--success);
            color: #fff;
        }

        .checkbox-label {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .back-link {
            align-self: flex-start;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.2rem;
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .loading {
            font-size: 1.2rem;
            color: var(--text-dim);
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <div class="container">
        <a href="/" class="back-link">&rarr; الرئيسية</a>

        <div class="header">
            <h1>رمضان كريم</h1>
            <p style="color:var(--text-dim)" id="hijri-date">...</p>
        </div>

        <div id="loading" class="loading">جارِ التهيئة...</div>

        <div id="content" style="display:none;">

            <!-- TIMER -->
            <div class="status-card">
                <div class="label" id="timer-label">المتبقي على الإفطار</div>
                <div class="countdown" id="timer">--:--:--</div>
                <div class="next-event" id="next-event-name">المغرب: 00:00</div>
            </div>

            <!-- CHECKLIST -->
            <div class="section-title">متابعة اليوم</div>
            <div id="checklist-container">
                <div class="checklist-item" onclick="toggleTask('fasting')">
                    <span class="checkbox-label">🌙 صيام اليوم</span>
                    <div class="check-circle" id="check-fasting"></div>
                </div>
                <div class="checklist-item" onclick="toggleTask('taraweeh')">
                    <span class="checkbox-label">🕌 صلاة التراويح</span>
                    <div class="check-circle" id="check-taraweeh"></div>
                </div>
                <div class="checklist-item" onclick="toggleTask('quran')">
                    <span class="checkbox-label">📖 ورد القرآن</span>
                    <div class="check-circle" id="check-quran"></div>
                </div>
                <div class="checklist-item" onclick="toggleTask('charity')">
                    <span class="checkbox-label">❤️ صدقة / إطعام</span>
                    <div class="check-circle" id="check-charity"></div>
                </div>
            </div>

            <!-- DUA -->
            <div class="section-title">دعاء اليوم</div>
            <div class="dua-card">
                <div class="label" style="font-size:0.9rem; margin-bottom:10px;" id="dua-day-num">اليوم 1</div>
                <div class="dua-text" id="dua-text">...</div>
                <div class="dua-nav">
                    <button class="dua-btn" onclick="changeDua(-1)">&rarr;</button>
                    <button class="dua-btn" onclick="changeDua(1)">&larr;</button>
                </div>
            </div>

        </div>
    </div>

    <script>
        // --- State ---
        let maghribToday, fajrTomorrow, fajrToday;
        let currentDayIndex = 0; // 0-29

        // --- Data ---
        const duas = [
            "اللهم اجعل صيامي فيه صيام الصائمين وقيامي فيه قيام القائمين، ونبهني فيه عن نومة الغافلين.",
            "اللهم قربني فيه إلى مرضاتك، وجنبني فيه من سخطك ونقماتك، ووفقني فيه لقراءة آياتك.",
            "اللهم ارزقني فيه الذهن والتنبيه، وباعدني فيه من السفاهة والتمويه، واجعل لي نصيباً من كل خير تنزله فيه.",
            "اللهم قوني فيه على إقامة أمرك، وأذقني فيه حلاوة ذكرك، وأوزعني فيه لأداء شكرك بكرمك.",
            "اللهم اجعلني فيه من المستغفرين، واجعلني فيه من عبادك الصالحين القانتين.",
            "اللهم لا تخذلني فيه لتعرض معصيتك، ولا تضربني بسياط نقمتك، وزحزحني فيه من موجبات سخطك.",
            "اللهم أعني فيه على صيامه وقيامه، وجنبني فيه من هفواته وآثامه، وارزقني فيه ذكرك بدوامه.",
            "اللهم ارزقني فيه رحمة الأيتام وإطعام الطعام وإفشاء السلام وصحبة الكرام.",
            "اللهم اجعل لي فيه نصيباً من رحمتك الواسعة، واهدني فيه لبراهينك الساطعة.",
            "اللهم اجعلني فيه من المتوكلين عليك، واجعلني فيه من الفائزين لديك، واجعلني فيه من المقربين إليك.",
            "اللهم حبب إلي فيه الإحسان، وكره إلي فيه الفسوق والعصيان، وحرم علي فيه السخط والنيران.",
            "اللهم زيني فيه بالستر والعفاف، واسترني فيه بلباس القنوع والكفاف.",
            "اللهم طهرني فيه من الدنس والأقذار، وصبرني فيه على كائنات الأقدار.",
            "اللهم لا تؤاخذني فيه بالعثرات، وأقلني فيه من الخطايا والهفوات.",
            "اللهم ارزقني فيه طاعة الخاشعين، واشرح فيه صدري بإنابة المخبتين.",
            "اللهم وفقني فيه لموافقة الأبرار، وجنبني فيه مرافقة الأشرار، وآوني فيه برحمتك إلى دار القرار.",
            "اللهم اهدني فيه لصالح الأعمال، واقض لي فيه الحوائج والآمال.",
            "اللهم نبهني فيه لبركات أسحاره، ونور قلبي بضياء أنواره.",
            "اللهم وفر فيه حظي من بركاته، وسهل سبيلي إلى خيراته.",
            "اللهم افتح لي فيه أبواب الجنان، وأغلق عني فيه أبواب النيران.",
            "اللهم اجعل لي فيه إلى مرضاتك دليلاً، ولا تجعل للشيطان فيه علي سبيلاً.",
            "اللهم افتح لي فيه أبواب فضلك، وأنزل علي فيه بركاتك، ووفقني فيه لموجبات مرضاتك.",
            "اللهم اغسلني فيه من الذنوب، وطهرني فيه من العيوب، وامتحن قلبي فيه بتقوى القلوب.",
            "اللهم إني أسألك فيه ما يرضيك، وأعوذ بك مما يؤذيك، وأسألك التوفيق فيه لأن أطيعك ولا أعصيك.",
            "اللهم اجعلني فيه محباً لأوليائك، ومعادياً لأعدائك، مستناً بسنة خاتم أنبيائك.",
            "اللهم اجعل سعيي فيه مشكوراً، وذنبي فيه مغفوراً، وعملي فيه مقبولاً.",
            "اللهم ارزقني فيه فضل ليلة القدر، وصير أموري فيه من العسر إلى اليسر.",
            "اللهم وفر حظي فيه من النوافل، وأكرمني فيه بإحضار المسائل.",
            "اللهم غشني فيه بالرحمة، وارزقني فيه التوفيق والعصمة، وطهر قلبي من غياهب التهمة.",
            "اللهم اجعل صيامي فيه بالشكر والقبول على ما ترضاه ويرضاه الرسول."
        ];

        // --- Logic ---
        function init() {
            // Determine current Ramadan day (Simplified: based on date or user setting)
            // For now, let's assume Day 1 or load from storage
            currentDayIndex = parseInt(localStorage.getItem('ramadan_current_day') || "0");
            renderDua();
            renderChecklist();

            // Location & Times
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(fetchTimes, error => {
                    document.getElementById('loading').innerText = "يرجى تفعيل الموقع";
                });
            } else {
                document.getElementById('loading').innerText = "المتصفح غير مدعوم";
            }
        }

        // --- Checklist Logic ---
        function getTodayKey() {
            const d = new Date();
            return `ramadan_check_${d.getDate()}_${d.getMonth()}`;
        }

        function renderChecklist() {
            const key = getTodayKey();
            const data = JSON.parse(localStorage.getItem(key) || '{}');

            ['fasting', 'taraweeh', 'quran', 'charity'].forEach(task => {
                const el = document.getElementById('check-' + task);
                const row = el.parentElement;
                if (data[task]) {
                    row.classList.add('checked');
                    el.innerText = '✓';
                } else {
                    row.classList.remove('checked');
                    el.innerText = '';
                }
            });
        }

        function toggleTask(task) {
            const key = getTodayKey();
            const data = JSON.parse(localStorage.getItem(key) || '{}');

            data[task] = !data[task];
            localStorage.setItem(key, JSON.stringify(data));

            renderChecklist();
        }

        // --- Dua Logic ---
        function renderDua() {
            document.getElementById('dua-day-num').innerText = "دعاء اليوم " + (currentDayIndex + 1);
            document.getElementById('dua-text').innerText = duas[currentDayIndex % duas.length];
        }

        function changeDua(dir) {
            currentDayIndex += dir;
            if (currentDayIndex < 0) currentDayIndex = 29;
            if (currentDayIndex > 29) currentDayIndex = 0;
            renderDua();
        }

        // --- Timer Logic (Reused & Simplified) ---
        async function fetchTimes(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            // Reusing same API logic as before...
            try {
                const today = new Date();
                const d1 = today.getDate() + '-' + (today.getMonth() + 1) + '-' + today.getFullYear();
                const tomorrow = new Date(today); tomorrow.setDate(tomorrow.getDate() + 1);
                const d2 = tomorrow.getDate() + '-' + (tomorrow.getMonth() + 1) + '-' + tomorrow.getFullYear();

                const url = `https://api.aladhan.com/v1/timings/${d1}?latitude=${lat}&longitude=${lng}&method=5`;
                const url2 = `https://api.aladhan.com/v1/timings/${d2}?latitude=${lat}&longitude=${lng}&method=5`;

                const [res1, res2] = await Promise.all([fetch(url), fetch(url2)]);
                const data1 = await res1.json();
                const data2 = await res2.json();

                if (data1.code === 200 && data2.code === 200) {
                    const t1 = data1.data.timings;
                    const t2 = data2.data.timings;

                    document.getElementById('hijri-date').innerText = data1.data.date.hijri.date;

                    // Parse
                    maghribToday = parseTime(d1, t1.Maghrib);
                    fajrToday = parseTime(d1, t1.Fajr);
                    fajrTomorrow = parseTime(d2, t2.Fajr);

                    startTimer();
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('content').style.display = 'block';
                }
            } catch (e) { console.error(e); }
        }

        function parseTime(dateStr, timeStr) {
            const [d, m, y] = dateStr.split('-');
            const [h, min] = timeStr.split(':');
            return new Date(y, m - 1, d, h, min, 0);
        }

        function startTimer() {
            setInterval(updateTimer, 1000);
            updateTimer();
        }

        function updateTimer() {
            const now = new Date();
            let target, mode;

            if (now < fajrToday) { target = fajrToday; mode = "suhoor"; }
            else if (now < maghribToday) { target = maghribToday; mode = "iftar"; }
            else { target = fajrTomorrow; mode = "suhoor"; }

            const diff = target - now;
            const labelEl = document.getElementById('timer-label');
            const eventEl = document.getElementById('next-event-name');

            if (mode === 'iftar') {
                labelEl.innerText = "المتبقي على الإفطار";
                eventEl.innerText = "المغرب: " + formatTime(target);
            } else {
                labelEl.innerText = "المتبقي على الإمساك";
                eventEl.innerText = "الفجر: " + formatTime(target);
            }

            if (diff > 0) {
                const h = Math.floor(diff / (1000 * 60 * 60));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);
                document.getElementById('timer').innerText =
                    `${h < 10 ? '0' + h : h}:${m < 10 ? '0' + m : m}:${s < 10 ? '0' + s : s}`;
            }
        }

        function formatTime(d) {
            let h = d.getHours(), m = d.getMinutes();
            const ampm = h >= 12 ? 'م' : 'ص';
            h = h % 12; h = h ? h : 12;
            return `${h}:${m < 10 ? '0' + m : m} ${ampm}`;
        }

        init();
    </script>
</body>

</html>