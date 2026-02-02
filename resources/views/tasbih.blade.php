<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المسبحة الإلكترونية | تطبيق الصلاة</title>
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
            --text-light: #f8fafc;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--primary);
            color: var(--text-light);
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            user-select: none;
            /* Prevent text selection on rapid tapping */
            -webkit-user-select: none;
        }

        .container {
            width: 90%;
            max-width: 400px;
        }

        .circle-container {
            width: 280px;
            height: 280px;
            border-radius: 50%;
            border: 8px solid var(--secondary);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            position: relative;
            background: rgba(30, 41, 59, 0.5);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            transition: transform 0.1s, border-color 0.3s;
        }

        .circle-container:active {
            transform: scale(0.95);
            border-color: var(--accent);
        }

        .count-display {
            font-size: 5rem;
            font-weight: 700;
            color: var(--accent);
            line-height: 1;
        }

        .label {
            font-size: 1.5rem;
            color: #94a3b8;
            margin-top: 10px;
            font-weight: 600;
        }

        .controls {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 30px;
        }

        button {
            background: var(--secondary);
            border: none;
            color: var(--text-light);
            padding: 12px 24px;
            border-radius: 12px;
            font-family: 'Cairo', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        button:hover {
            background: #475569;
        }

        button.reset {
            color: #ef4444;
        }

        .back-link {
            position: absolute;
            top: 20px;
            right: 20px;
            /* Swapped for RTL */
            left: auto;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
            padding: 10px;
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&rarr;</a>

    <div class="container">
        <h1 style="margin-bottom: 40px; font-weight: 600;">المسبحة الإلكترونية</h1>

        <div class="circle-container" id="tapArea">
            <div class="count-display" id="countDisplay">0</div>
            <div class="label">سبحان الله</div>
        </div>

        <div class="controls">
            <button onclick="resetCount()" class="reset">تصفير</button>
            <button onclick="changeDhikr()">تغيير الذكر</button>
        </div>
    </div>

    <script>
        let count = 0;
        let currentDhikrIndex = 0;
        const dhikrs = ["سبحان الله", "الحمد لله", "الله أكبر", "أستغفر الله", "لا إله إلا الله"];

        const countDisplay = document.getElementById('countDisplay');
        const tapArea = document.getElementById('tapArea');
        const label = document.querySelector('.label');

        // Load saved state
        if (localStorage.getItem('tasbihCount')) {
            count = parseInt(localStorage.getItem('tasbihCount'));
            countDisplay.innerText = count;
        }
        if (localStorage.getItem('tasbihDhikr')) {
            currentDhikrIndex = parseInt(localStorage.getItem('tasbihDhikr'));
            label.innerText = dhikrs[currentDhikrIndex];
        }

        tapArea.addEventListener('touchstart', function (e) {
            e.preventDefault(); // Verify this doesn't block scrolling if needed, but good for app feel
            increment();
        });

        tapArea.addEventListener('click', increment);

        function increment() {
            count++;
            countDisplay.innerText = count;
            localStorage.setItem('tasbihCount', count);

            // Haptic feedback if available (Mobile)
            if (navigator.vibrate) {
                navigator.vibrate(50); // Short vibration
            }
        }

        function resetCount() {
            if (confirm('هل تريد تصفير العداد؟')) {
                count = 0;
                countDisplay.innerText = count;
                localStorage.setItem('tasbihCount', count);
                if (navigator.vibrate) navigator.vibrate([50, 50, 50]);
            }
        }

        function changeDhikr() {
            currentDhikrIndex = (currentDhikrIndex + 1) % dhikrs.length;
            label.innerText = dhikrs[currentDhikrIndex];
            localStorage.setItem('tasbihDhikr', currentDhikrIndex);

            // Optional: Auto reset on change? No, keep it cumulative or let user decide.
        }
    </script>
</body>

</html>