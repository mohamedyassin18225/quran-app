<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rules of Tajweed</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">
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
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            margin: 0;
            padding: 20px;
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
            left: 0;
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
            font-weight: 600;
            font-size: 2rem;
            letter-spacing: 1px;
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
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }

        .rule-description {
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .example-box {
            background: rgba(0, 0, 0, 0.2);
            padding: 15px;
            border-radius: 8px;
            border-right: 4px solid var(--accent);
            direction: rtl;
        }

        .arabic-example {
            font-family: 'Amiri', serif;
            font-size: 1.8rem;
            color: #fbbf24;
            margin-bottom: 5px;
        }

        .example-note {
            font-size: 0.9rem;
            color: var(--text-dim);
            direction: ltr;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <a href="/" class="back-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Home
            </a>
            <h1>Rules of Tajweed</h1>
        </div>

        <div class="rule-section">
            <div class="rule-title">1. Noon Sakinah & Tanween</div>
            <div class="rule-description">
                Rules applied when a Noon with Sukoon (نْ) or Tanween (ً ٍ ٌ) is followed by specific letters.
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #e2e8f0;">A. Izhar (Clarity):</strong> Pronouncing the Noon clearly without
                Ghunna. <br>
                <em>Letters:</em> ء هـ ع ح غ خ
                <div class="example-box">
                    <div class="arabic-example">مَنْ آمَنَ</div>
                    <div class="example-note">Man Aamana (Clear 'N' sound)</div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #e2e8f0;">B. Idgham (Merging):</strong> Merging the Noon into the following
                letter. <br>
                <em>Letters:</em> ي ر م ل و ن (Yarmaloon)
                <div class="example-box">
                    <div class="arabic-example">مَن يَّقُولُ</div>
                    <div class="example-note">May-yaqoolu (Noon merged into Ya)</div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #e2e8f0;">C. Iqlab (Conversion):</strong> Changing Noon to Meem when followed by
                Ba (ب).
                <div class="example-box">
                    <div class="arabic-example">مِنۢ بَعْدِ</div>
                    <div class="example-note">Mim-ba'di (Pronounced like a Meem)</div>
                </div>
            </div>

            <div>
                <strong style="color: #e2e8f0;">D. Ikhfa (Hiding):</strong> Hiding the Noon sound with a Ghunna (nasal
                sound). <br>
                <em>Letters:</em> Remaining 15 letters (e.g., ت ث ج د).
                <div class="example-box">
                    <div class="arabic-example">مِن تَحْتِهَا</div>
                    <div class="example-note">Min... tahtiha (Nasal sound, tongue not touching roof)</div>
                </div>
            </div>
        </div>

        <div class="rule-section">
            <div class="rule-title">2. Meem Sakinah</div>
            <div class="rule-description">
                Rules applied to Meem with Sukoon (مْ).
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #e2e8f0;">A. Ikhfa Shafawi:</strong> Followed by Ba (ب). Hide Meem with Ghunna.
                <div class="example-box">
                    <div class="arabic-example">تَرْمِيهِم بِحِجَارَةٍ</div>
                    <div class="example-note">Tarmeehim-bihijarah</div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <strong style="color: #e2e8f0;">B. Idgham Shafawi:</strong> Followed by Meem (م). Merge with Ghunna.
                <div class="example-box">
                    <div class="arabic-example">لَهُم مَّا</div>
                    <div class="example-note">Lahum-ma</div>
                </div>
            </div>

            <div>
                <strong style="color: #e2e8f0;">B. Izhar Shafawi:</strong> Followed by any other letter. Clear Meem.
                <div class="example-box">
                    <div class="arabic-example">هُمْ فِيهَا</div>
                    <div class="example-note">Hum Feeha (Clear Meem)</div>
                </div>
            </div>
        </div>

        <div class="rule-section">
            <div class="rule-title">3. Qalqalah (Echoing)</div>
            <div class="rule-description">
                Creating an echoing sound when these letters have Sukoon (or stopping on them).
                <br><em>Letters:</em> ق ط ب ج د (Qutb Jad)
            </div>
            <div class="example-box">
                <div class="arabic-example">قُلْ أَعُوذُ بِرَبِّ ٱلْفَلَقِ</div>
                <div class="example-note">Falaq (Echo the Qaf sound at the end)</div>
            </div>
        </div>

    </div>

</body>

</html>