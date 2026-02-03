<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سجل الصلوات | تطبيق الصلاة</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e293b">

    <style>
        :root {
            --primary: #1e293b;
            --secondary: #334155;
            --accent: #10b981;
            /* Emerald */
            --gold: #fbbf24;
            --danger: #ef4444;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --card-bg: rgba(30, 41, 59, 0.7);
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--primary);
            color: var(--text-light);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: rgba(30, 41, 59, 0.95);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header h1 {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
        }

        .back-link {
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .container {
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
            flex-grow: 1;
        }

        .card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .date-navigator {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .date-display {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .nav-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: var(--text-light);
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-family: inherit;
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .prayers-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .prayer-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .prayer-item.checked {
            background: rgba(16, 185, 129, 0.15);
            border-color: var(--accent);
        }

        .prayer-name {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .checkbox {
            width: 24px;
            height: 24px;
            border: 2px solid var(--text-dim);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .prayer-item.checked .checkbox {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        .chart-container {
            position: relative;
            height: 200px;
            width: 100%;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 10px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-val {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-dim);
        }

        /* ----- Badges Styles ----- */
        .badges-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .badge-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 10px;
            text-align: center;
            opacity: 0.5;
            filter: grayscale(100%);
            transition: all 0.3s;
            position: relative;
        }

        .badge-item.unlocked {
            opacity: 1;
            filter: grayscale(0%);
            border-color: var(--gold);
            background: rgba(251, 191, 36, 0.1);
            box-shadow: 0 0 15px rgba(251, 191, 36, 0.2);
        }

        .badge-icon {
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .badge-name {
            font-size: 0.7rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .streak-card {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #fff;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px;
            border: none;
        }

        .streak-count {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1;
        }

        .streak-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Toast */
        .badge-toast {
            position: fixed;
            top: 20px;
            /* Top for visibility */
            left: 50%;
            transform: translateX(-50%) translateY(-100px);
            background: var(--gold);
            color: #0f172a;
            padding: 15px 25px;
            border-radius: 50px;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            z-index: 2000;
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge-toast.show {
            transform: translateX(-50%) translateY(50px);
        }
    </style>
</head>

<body>

    <div class="header">
        <a href="/" class="back-link">&rarr;</a>
        <h1>سجل الصلوات</h1>
        <div style="width: 24px;"></div>
    </div>

    <div class="container">

        <!-- Streak Banner -->
        <div class="card streak-card">
            <div class="streak-icon">🔥</div>
            <div class="streak-count" id="currentStreak">0</div>
            <div class="streak-label">أيام متواصلة</div>
        </div>

        <!-- Date Navigation -->
        <div class="card">
            <div class="date-navigator">
                <button class="nav-btn" onclick="changeDate(-1)">&rarr;</button>
                <div class="date-display" id="dateDisplay">--/--/----</div>
                <button class="nav-btn" onclick="changeDate(1)">&larr;</button>
            </div>

            <div class="prayers-list" id="prayersList">
                <!-- Javascript will populate this -->
            </div>
        </div>

        <!-- Weekly Stats -->
        <div class="card">
            <h3>أداء الأسبوع</h3>
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-val" id="weeklyCount">0</div>
                    <div class="stat-label">صلاة مؤداة</div>
                </div>
                <div class="stat-item">
                    <div class="stat-val" id="weeklyPercent">0%</div>
                    <div class="stat-label">نسبة الالتزام</div>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>

        <!-- Badges Section -->
        <div class="card">
            <h3>الإنجازات 🏆</h3>
            <div class="badges-grid" id="badgesGrid">
                <!-- Injected via JS -->
            </div>
        </div>

    </div>

    <div id="badgeToast" class="badge-toast">
        <span style="font-size:1.5rem;">🏆</span>
        <span>تم فتح إنجاز جديد!</span>
    </div>

    <script>
        // --- State ---
        let currentDate = new Date();
        const prayers = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
        const prayerNames = {
            'Fajr': 'الفجر',
            'Dhuhr': 'الظهر',
            'Asr': 'العصر',
            'Maghrib': 'المغرب',
            'Isha': 'العشاء'
        };

        // --- Badges Config ---
        const badgesConfig = [
            { id: 'first_step', name: 'البداية', icon: '🌱', desc: 'سجل أول صلاة لك' },
            { id: 'streak_3', name: 'استمرار 3', icon: '🔥', desc: 'حافظ على الصلاة 3 أيام متتالية' },
            { id: 'streak_7', name: 'أسبوع كامل', icon: '🗓️', desc: 'حافظ على الصلاة أسبوع كامل' },
            { id: 'streak_30', name: 'شهر الالتزام', icon: '🌙', desc: '30 يوماً من الالتزام' },
            { id: 'fajr_lover', name: 'محب الفجر', icon: '🌅', desc: 'صل الفجر 3 أيام متتالية' },
            { id: 'perfect_day', name: 'يوم مثالي', icon: '⭐', desc: 'أتممت الصلوات الخمس في يوم واحد' },
            { id: 'perfect_week', name: 'أسبوع مثالي', icon: '👑', desc: 'أتممت الصلوات الخمس لمدة أسبوع' },
            // Quiz Badges
            { id: 'quiz_starter', name: 'طالب علم', icon: '📚', desc: 'أكمل أول اختبار لك' },
            { id: 'quran_master', name: 'حافظ القرآن', icon: '📖', desc: 'حصلت على 100% في اختبار القرآن' },
            { id: 'seerah_expert', name: 'عالم السيرة', icon: '🕌', desc: 'حصلت على 100% في اختبار السيرة' },
            { id: 'quiz_champion', name: 'بطل المسابقات', icon: '🏆', desc: 'أكملت 5 اختبارات بنجاح' },
            // Khatma Badges
            { id: 'khatma_completed', name: 'ختمة كاملة', icon: '✨', desc: 'أتممت قراءة القرآن الكريم كاملاً' }
        ];

        // --- Init ---
        let chartInstance = null;

        function init() {
            renderDate();
            renderPrayers();
            updateStats();
            calculateStreak();
            renderBadges();
        }

        // --- Date Logic ---
        function changeDate(days) {
            currentDate.setDate(currentDate.getDate() + days);
            renderDate();
            renderPrayers();
        }

        function renderDate() {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('dateDisplay').innerText = currentDate.toLocaleDateString('ar-EG', options);
        }

        function getStorageKey(date) {
            const offset = date.getTimezoneOffset();
            const localDate = new Date(date.getTime() - (offset * 60 * 1000));
            return localDate.toISOString().split('T')[0];
        }

        // --- Prayer Check Logic ---
        function renderPrayers() {
            const list = document.getElementById('prayersList');
            list.innerHTML = '';

            const dateKey = getStorageKey(currentDate);
            const data = JSON.parse(localStorage.getItem('tracker_' + dateKey) || '{}');

            prayers.forEach(p => {
                const isChecked = !!data[p];
                const div = document.createElement('div');
                div.className = `prayer-item ${isChecked ? 'checked' : ''}`;
                div.onclick = () => togglePrayer(p);
                div.innerHTML = `
                    <div class="prayer-name">${prayerNames[p]}</div>
                    <div class="checkbox">${isChecked ? '✓' : ''}</div>
                `;
                list.appendChild(div);
            });
        }

        function togglePrayer(prayerName) {
            const dateKey = getStorageKey(currentDate);
            const data = JSON.parse(localStorage.getItem('tracker_' + dateKey) || '{}');

            if (data[prayerName]) {
                delete data[prayerName];
            } else {
                data[prayerName] = true;
            }

            localStorage.setItem('tracker_' + dateKey, JSON.stringify(data));
            renderPrayers();
            updateStats();

            // Check Achievements
            checkAchievements(dateKey, data);
            calculateStreak(); // Re-calc streak
        }

        // --- Stats & Streak Logic ---
        function updateStats() {
            const labels = [];
            const dataPoints = [];
            let totalPrayers = 0;

            for (let i = 6; i >= 0; i--) {
                const d = new Date(); // Always relative to TODAY for charts? Or relative to CurrentViewDate? Usually Today.
                // Let's make chart static for "Last 7 Days" relative to REAL today
                d.setDate(d.getDate() - i);
                const key = getStorageKey(d);
                const dayData = JSON.parse(localStorage.getItem('tracker_' + key) || '{}');
                const count = Object.keys(dayData).length;

                labels.push(d.toLocaleDateString('ar-EG', { weekday: 'short' }));
                dataPoints.push(count);
                totalPrayers += count;
            }

            document.getElementById('weeklyCount').innerText = totalPrayers;
            const percent = Math.round((totalPrayers / (7 * 5)) * 100);
            document.getElementById('weeklyPercent').innerText = percent + "%";

            renderChart(labels, dataPoints);
        }

        function calculateStreak() {
            // Count backwards from today
            let streak = 0;
            const today = new Date();

            // Allow streak to continue if today has 0 prayers BUT yesterday had prayers
            // Actually, streak is "consecutive days with at least 1 prayer" (or all 5? Let's say at least 1 for "Consistency Streak")

            for (let i = 0; i < 365; i++) {
                const d = new Date(today);
                d.setDate(d.getDate() - i);
                const key = getStorageKey(d);
                const dayData = JSON.parse(localStorage.getItem('tracker_' + key) || '{}');

                if (Object.keys(dayData).length > 0) {
                    streak++;
                } else if (i === 0) {
                    // If today is empty, don't break streak yet (maybe they just woke up), check yesterday
                    continue;
                } else {
                    break;
                }
            }

            // Display streak
            // Use Math.max streak or just current? Current logic calculates current streak.
            // Adjust: if today has 0, streak should be based on yesterday.
            // The loop above counts Today as 1 if filled. If Today 0, it skips.
            // So if T=0, Y=1, Y-1=1 -> Streak 2. Correct.

            document.getElementById('currentStreak').innerText = streak;
            return streak;
        }

        function renderChart(labels, data) {
            const ctx = document.getElementById('weeklyChart').getContext('2d');
            if (chartInstance) chartInstance.destroy();
            chartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'الصلوات',
                        data: data,
                        backgroundColor: '#10b981',
                        borderRadius: 5,
                        barThickness: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, max: 5, ticks: { color: '#94a3b8', stepSize: 1 }, grid: { color: 'rgba(255,255,255,0.05)' } },
                        x: { ticks: { color: '#94a3b8' }, grid: { display: false } }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }

        // --- Badges Logic ---
        function getMyBadges() {
            return JSON.parse(localStorage.getItem('my_badges') || '[]');
        }

        function unlockBadge(badgeId) {
            const myBadges = getMyBadges();
            if (!myBadges.includes(badgeId)) {
                myBadges.push(badgeId);
                localStorage.setItem('my_badges', JSON.stringify(myBadges));

                // Show notification
                const badge = badgesConfig.find(b => b.id === badgeId);
                showBadgeToast("🏆 إنجاز جديد: " + badge.name);

                renderBadges(); // Refresh UI
            }
        }

        function showBadgeToast(msg) {
            const toast = document.getElementById('badgeToast');
            toast.children[1].innerText = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 4000);
        }

        function renderBadges() {
            const grid = document.getElementById('badgesGrid');
            grid.innerHTML = '';
            const myBadges = getMyBadges();

            badgesConfig.forEach(b => {
                const unlocked = myBadges.includes(b.id);
                const el = document.createElement('div');
                el.className = `badge-item ${unlocked ? 'unlocked' : ''}`;
                el.title = b.desc; // Tooltip
                el.innerHTML = `
                    <div class="badge-icon">${b.icon}</div>
                    <div class="badge-name">${b.name}</div>
                `;
                grid.appendChild(el);
            });
        }

        function checkAchievements(dateKey, data) {
            const count = Object.keys(data).length;
            const streak = calculateStreak(); // Get current streak

            // 1. First Step
            if (count >= 1) unlockBadge('first_step');

            // 2. Streaks
            if (streak >= 3) unlockBadge('streak_3');
            if (streak >= 7) unlockBadge('streak_7');
            if (streak >= 30) unlockBadge('streak_30');

            // 3. Perfect Day
            if (count === 5) unlockBadge('perfect_day');

            // 4. Fajr Lover (Check last 3 days for Fajr)
            // Complex check, maybe skip for MVP or implement simple logic
            // Let's implement simple Fajr streak
            let fajrStreak = 0;
            for (let i = 0; i < 3; i++) {
                const d = new Date();
                d.setDate(d.getDate() - i);
                const k = getStorageKey(d);
                const dData = JSON.parse(localStorage.getItem('tracker_' + k) || '{}');
                if (dData['Fajr']) fajrStreak++;
                else break;
            }
            if (fajrStreak >= 3) unlockBadge('fajr_lover');
        }

        init();

    </script>
</body>

</html>