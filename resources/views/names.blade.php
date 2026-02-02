<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أسماء الله الحسنى | تطبيق الصلاة</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e293b">

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
            text-align: right;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
        }

        .names-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 15px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .name-card {
            background: var(--secondary);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            aspect-ratio: 1;
            position: relative;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .arabic {
            font-family: 'Amiri', serif;
            font-size: 1.8rem;
            color: var(--accent);
            margin-bottom: 5px;
        }

        /* Hide English transliteration/meaning since we are in Arabic Mode 
           Or show meaning if API provides Arabic meaning? 
           The API (Aladhan) usually provides English meaning by key 'en'.
           We might show just the name for simplicity if we don't have Arabic meaning map.
        */

        .number {
            position: absolute;
            top: 10px;
            right: 10px;
            /* Right for RTL */
            font-size: 0.75rem;
            color: var(--text-dim);
            opacity: 0.5;
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&rarr;</a>

    <div class="header">
        <h1>أسماء الله الحسنى</h1>
        <p style="color:var(--text-dim); margin-top:5px;">التسعة والتسعون اسماً</p>
    </div>

    <div class="names-grid">
        @foreach($names as $name)
            <div class="name-card">
                <div class="number">{{ $name['number'] }}</div>
                <div class="arabic">{{ $name['name'] }}</div>
            </div>
        @endforeach
    </div>

</body>

</html>