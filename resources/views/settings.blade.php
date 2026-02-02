<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Prayer App</title>
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
        }

        .header h1 {
            font-weight: 300;
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
            /* Custom arrow ideally, but simple for now */
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
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
            font-weight: 600;
            font-size: 1rem;
            margin-top: 24px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-save:hover {
            opacity: 0.9;
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
            <h1>Settings</h1>
        </div>

        <div class="section">
            <label for="method">Calculation Method</label>
            <select id="method">
                <option value="5">Egyptian General Authority</option>
                <option value="4">Umm Al-Qura University, Makkah</option>
                <option value="3">Muslim World League</option>
                <option value="2">Islamic Society of North America (ISNA)</option>
                <option value="1">University of Islamic Sciences, Karachi</option>
                <option value="0">Shia Ithna-Ashari, Leva Institute, Qum</option>
                <option value="7">Institute of Geophysics, University of Tehran</option>
                <option value="8">Gulf Region</option>
                <option value="9">Kuwait</option>
                <option value="10">Qatar</option>
                <option value="11">Majlis Ugama Islam Singapura, Singapore</option>
                <option value="12">Union Organization islamic de France</option>
                <option value="13">Diyanet İşleri Başkanlığı, Turkey</option>
            </select>

            <p class="info-text">
                Different organizations use different angles for Fajr and Isha.
                Egypt is default (Authority of Survey).
            </p>

            <button class="btn-save" onclick="saveSettings()">Save & Update</button>
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

        function saveSettings() {
            const select = document.getElementById('method');
            const method = select.value;

            // Set cookie for 1 year
            const d = new Date();
            d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = "prayer_method=" + method + ";" + expires + ";path=/";

            alert('Settings saved!');
            window.location.href = "/"; // Go back home to reload with new settings
        }
    </script>
</body>

</html>