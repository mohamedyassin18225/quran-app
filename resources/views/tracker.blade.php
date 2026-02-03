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
    </style>
</head>

<body>

    <div class="header">
        <a href="/" class="back-link">&rarr;</a>
        <h1>سجل الصلوات</h1>
        <div style="width: 24px;"></div>
    </div>

    <div class="container">

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

        // --- Init ---
        let chartInstance = null;

        function init() {
            renderDate();
            renderPrayers();
            updateStats();
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
            // format YYYY-MM-DD
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
                    <div class="checkbox">
                        ${isChecked ? '✓' : ''}
                    </div>
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
        }

        // --- Chart & Stats Logic ---
        function updateStats() {
            // Get last 7 days including today
            const labels = [];
            const dataPoints = [];
            let totalPrayers = 0;

            for (let i = 6; i >= 0; i--) {
                const d = new Date(currentDate);
                d.setDate(d.getDate() - i);
                const key = getStorageKey(d);
                const dayData = JSON.parse(localStorage.getItem('tracker_' + key) || '{}');
                const count = Object.keys(dayData).length;

                // Label: day name (AR)
                labels.push(d.toLocaleDateString('ar-EG', { weekday: 'short' }));
                dataPoints.push(count);

                totalPrayers += count;
            }

            document.getElementById('weeklyCount').innerText = totalPrayers;
            const percent = Math.round((totalPrayers / (7 * 5)) * 100);
            document.getElementById('weeklyPercent').innerText = percent + "%";

            renderChart(labels, dataPoints);
        }

        function renderChart(labels, data) {
            const ctx = document.getElementById('weeklyChart').getContext('2d');

            if (chartInstance) {
                chartInstance.destroy();
            }

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
                        y: {
                            beginAtZero: true,
                            max: 5,
                            ticks: { color: '#94a3b8', stepSize: 1 },
                            grid: { color: 'rgba(255,255,255,0.05)' }
                        },
                        x: {
                            ticks: { color: '#94a3b8' },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // Run
        init();

    </script>
</body>

</html>