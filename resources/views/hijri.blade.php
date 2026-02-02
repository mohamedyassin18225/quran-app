<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hijri Date Converter | Prayer App</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
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
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .header h1 {
            font-weight: 300;
            margin-bottom: 5px;
        }

        .card {
            background: var(--secondary);
            border-radius: 16px;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 15px;
            color: var(--text-dim);
        }

        input[type="date"] {
            width: 100%;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #475569;
            background: #1e293b;
            color: white;
            font-family: inherit;
            font-size: 1.1rem;
            margin-bottom: 20px;
            box-sizing: border-box;
            /* Important for padding */
        }

        button {
            background: var(--accent);
            color: #0f172a;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            font-size: 1rem;
            transition: opacity 0.2s;
        }

        button:hover {
            opacity: 0.9;
        }

        .result {
            margin-top: 30px;
            background: rgba(16, 185, 129, 0.1);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid var(--accent);
        }

        .hijri-big {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--accent);
            margin-bottom: 5px;
        }

        .back-link {
            align-self: flex-start;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&larr;</a>

    <div class="container">
        <div class="header">
            <h1>Hijri Converter</h1>
            <p style="color:var(--text-dim)">Convert Gregorian to Hijri</p>
        </div>

        <div class="card">
            <form action="/hijri" method="GET">
                <label for="date">Select Gregorian Date:</label>
                <input type="date" id="date" name="date" required value="{{ request('date') ?? date('Y-m-d') }}">
                <button type="submit">Convert</button>
            </form>

            @if(isset($conversionResult))
                <div class="result">
                    <div style="font-size:0.9rem; color:var(--text-dim); margin-bottom:5px;">Hijri Date</div>
                    <div class="hijri-big">
                        {{ $conversionResult['hijri']['day'] }}
                        {{ $conversionResult['hijri']['month']['en'] }}
                        {{ $conversionResult['hijri']['year'] }}
                    </div>
                    <div style="font-size:0.9rem; margin-top:5px; opacity:0.8;">
                        {{ $conversionResult['hijri']['weekday']['en'] }}
                    </div>
                </div>
            @endif
        </div>
    </div>

</body>

</html>