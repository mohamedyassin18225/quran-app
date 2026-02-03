<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأذكار التفاعلية | تطبيق الصلاة</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e293b">
    <script src="/js/theme.js"></script>

    <style>
        :root {
            --primary: #1e293b;
            --secondary: #334155;
            --accent: #10b981;
            --accent-glow: rgba(16, 185, 129, 0.4);
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --card-bg: rgba(30, 41, 59, 0.6);
            --completed-bg: rgba(16, 185, 129, 0.15);
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            background-attachment: fixed;
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            margin: 0;
            padding: 20px;
            text-align: right;
            user-select: none;
            -webkit-user-select: none;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin-bottom: 50px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .back-btn {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            text-decoration: none;
            font-size: 1.2rem;
        }

        .header h1 {
            margin: 0;
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--accent);
        }

        /* Tabs */
        .tabs-container {
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 10px;
            margin-bottom: 20px;
            scrollbar-width: none;
        }

        .tabs-container::-webkit-scrollbar {
            display: none;
        }

        .tabs {
            display: inline-flex;
            gap: 10px;
        }

        .tab-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-dim);
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-family: inherit;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .tab-btn.active {
            background: var(--accent);
            color: #0f172a;
            font-weight: 700;
            border-color: var(--accent);
        }

        /* Progress Bar */
        .progress-container {
            background: rgba(255, 255, 255, 0.1);
            height: 6px;
            border-radius: 3px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: var(--accent);
            width: 0%;
            transition: width 0.3s;
        }

        .progress-text {
            text-align: center;
            font-size: 0.8rem;
            color: var(--text-dim);
            margin-bottom: 10px;
            margin-top: -15px;
        }

        /* Cards */
        .athkar-list {
            display: none;
        }

        .athkar-list.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .thikr-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .thikr-card:active {
            transform: scale(0.98);
        }

        .thikr-card.completed {
            background: var(--completed-bg);
            border-color: var(--accent);
            opacity: 0.8;
            order: 999;
            /* Move to bottom if flex? Need JS sort or just visual */
        }

        .thikr-content {
            position: relative;
            z-index: 2;
        }

        .arabic-text {
            font-family: 'Amiri', serif;
            font-size: 1.5rem;
            line-height: 2.2;
            color: #fff;
            margin-bottom: 15px;
        }

        .meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            color: var(--accent);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 15px;
        }

        /* Circular Counter */
        .counter-ring {
            position: relative;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ring-svg {
            transform: rotate(-90deg);
            width: 100%;
            height: 100%;
        }

        .ring-bg {
            fill: none;
            stroke: rgba(255, 255, 255, 0.1);
            stroke-width: 4;
        }

        .ring-progress {
            fill: none;
            stroke: var(--accent);
            stroke-width: 4;
            stroke-linecap: round;
            transition: stroke-dashoffset 0.3s;
        }

        .count-text {
            position: absolute;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-light);
        }

        .thikr-card.completed .ring-progress {
            stroke: var(--text-light);
        }

        .thikr-card.completed .count-text {
            content: "✓";
        }

        /* Ripple Effect */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <a href="/" class="back-btn">&rarr; الرئيسية</a>
            <h1>الأذكار</h1>
        </div>

        <div class="tabs-container">
            <div class="tabs">
                <button class="tab-btn active" onclick="switchTab('morning')">أذكار الصباح ☀️</button>
                <button class="tab-btn" onclick="switchTab('evening')">أذكار المساء 🌙</button>
                <button class="tab-btn" onclick="switchTab('prayer')">بعد الصلاة 🕌</button>
                <button class="tab-btn" onclick="switchTab('sleep')">النوم 💤</button>
            </div>
        </div>

        <div class="progress-text" id="prog-text">0% مكتمل</div>
        <div class="progress-container">
            <div class="progress-bar" id="global-prog"></div>
        </div>

        <!-- Morning -->
        <div id="morning" class="athkar-list active">
            <!-- Items injected via JS for cleaner logic -->
        </div>

        <!-- Evening -->
        <div id="evening" class="athkar-list"></div>
        <div id="prayer" class="athkar-list"></div>
        <div id="sleep" class="athkar-list"></div>

    </div>

    <script>
        // Data Structure
        const athkarData = {
            morning: [
                { text: "أَصْبَحْنَا وَأَصْبَحَ الْمُلْكُ لِلَّهِ، وَالْحَمْدُ لِلَّهِ، لاَ إِلَـهَ إِلاَّ اللهُ وَحْدَهُ لاَ شَرِيكَ لَهُ...", count: 1, source: "مسلم" },
                { text: "اللَّهُمَّ بِكَ أَصْبَحْنَا وَبِكَ أَمْسَيْنَا ، وَبِكَ نَحْيَا وَبِكَ نَمُوتُ وَإِلَيْكَ النُّشُورُ", count: 1, source: "الترمذي" },
                { text: "اللَّهُ لَا إِلَٰهَ إِلَّا هُوَ الْحَيُّ الْقَيُّومُ... (آية الكرسي)", count: 1, source: "القرآن الكريم" },
                { text: "سُبْحَانَ اللَّهِ وَبِحَمْدِهِ", count: 100, source: "متفق عليه" },
                { text: "أَسْتَغْفِرُ اللَّهَ وَأَتُوبُ إِلَيْهِ", count: 100, source: "متفق عليه" },
                { text: "بِسْمِ اللهِ الَّذِي لَا يَضُرُّ مَعَ اسْمِهِ شَيْءٌ...", count: 3, source: "أبو داود" },
                { text: "رَضِيتُ بِاللَّهِ رَبًّا، وَبِالْإِسْلَامِ دِينًا، وَبِمُحَمَّدٍ نَبِيًّا", count: 3, source: "أبو داود" }
            ],
            evening: [
                { text: "أَمْسَيْنَا وَأَمْسَى الْمُلْكُ لِلَّهِ...", count: 1, source: "مسلم" },
                { text: "اللَّهُمَّ بِكَ أَمْسَيْنَا وَبِكَ أَصْبَحْنَا...", count: 1, source: "الترمذي" },
                { text: "أَعُوذُ بِكَلِمَاتِ اللهِ التَّامَّاتِ مِنْ شَرِّ مَا خَلَقَ", count: 3, source: "مسلم" },
                { text: "سُبْحَانَ اللَّهِ وَبِحَمْدِهِ", count: 100, source: "مسلم" }
            ],
            prayer: [
                { text: "أَسْتَغْفِرُ اللَّهَ (3 مرات) اللَّهُمَّ أَنْتَ السَّلَامُ وَمِنْكَ السَّلَامُ...", count: 1, source: "مسلم" },
                { text: "سُبْحَانَ اللَّهِ", count: 33, source: "مسلم" },
                { text: "الْحَمْدُ لِلَّهِ", count: 33, source: "مسلم" },
                { text: "اللَّهُ أَكْبَرُ", count: 33, source: "مسلم" },
                { text: "لاَ إِلَـهَ إِلاَّ اللهُ وَحْدَهُ لاَ شَرِيكَ لَهُ...", count: 1, source: "مسلم" }
            ],
            sleep: [
                { text: "بِاسْمِكَ رَبِّـي وَضَعْـتُ جَنْـبي ، وَبِكَ أَرْفَعُـه...", count: 1, source: "متفق عليه" },
                { text: "اللَّهُمَّ أَسْلَمْتُ نَفْسِي إِلَيْكَ...", count: 1, source: "متفق عليه" },
                { text: "آية الكرسي", count: 1, source: "البخاري" }
            ]
        };

        // State
        let activeTab = 'morning';
        let progressState = JSON.parse(localStorage.getItem('athkar_progress') || '{}');

        // Init
        function init() {
            renderList('morning');
            renderList('evening');
            renderList('prayer');
            renderList('sleep');

            // Check day reset
            const lastDate = localStorage.getItem('athkar_last_date');
            const today = new Date().toDateString();
            if (lastDate !== today) {
                // Reset progress daily
                progressState = {};
                localStorage.setItem('athkar_last_date', today);
                saveState();
            }

            switchTab('morning');
        }

        function renderList(category) {
            const list = document.getElementById(category);
            list.innerHTML = '';

            const items = athkarData[category];
            items.forEach((item, index) => {
                const key = `${category}_${index}`;
                const current = progressState[key] || 0;
                const isDone = current >= item.count;

                const card = document.createElement('div');
                card.className = `thikr-card ${isDone ? 'completed' : ''}`;
                card.onclick = (e) => handleClick(e, category, index, item.count);

                // SVG Calculation
                const r = 20;
                const c = 2 * Math.PI * r;
                const pct = Math.min(current / item.count, 1);
                const offset = c - (pct * c);

                card.innerHTML = `
                    <div class="thikr-content">
                        <div class="arabic-text">${item.text}</div>
                        <div class="meta">
                            <span>${item.source}</span>
                            <div class="counter-ring">
                                <svg class="ring-svg">
                                    <circle class="ring-bg" cx="25" cy="25" r="${r}"></circle>
                                    <circle class="ring-progress" cx="25" cy="25" r="${r}" 
                                            style="stroke-dasharray:${c}; stroke-dashoffset:${offset}" 
                                            id="ring-${key}"></circle>
                                </svg>
                                <span class="count-text" id="text-${key}">
                                    ${isDone ? '✓' : (item.count - current)}
                                </span>
                            </div>
                        </div>
                    </div>
                `;
                list.appendChild(card);
            });
            updateGlobalProgress(category);
        }

        function handleClick(e, cat, idx, target) {
            const key = `${cat}_${idx}`;
            let current = progressState[key] || 0;

            if (current >= target) return; // Already Done

            // Ripple
            const card = e.currentTarget;
            const circle = document.createElement('span');
            const diameter = Math.max(card.clientWidth, card.clientHeight);
            const radius = diameter / 2;
            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${e.clientX - card.getBoundingClientRect().left - radius}px`;
            circle.style.top = `${e.clientY - card.getBoundingClientRect().top - radius}px`;
            circle.classList.add('ripple');
            const ripple = card.getElementsByClassName('ripple')[0];
            if (ripple) ripple.remove();
            card.appendChild(circle);

            // Logic
            current++;
            progressState[key] = current;
            saveState();

            // Update UI
            const r = 20;
            const c = 2 * Math.PI * r;
            const pct = Math.min(current / target, 1);
            const offset = c - (pct * c);

            document.getElementById(`ring-${key}`).style.strokeDashoffset = offset;

            if (current >= target) {
                card.classList.add('completed');
                document.getElementById(`text-${key}`).innerText = '✓';
                if (navigator.vibrate) navigator.vibrate(100);
            } else {
                document.getElementById(`text-${key}`).innerText = target - current;
                if (navigator.vibrate) navigator.vibrate(30);
            }

            updateGlobalProgress(cat);
        }

        function updateGlobalProgress(cat) {
            if (activeTab !== cat) return;

            const items = athkarData[cat];
            let totalNeeded = 0;
            let totalDone = 0;

            items.forEach((item, idx) => {
                totalNeeded += item.count;
                totalDone += (progressState[`${cat}_${idx}`] || 0);
            });

            const pct = Math.round((totalDone / totalNeeded) * 100);
            document.getElementById('global-prog').style.width = `${pct}%`;
            document.getElementById('prog-text').innerText = `${pct}% مكتمل`;
        }

        function switchTab(cat) {
            activeTab = cat;
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelector(`.tab-btn[onclick="switchTab('${cat}')"]`).classList.add('active');

            document.querySelectorAll('.athkar-list').forEach(l => l.classList.remove('active'));
            document.getElementById(cat).classList.add('active');

            updateGlobalProgress(cat);
        }

        function saveState() {
            localStorage.setItem('athkar_progress', JSON.stringify(progressState));
        }

        init();
    </script>
</body>

</html>