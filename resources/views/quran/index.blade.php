<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holy Quran | Select Surah</title>
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
            margin: 0;
            padding: 20px;
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
            font-weight: 600;
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

        .english-name {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .translation {
            font-size: 0.85rem;
            color: var(--text-dim);
        }

        .arabic-name {
            font-family: 'Amiri', serif;
            font-size: 1.5rem;
            color: #e2e8f0;
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
            <h1>Holy Quran</h1>
        </div>

        <div class="surah-grid">
            @foreach($surahs as $surah)
                <a href="/quran/{{ $surah['number'] }}" class="surah-card">
                    <div class="surah-info">
                        <div class="surah-number">{{ $surah['number'] }}</div>
                        <div class="surah-names">
                            <span class="english-name">{{ $surah['englishName'] }}</span>
                            <span class="translation">{{ $surah['englishNameTranslation'] }}</span>
                        </div>
                    </div>
                    <div class="arabic-name">{{ $surah['name'] }}</div>
                </a>
            @endforeach
        </div>
    </div>

</body>

</html>