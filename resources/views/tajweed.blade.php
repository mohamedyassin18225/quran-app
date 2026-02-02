<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أحكام التجويد | تطبيق الصلاة</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e293b">
    <style>
        :root {
            --primary: #1e293b;
            --secondary: #334155;
            --accent: #10b981;
            --accent-glow: rgba(16, 185, 129, 0.4);
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --card-bg: rgba(30, 41, 59, 0.7);
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            margin: 0;
            padding: 20px;
            text-align: right;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            margin-top: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .back-btn {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .back-btn:hover {
            color: var(--accent);
        }

        h1 {
            margin: 0;
            font-weight: 700;
            font-size: 2rem;
            letter-spacing: 0;
        }

        .rule-section {
            margin-bottom: 30px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .rule-title {
            color: var(--accent);
            font-size: 1.4rem;
            margin-bottom: 15px;
            font-weight: 700;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }

        .rule-description {
            color: var(--text-light);
            line-height: 1.8;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .example-box {
            background: rgba(0, 0, 0, 0.2);
            padding: 15px;
            border-radius: 8px;
            border-right: 4px solid var(--accent);
            /* RTL Right Border is logical start */
        }

        .arabic-example {
            font-family: 'Amiri', serif;
            font-size: 1.8rem;
            color: #fbbf24;
            margin-bottom: 5px;
        }

        .example-note {
            font-size: 1rem;
            color: var(--text-dim);
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <a href="/" class="back-btn">
                <span>الرئيسية</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1>أحكام التجويد</h1>
        </div>

        <div class="rule-section">
            <div class="rule-title">1. أحكام النون الساكنة والتنوين</div>
            <div class="rule-description">
                تطبق هذه الأحكام عندما تأتي النون الساكنة (نْ) أو التنوين (ً ٍ ٌ) قبل أحرف معينة.
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #e2e8f0;">أ. الإظهار:</strong> نطق النون بوضوح بدون غنة.<br>
                <em>حروفه:</em> ء هـ ع ح غ خ
                <div class="example-box">
                    <div class="arabic-example">مَنْ آمَنَ</div>
                    <div class="example-note">تنطق النون بوضوح تام.</div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #e2e8f0;">ب. الإدغام:</strong> إدخال النون في الحرف الذي يليها.<br>
                <em>حروفه:</em> ي ر م ل و ن (يرملون)
                <div class="example-box">
                    <div class="arabic-example">مَن يَّقُولُ</div>
                    <div class="example-note">تتحول النون إلى ياء مشددة مع الغنة.</div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #e2e8f0;">ج. الإقلاب:</strong> قلب النون ميماً عند ملاقاة الباء.<br>
                <div class="example-box">
                    <div class="arabic-example">مِنۢ بَعْدِ</div>
                    <div class="example-note">تُنطق النون ميماً مخفاة.</div>
                </div>
            </div>

            <div>
                <strong style="color: #e2e8f0;">د. الإخفاء:</strong> ستر النون وإخراج غنة من الخيشوم.<br>
                <em>حروفه:</em> باقي الحروف (مثل: ت ث ج د...).
                <div class="example-box">
                    <div class="arabic-example">مِن تَحْتِهَا</div>
                    <div class="example-note">يُخفى صوت النون عند التاء.</div>
                </div>
            </div>
        </div>

        <div class="rule-section">
            <div class="rule-title">2. أحكام الميم الساكنة</div>
            <div class="rule-description">
                الأحكام المطبقة على الميم الساكنة (مْ).
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #e2e8f0;">أ. الإخفاء الشفوي:</strong> تأتي بعده باء (ب). تخفى الميم مع الغنة.
                <div class="example-box">
                    <div class="arabic-example">تَرْمِيهِم بِحِجَارَةٍ</div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #e2e8f0;">ب. الإدغام الشفوي (المتماثلين):</strong> يأتي بعده ميم (م).
                <div class="example-box">
                    <div class="arabic-example">لَهُم مَّا</div>
                </div>
            </div>

            <div>
                <strong style="color: #e2e8f0;">ج. الإظهار الشفوي:</strong> يأتي بعده أي حرف آخر.
                <div class="example-box">
                    <div class="arabic-example">هُمْ فِيهَا</div>
                    <div class="example-note">يجب الحذر من إخفاء الميم عند الفاء أو الواو.</div>
                </div>
            </div>
        </div>

        <div class="rule-section">
            <div class="rule-title">3. القلقلة</div>
            <div class="rule-description">
                اضطراب الصوت عند النطق بالحرف ساكناً.
                <br><em>حروفها:</em> ق ط ب ج د (قطب جد)
            </div>
            <div class="example-box">
                <div class="arabic-example">قُلْ أَعُوذُ بِرَبِّ ٱلْفَلَقِ</div>
                <div class="example-note">اهتزاز مخرج القاف عند الوقف.</div>
            </div>
        </div>

    </div>

</body>

</html>