<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>القرآن الكريم | اختر السورة</title>
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
            margin: 0;
            padding: 20px;
            text-align: right;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
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
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
        }

        .surah-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .surah-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 20px;
            text-decoration: none;
            color: var(--text-light);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .surah-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--accent);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .surah-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .surah-number {
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent);
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .surah-names {
            display: flex;
            flex-direction: column;
        }

        .arabic-name {
            font-family: 'Amiri', serif;
            font-size: 1.5rem;
            color: #e2e8f0;
            font-weight: 700;
        }

        .verses-count {
            font-size: 0.85rem;
            color: var(--text-dim);
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
            <h1>القرآن الكريم</h1>
            <div id="resume-container" style="display:none; margin-top:20px;">
                <a id="resume-btn" href="#" style="background: var(--accent); color: #0f172a; padding: 10px 20px; border-radius: 30px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 8px;">
                    <span>🔖 تابع القراءة: </span>
                    <span id="resume-text"></span>
                </a>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const saved = localStorage.getItem('khatma_bookmark');
                if (saved) {
                    try {
                        const data = JSON.parse(saved);
                        if (data && data.surah && data.ayah) {
                            const container = document.getElementById('resume-container');
                            const btn = document.getElementById('resume-btn');
                            const text = document.getElementById('resume-text');
                            
                            text.innerText = `${data.name} - آية ${data.ayah}`;
                            btn.href = `/quran/${data.surah}#ayah-${data.ayah}`;
                            container.style.display = 'block';
                        }
                    } catch(e) { console.error("Bookmark parse error", e); }
                }
            });
        </script>

        <div class="surah-grid">
            @foreach($surahs as $surah)
                <a href="/quran/{{ $surah['number'] }}" class="surah-card">
                    <div class="surah-info">
                        <div class="surah-number">{{ $surah['number'] }}</div>
                        <div class="surah-names">
                            <!-- Helper to clean name if it has "Surah" prefix, although 'name' usually has it in Arabic -->
                            <div class="arabic-name">{{ $surah['name'] }}</div>
                            <div class="verses-count">{{ $surah['numberOfAyahs'] }} آية •
                                {{ $surah['revelationType'] === 'Meccan' ? 'مكية' : 'مدنية' }}</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

</body>

</html>