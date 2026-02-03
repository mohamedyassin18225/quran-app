<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الإعدادات | تطبيق الصلاة</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e293b">
    <script src="/js/theme.js"></script>

    <style>
        :root {
            --primary: #1e293b;
            --secondary: #334155;
            --accent: #10b981;
            --accent-glow: rgba(16, 185, 129, 0.3);
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --glass-bg: rgba(30, 41, 59, 0.7);
            --border-light: rgba(255, 255, 255, 0.05);
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            color: var(--text-light);
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            text-align: right;
            background-attachment: fixed;
        }

        .container {
            width: 100%;
            max-width: 500px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .header h1 {
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
            color: var(--accent);
            text-shadow: 0 0 20px var(--accent-glow);
        }

        .back-link {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            text-decoration: none;
            font-size: 1.2rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--accent);
        }

        .section {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            border: 1px solid var(--border-light);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--accent);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--text-light);
            font-size: 0.95rem;
        }

        select {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #475569;
            background: #0f172a;
            color: white;
            font-family: inherit;
            font-size: 0.95rem;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: left 1rem center;
            cursor: pointer;
            transition: all 0.2s;
        }

        select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.1);
        }

        .info-text {
            margin-top: 10px;
            font-size: 0.8rem;
            color: var(--text-dim);
            line-height: 1.5;
            background: rgba(0, 0, 0, 0.2);
            padding: 10px;
            border-radius: 8px;
        }

        .btn-save {
            background: linear-gradient(135deg, var(--accent), #059669);
            color: #ffffff;
            border: none;
            padding: 16px;
            border-radius: 15px;
            width: 100%;
            font-weight: 700;
            font-size: 1.1rem;
            margin-top: 10px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 15px var(--accent-glow);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--accent-glow);
        }

        .btn-save:active {
            transform: translateY(0);
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <a href="/" class="back-link">&rarr; الرئيسية</a>
            <h1>الإعدادات</h1>
        </div>

        <div class="section">
            <div class="section-title">
                <span>🕌</span> طريقة الحساب
            </div>

            <div class="form-group">
                <label for="method">الجهة المعتمدة للمواقيت</label>
                <select id="method">
                    <option value="5">الهيئة المصرية العامة للمساحة</option>
                    <option value="4">جامعة أم القرى، مكة المكرمة</option>
                    <option value="3">رابطة العالم الإسلامي</option>
                    <option value="2">ISNA (أمريكا الشمالية)</option>
                    <option value="1">جامعة العلوم الإسلامية، كراتشي</option>
                    <option value="8">منطقة الخليج</option>
                    <option value="9">الكويت</option>
                    <option value="10">قطر</option>
                    <option value="11">سنغافورة</option>
                    <option value="13">تركيا</option>
                </select>
                <div class="info-text">
                    يؤثر هذا الخيار على موعدي أذان الفجر والعشاء.
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">
                <span>🎨</span> المظهر والتاريخ
            </div>

            <div class="form-group">
                <label for="theme">لون التطبيق الأساسي</label>
                <select id="theme">
                    <option value="default">الليلي (الافتراضي)</option>
                    <option value="emerald">الزمردي (أخضر داكن)</option>
                    <option value="gold">الذهبي (ملكي)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="hijri_adj">تصحبح التاريخ الهجري</label>
                <select id="hijri_adj">
                    <option value="-2">-2 يوم</option>
                    <option value="-1">-1 يوم</option>
                    <option value="0" selected>تلقائي (0)</option>
                    <option value="1">+1 يوم</option>
                    <option value="2">+2 يوم</option>
                </select>
                <div class="info-text">
                    استخدم هذا الخيار إذا كان التاريخ الهجري يختلف عن رؤية الهلال في بلدك.
                </div>
            </div>
        </div>

        <button class="btn-save" onclick="saveSettings()">
            <span>💾</span> حفظ الإعدادات
        </button>
    </div>

    <script>
        // Util
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Init Load
        const currentMethod = getCookie('prayer_method') || '5';
        document.getElementById('method').value = currentMethod;

        const currentTheme = localStorage.getItem('app_theme') || 'default';
        document.getElementById('theme').value = currentTheme;

        const currentAdj = localStorage.getItem('hijri_offset') || '0';
        document.getElementById('hijri_adj').value = currentAdj;

        function saveSettings() {
            const method = document.getElementById('method').value;
            const theme = document.getElementById('theme').value;
            const adj = document.getElementById('hijri_adj').value;

            // Save
            localStorage.setItem('app_theme', theme);
            localStorage.setItem('hijri_offset', adj);

            const d = new Date();
            d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
            document.cookie = `prayer_method=${method};expires=${d.toUTCString()};path=/`;

            // Feedback
            const btn = document.querySelector('.btn-save');
            const originalText = btn.innerHTML;
            btn.innerHTML = "✅ تم الحفظ بنجاح";
            btn.style.background = "var(--secondary)";

            setTimeout(() => {
                window.location.href = "/";
            }, 800);
        }
    </script>
</body>

</html>