<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>99 Names of Allah | Prayer App</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&family=Amiri:wght@400;700&display=swap"
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
            font-family: 'Outfit', sans-serif;
            background-color: var(--primary);
            color: var(--text-light);
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-weight: 300;
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
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
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
            font-size: 2rem;
            color: var(--accent);
            margin-bottom: 10px;
        }

        .transliteration {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .meaning {
            font-size: 0.85rem;
            color: var(--text-dim);
            line-height: 1.3;
        }

        .number {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 0.75rem;
            color: var(--text-dim);
            opacity: 0.5;
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&larr;</a>

    <div class="header">
        <h1>Asmaul Husna</h1>
        <p style="color:var(--text-dim); margin-top:5px;">The 99 Beautiful Names of Allah</p>
    </div>

    <div class="names-grid">
        @foreach($names as $name)
            <div class="name-card">
                <div class="number">{{ $name['number'] }}</div>
                <div class="arabic">{{ $name['name'] }}</div>
                <div class="transliteration">{{ $name['transliteration'] }}</div>
                <div class="meaning">{{ $name['en']['meaning'] }}</div>
            </div>
        @endforeach
    </div>

</body>

</html>