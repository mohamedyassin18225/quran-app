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
        }

        .container {
            width: 100%;
            max-width: 500px;
        }

        .header h1 {
            font-weight: 700;
            margin-bottom: 5px;
            text-align: center;
        }

        .section {
            background: var(--secondary);
            border-radius: 16px;
            padding: 24px;
            margin-top: 30px;
        }

        label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: var(--text-dim);
        }

        select {
            width: 100%;
            padding: 16px;
            border-radius: 12px;
            border: 1px solid #475569;
            background: #1e293b;
            color: white;
            font-family: inherit;
            font-size: 1rem;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: left 1rem center;
            /* Left for RTL */
            background-size: 1em;
        }

        .info-text {
            margin-top: 15px;
            font-size: 0.85rem;
            color: var(--text-dim);
            line-height: 1.4;
        }

        .btn-save {
            background: var(--accent);
            color: #0f172a;
            border: none;
            padding: 14px;
            border-radius: 12px;
            width: 100%;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 24px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-save:hover {
            opacity: 0.9;
        }

        .back-link {
            align-self: flex-end;
            /* Right side */
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&rarr;</a> <!-- Right arrow for back in RTL -->

    <div class="container">
        <div class="header">
            <h1>الإعدادات</h1>
        </div>

        <div class="section">
            <label for="method">طريقة حساب المواقيت</label>
            <select id="method">
                <option value="5">الهيئة المصرية العامة للمساحة</option>
                <option value="4">جامعة أم القرى، مكة المكرمة</option>
                <option value="3">رابطة العالم الإسلامي</option>
                <option value="2">الجمعية الإسلامية لأمريكا الشمالية (ISNA)</option>
                <option value="1">جامعة العلوم الإسلامية، كراتشي</option>
                <option value="0">المذهب الشيعي الإثنا عشري (قم)</option>
                <option value="8">منطقة الخليج</option>
                <option value="9">الكويت</option>
                <option value="10">قطر</option>
                <option value="11">مجلس الشؤون الإسلامية، سنغافورة</option>
                <option value="12">اتحاد المنظمات الإسلامية في فرنسا</option>
                <option value="13">رئاسة الشؤون الدينية، تركيا</option>
            </select>

            <p class="info-text">
                تختلف طرق الحساب حسب الزوايا المعتمدة للفجر والعشاء.
                الافتراضي هو الهيئة المصرية العامة للمساحة.
            </p>

            <label for="theme" style="margin-top: 25px;">لون التطبيق</label>
            <select id="theme">
                <option value="default">الوضع الليلي (الافتراضي)</option>
                <option value="emerald">الزمردي (أخضر)</option>
                <option value="gold">الذهبي (بني)</option>
            </select>

            <label for="hijri_adj" style="margin-top: 25px;">تعديل التاريخ الهجري (أيام)</label>
            <select id="hijri_adj">
                <option value="-2">-2 يوم</option>
                <option value="-1">-1 يوم</option>
                <option value="0" selected>0 (تلقائي)</option>
                <option value="1">+1 يوم</option>
                <option value="2">+2 يوم</option>
            </select>

            <button class="btn-save" onclick="saveSettings()">حفظ التغييرات</button>
        </div>
    </div>

    <script>
        // Read cookie to set initial value
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        const currentMethod = getCookie('prayer_method') || '5';
        document.getElementById('method').value = currentMethod;

        // Set initial theme value
        const currentTheme = localStorage.getItem('app_theme') || 'default';
        document.getElementById('theme').value = currentTheme;

        // Set initial offset
        const currentAdj = localStorage.getItem('hijri_offset') || '0';
        document.getElementById('hijri_adj').value = currentAdj;

        function saveSettings() {
            const selectMethod = document.getElementById('method');
            const method = selectMethod.value;

            const selectTheme = document.getElementById('theme');
            const theme = selectTheme.value;

            // Save Theme
            localStorage.setItem('app_theme', theme);

            // Save Hijri Offset
            const adj = document.getElementById('hijri_adj').value;
            localStorage.setItem('hijri_offset', adj);

            // Save Method Cookie
            const d = new Date();
            d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = "prayer_method=" + method + ";" + expires + ";path=/";

            alert('تم حفظ الإعدادات!');
            window.location.href = "/"; // Go back home
        }
    </script>
</body>

</html>