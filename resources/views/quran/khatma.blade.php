<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ختمة القرآن | تطبيق الصلاة</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e293b">

    <style>
        :root {
            --primary: #1e293b;
            --secondary: #334155;
            --accent: #10b981;
            --gold: #fbbf24;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --card-bg: rgba(30, 41, 59, 0.7);
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
        }

        .container {
            width: 100%;
            max-width: 600px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
        }

        /* ----- Setup View ----- */
        .setup-option {
            margin-bottom: 20px;
        }

        .setup-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .setup-input,
        .setup-select {
            width: 100%;
            padding: 12px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--secondary);
            border-radius: 10px;
            color: var(--text-light);
            font-family: inherit;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .btn-primary {
            background: var(--accent);
            color: #0f172a;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            font-size: 1rem;
            font-family: inherit;
            width: 100%;
            transition: transform 0.2s;
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        /* ----- Dashboard View ----- */
        .progress-circle-container {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto 30px;
        }

        .progress-svg {
            transform: rotate(-90deg);
            width: 100%;
            height: 100%;
        }

        .progress-meter {
            fill: none;
            stroke: var(--secondary);
            stroke-width: 10;
        }

        .progress-value {
            fill: none;
            stroke: var(--accent);
            stroke-width: 10;
            stroke-linecap: round;
            stroke-dasharray: 565;
            /* 2 * PI * 90 */
            stroke-dashoffset: 565;
            transition: stroke-dashoffset 1s ease-in-out;
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .progress-text .percent {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-light);
            line-height: 1;
        }

        .progress-text .label {
            font-size: 0.9rem;
            color: var(--text-dim);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 12px;
            text-align: center;
        }

        .stat-val {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gold);
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-dim);
        }

        .input-group {
            display: flex;
            gap: 10px;
            align-items: center;
            background: rgba(0, 0, 0, 0.2);
            padding: 10px;
            border-radius: 12px;
        }

        .page-input {
            flex-grow: 1;
            background: transparent;
            border: none;
            color: var(--text-light);
            font-size: 1.2rem;
            text-align: center;
            font-weight: 700;
            width: 60px;
        }

        .page-input:focus {
            outline: none;
        }

        .btn-update {
            background: var(--accent);
            color: #0f172a;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
        }

        .back-link {
            align-self: flex-start;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.2rem;
            margin-bottom: 10px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gold);
            color: #0f172a;
            padding: 12px 25px;
            border-radius: 30px;
            font-weight: 700;
            z-index: 1000;
            display: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>

    <div class="container">
        <a href="/quran" class="back-link">&rarr; عودة للقرآن</a>

        <div class="header">
            <h1>ختمة القرآن 🌙</h1>
            <p id="header-desc" style="color:var(--text-dim)">تابع تقدمك في قراءة القرآن الكريم</p>
        </div>

        <!-- VIEW: SETUP -->
        <div id="view-setup" class="card" style="display:none;">
            <h2 style="margin-top:0;">ابدأ ختمة جديدة</h2>

            <div class="setup-option">
                <label class="setup-label">نوع الهدف</label>
                <select id="goal-type" class="setup-select" onchange="toggleGoalInputs()">
                    <option value="date">تحديد تاريخ الانتهاء</option>
                    <option value="daily">تحديد عدد صفحات يومي</option>
                </select>
            </div>

            <div class="setup-option" id="input-date-group">
                <label class="setup-label">تاريخ الانتهاء</label>
                <input type="date" id="target-date" class="setup-input">
                <p style="font-size:0.8rem; color:var(--text-dim); margin-top:5px;">مثلاً: نهاية رمضان، أو بعد 30 يوم
                </p>
            </div>

            <div class="setup-option" id="input-daily-group" style="display:none;">
                <label class="setup-label">عدد الصفحات يومياً</label>
                <input type="number" id="daily-pages" class="setup-input" placeholder="20" min="1" max="604">
            </div>

            <div class="setup-option">
                <label class="setup-label">الصفحة الحالية (إذا بدأت بالفعل)</label>
                <input type="number" id="start-page" class="setup-input" value="0" min="0" max="604">
            </div>

            <button class="btn-primary" onclick="createPlan()">إنشاء الخطة</button>
        </div>

        <!-- VIEW: DASHBOARD -->
        <div id="view-dashboard" class="card" style="display:none;">

            <div class="progress-circle-container">
                <svg class="progress-svg" viewBox="0 0 200 200">
                    <circle class="progress-meter" cx="100" cy="100" r="90"></circle>
                    <circle class="progress-value" id="progress-ring" cx="100" cy="100" r="90"></circle>
                </svg>
                <div class="progress-text">
                    <div class="percent" id="pct-display">0%</div>
                    <div class="label" id="page-display">صفحة 0 / 604</div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-val" id="daily-target">--</div>
                    <div class="stat-label">المطلوب اليوم</div>
                </div>
                <div class="stat-card">
                    <div class="stat-val" id="days-left">--</div>
                    <div class="stat-label">أيام متبقية</div>
                </div>
            </div>

            <h3 style="margin-bottom:15px;">تسجيل القراءة</h3>
            <div class="input-group">
                <span style="color:var(--text-dim);">وصلت لصفحة:</span>
                <input type="number" id="current-page-input" class="page-input" min="0" max="604">
                <button class="btn-update" onclick="updateProgress()">حفظ</button>
            </div>

            <div style="margin-top:30px; text-align:center;">
                <button onclick="resetPlan()"
                    style="background:transparent; border:none; color:var(--wrong, #ef4444); cursor:pointer;">إلغاء
                    الختمة / بدء جديد</button>
            </div>
        </div>

    </div>

    <div id="toast" class="toast">تم الحفظ بنجاح! ✅</div>

    <script>
        const TOTAL_PAGES = 604;

        function init() {
            const data = localStorage.getItem('khatma_data');
            if (data) {
                showDashboard(JSON.parse(data));
            } else {
                showSetup();
            }
        }

        function showSetup() {
            document.getElementById('view-setup').style.display = 'block';
            document.getElementById('view-dashboard').style.display = 'none';

            // Set default date to 30 days from now
            const d = new Date();
            d.setDate(d.getDate() + 30);
            document.getElementById('target-date').valueAsDate = d;
        }

        function toggleGoalInputs() {
            const type = document.getElementById('goal-type').value;
            if (type === 'date') {
                document.getElementById('input-date-group').style.display = 'block';
                document.getElementById('input-daily-group').style.display = 'none';
            } else {
                document.getElementById('input-date-group').style.display = 'none';
                document.getElementById('input-daily-group').style.display = 'block';
            }
        }

        function createPlan() {
            const type = document.getElementById('goal-type').value;
            const startPage = parseInt(document.getElementById('start-page').value) || 0;

            let plan = {
                startDate: new Date().toISOString(),
                currentPage: startPage,
                goalType: type
            };

            if (type === 'date') {
                const dateVal = document.getElementById('target-date').value;
                if (!dateVal) return alert('يرجى تحديد التاريخ');
                plan.targetDate = new Date(dateVal).toISOString();
            } else {
                const daily = parseInt(document.getElementById('daily-pages').value);
                if (!daily) return alert('يرجى تحديد عدد الصفحات');
                plan.dailyPages = daily;
            }

            localStorage.setItem('khatma_data', JSON.stringify(plan));
            showDashboard(plan);
        }

        function showDashboard(plan) {
            document.getElementById('view-setup').style.display = 'none';
            document.getElementById('view-dashboard').style.display = 'block';

            renderStats(plan);
        }

        function renderStats(plan) {
            const current = plan.currentPage;
            const pct = Math.round((current / TOTAL_PAGES) * 100);

            // Update Circle
            const ring = document.getElementById('progress-ring');
            const circumference = 2 * Math.PI * 90; // approx 565
            const offset = circumference - (pct / 100) * circumference;

            ring.style.strokeDasharray = `${circumference} ${circumference}`;
            ring.style.strokeDashoffset = offset;

            document.getElementById('pct-display').innerText = pct + '%';
            document.getElementById('page-display').innerText = `صفحة ${current} / ${TOTAL_PAGES}`;
            document.getElementById('current-page-input').value = current;

            // Calculate Stats
            let todayTarget = 0;
            let daysLeft = 0;

            if (plan.goalType === 'daily') {
                todayTarget = plan.dailyPages;
                const remainingPages = TOTAL_PAGES - current;
                daysLeft = Math.ceil(remainingPages / plan.dailyPages);
            } else {
                const targetDate = new Date(plan.targetDate);
                const today = new Date();
                const diffTime = Math.max(0, targetDate - today);
                daysLeft = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (daysLeft <= 0) {
                    todayTarget = "انتهى الوقت";
                } else {
                    const remainingPages = TOTAL_PAGES - current;
                    todayTarget = Math.ceil(remainingPages / daysLeft);
                }
            }

            document.getElementById('daily-target').innerText = todayTarget + (typeof todayTarget === 'number' ? ' صفحة' : '');
            document.getElementById('days-left').innerText = daysLeft + ' يوم';

            // Check Khatma Completion
            if (current >= TOTAL_PAGES) {
                // Award Badge
                unlockKhatmaBadge();
            }
        }

        function updateProgress() {
            const newVal = parseInt(document.getElementById('current-page-input').value);
            if (newVal < 0 || newVal > 604) return alert('رقم الصفحة غير صحيح');

            const plan = JSON.parse(localStorage.getItem('khatma_data'));
            plan.currentPage = newVal;
            plan.lastUpdate = new Date().toISOString();

            localStorage.setItem('khatma_data', JSON.stringify(plan));
            renderStats(plan);

            showToast();
        }

        function resetPlan() {
            if (confirm("هل أنت متأكد من حذف الختمة الحالية والبدء من جديد؟")) {
                localStorage.removeItem('khatma_data');
                location.reload();
            }
        }

        function showToast() {
            const t = document.getElementById('toast');
            t.style.display = 'block';
            setTimeout(() => t.style.display = 'none', 3000);
        }

        function unlockKhatmaBadge() {
            // Check if already unlocked
            const myBadges = JSON.parse(localStorage.getItem('my_badges') || '[]');
            if (!myBadges.includes('khatma_completed')) {
                myBadges.push('khatma_completed');
                localStorage.setItem('my_badges', JSON.stringify(myBadges));
                alert("🎉 مبروك! أتممت ختمة القرآن الكريم! تم فتح إنجاز جديد!");

                // Maybe redirect to tracker to see badge?
            }
        }

        init();
    </script>
</body>

</html>