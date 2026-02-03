<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>القرآن الكريم| اختر السورة</title>
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
            <a href="/quran/search" class="search-link"
                style="color:var(--accent); text-decoration:none; display:flex; gap:5px; align-items:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <span>بحث</span>
            </a>
            <div id="resume-container" style="margin-top:20px; width:100%; max-width:500px;">
                <!-- Khatma Dashboard Link -->
                <div class="khatma-card"
                    style="background:var(--secondary); padding:20px; border-radius:16px; margin-bottom:20px; border:1px solid rgba(255,255,255,0.05); text-align:center;">

                    <h3 style="margin:0 0 10px 0; color:var(--accent);">🌙 ختمة القرآن</h3>
                    <p style="color:var(--text-dim); font-size:0.9rem; margin-bottom:15px;">
                        تابع ختمتك، وحدد أهداف يومية أو تاريخ للإنتهاء.
                    </p>

                    <a href="/khatma"
                        style="background:var(--accent); color:#0f172a; padding:10px 25px; border-radius: 25px; text-decoration:none; font-weight:bold; display:inline-block;">
                        فتح متابع الختمة
                    </a>
                </div>
            </div>
        </div>

        <script>
            // Surah Ayah Counts (1-114)
            const surahAyahs = [7, 286, 200, 176, 120, 165, 206, 75, 129, 109, 123, 111, 43, 52, 99, 128, 111, 110, 98, 135, 112, 78, 118, 64, 77, 227, 93, 88, 69, 60, 34, 30, 73, 54, 45, 83, 182, 88, 75, 85, 54, 53, 89, 59, 37, 35, 38, 29, 18, 45, 60, 49, 62, 55, 78, 96, 29, 22, 24, 13, 14, 11, 11, 18, 12, 12, 30, 52, 52, 44, 28, 28, 20, 56, 40, 31, 50, 40, 46, 42, 29, 19, 36, 25, 22, 17, 19, 26, 30, 20, 15, 21, 11, 8, 8, 19, 5, 8, 8, 11, 11, 8, 3, 9, 5, 4, 7, 3, 6, 3, 5, 4, 5, 6];

            function getProgress(surahNum, ayahNum) {
                let totalRead = 0;
                for (let i = 0; i < surahNum - 1; i++) {
                    totalRead += surahAyahs[i];
                }
                totalRead += ayahNum;
                return totalRead;
            }

            document.addEventListener('DOMContentLoaded', () => {
                const saved = localStorage.getItem('khatma_bookmark');
                const container = document.getElementById('resume-container');

                if (saved) {
                    try {
                        const data = JSON.parse(saved);
                        if (data && data.surah && data.ayah) {
                            const btn = document.getElementById('resume-btn');

                            // Update Resume Button
                            btn.innerHTML = `📖 تابع: ${data.name} (${data.ayah})`;
                            btn.href = `/quran/${data.surah}#ayah-${data.ayah}`;
                            btn.style.display = 'inline-flex';
                            document.getElementById('start-msg').style.display = 'none';
                            // container.style.display = 'block'; // Already visible default

                            // Update Progress
                            const totalAyahs = 6236;
                            const readAyahs = getProgress(parseInt(data.surah), parseInt(data.ayah));
                            const percent = ((readAyahs / totalAyahs) * 100).toFixed(1);

                            document.getElementById('progress-fill').style.width = `${percent}%`;
                            document.getElementById('progress-text').innerText = `${percent}% مكتمل`;
                            document.getElementById('ayahs-left').innerText = `${totalAyahs - readAyahs} آية متبقية`;

                            // Check Goal
                            const goal = localStorage.getItem('khatma_goal_days');
                            const goalStart = localStorage.getItem('khatma_start_date');
                            if (goal && goalStart) {
                                const startDate = new Date(parseInt(goalStart));
                                const now = new Date();
                                const daysPassed = Math.floor((now - startDate) / (1000 * 60 * 60 * 24));
                                const daysLeft = Math.max(0, parseInt(goal) - daysPassed);

                                document.getElementById('khatma-days-left').innerText = `📅 باقي ${daysLeft} يوم`;
                            }
                        }
                    } catch (e) { console.error("Bookmark parse error", e); }
                }
            });

            function configureKhatma() {
                const days = prompt("كم يوماً تريد لختم القرآن؟ (مثال: 30)", localStorage.getItem('khatma_goal_days') || "30");
                if (days && !isNaN(days)) {
                    localStorage.setItem('khatma_goal_days', days);
                    localStorage.setItem('khatma_start_date', new Date().getTime());
                    alert(`تم حفظ الخطة! هدفك ختم القرآن في ${days} يوم.`);
                    location.reload();
                }
            }
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
                                {{ $surah['revelationType'] === 'Meccan' ? 'مكية' : 'مدنية' }}
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

</body>

</html>