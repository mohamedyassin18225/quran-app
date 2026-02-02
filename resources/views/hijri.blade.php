<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>محول التاريخ الهجري | تطبيق الصلاة</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
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
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            text-align: right;
        }

        .container {
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .header h1 {
            font-weight: 700;
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
            text-align: right;
            font-weight: 600;
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
            text-align: right;
        }

        button {
            background: var(--accent);
            color: #0f172a;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 700;
            cursor: pointer;
            font-size: 1rem;
            transition: opacity 0.2s;
            font-family: 'Cairo', sans-serif;
            width: 100%;
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
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 5px;
            direction: rtl; 
        }

        .back-link {
            align-self: flex-start; /* Stays visual left or right? Container is flex column center? No body is flex column center */
            align-self: flex-end; /* Right side for RTL */
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
            margin-bottom: 20px;
            width: 100%;
            text-align: right;
            display: block;
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&rarr;</a>

    <div class="container">
        <div class="header">
            <h1>محول التاريخ الهجري</h1>
            <p style="color:var(--text-dim)">تحويل التاريخ الميلادي إلى هجري</p>
        </div>

        <div class="card">
            <form action="/hijri" method="GET">
                <label for="date">اختر التاريخ الميلادي:</label>
                <input type="date" id="date" name="date" required value="{{ request('date') ?? date('Y-m-d') }}">
                <button type="submit">تحويل</button>
            </form>

            @if(isset($conversionResult))
                <div class="result">
                    <div style="font-size:0.9rem; color:var(--text-dim); margin-bottom:5px;">التاريخ الهجري</div>
                    <div class="hijri-big">
                        {{ $conversionResult['hijri']['day'] }}
                        {{ $conversionResult['hijri']['month']['ar'] }}
                        {{ $conversionResult['hijri']['year'] }}
                    </div>
                    <div style="font-size:0.9rem; margin-top:5px; opacity:0.8;">
                        {{ $conversionResult['hijri']['weekday']['ar'] }}
                    </div>
                </div>
            @endif
        </div>
    </div>

</body>

</html>