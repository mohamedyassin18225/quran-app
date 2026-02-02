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
    <script src="/js/theme.js"></script>

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
            display: none;
            /* Hidden by default */
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

        .offset-info {
            font-size: 0.8rem;
            color: var(--text-dim);
            margin-top: 10px;
        }

        .back-link {
            align-self: flex-end;
            /* Right side for RTL */
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
            <div>
                <label for="date">اختر التاريخ الميلادي:</label>
                <input type="date" id="date" value="">
                <button onclick="convertDate()">تحويل</button>
            </div>

            <div class="result" id="result-box">
                <div style="font-size:0.9rem; color:var(--text-dim); margin-bottom:5px;">التاريخ الهجري</div>
                <div class="hijri-big" id="hijri-text">
                    <!-- Result -->
                </div>
                <div style="font-size:0.9rem; margin-top:5px; opacity:0.8;" id="weekday-text">
                    <!-- Weekday -->
                </div>
                <div class="offset-info" id="offset-info"></div>
            </div>
        </div>
    </div>

    <script>
        // Set today as default
        document.getElementById('date').valueAsDate = new Date();

        // Run on load if needed or wait for user
        // convertDate();

        async function convertDate() {
            const inputDate = document.getElementById('date').value;
            if (!inputDate) return;

            const resultBox = document.getElementById('result-box');
            const hijriText = document.getElementById('hijri-text');
            const weekdayText = document.getElementById('weekday-text');
            const offsetInfo = document.getElementById('offset-info');

            // Get Offset
            const offset = parseInt(localStorage.getItem('hijri_offset') || '0');

            // Adjust Date logic:
            // Aladhan API takes DD-MM-YYYY.
            // If offset is +1, we actually want to Ask API for "Date + 1 day" -> Result.
            // Wait, "Hijri Adjustment" usually means "The moon was sighted earlier/later".
            // If offset is +1, it means today (Gregorian) corresponds to (Hijri + 1).
            // So getting the API result for GREGORIAN date will give standard Hijri.
            // We need to add days to the RESULT Hijri date? Or input Gregorian?
            // "Hijri Date Adjustment" typically shifts the Hijri day up or down.
            // Example: Today is 10th. Adjustment +1 => Display 11th.
            // So we fetch standard conversion, then manipulate the Hijri Day.

            try {
                const [y, m, d] = inputDate.split('-');
                const response = await fetch(`https://api.aladhan.com/v1/gToH/${d}-${m}-${y}`);
                const data = await response.json();

                if (data.code === 200) {
                    const hijri = data.data.hijri;
                    let hDay = parseInt(hijri.day);
                    let hMonth = hijri.month.ar;
                    let hYear = hijri.year;
                    let weekday = hijri.weekday.ar;

                    // Apply Offset
                    if (offset !== 0) {
                        // Simple day addition. (Note: Month overflow is complex without API recalculation, 
                        // but usually offset is small +/- 1-2 days).
                        // Full correct way: Convert Hijri to Epoch, add days, convert back? No standard library here.
                        // Approximation: Just change day number. If > 30, user understands validation limits usually, 
                        // or we can just say "Adjusted".
                        // Use ALADHAN ADJUSTMENT parameter? 
                        // Aladhan has `adjustment` param! /gToH?adjustment=1
                        // Let's use THAT!
                    }

                    // Actually, let's call API WITH adjustment parameter if supported.
                    // Checking Aladhan docs... yes `adjustment` parameter exists.

                    const urlWithAdj = `https://api.aladhan.com/v1/gToH/${d}-${m}-${y}?adjustment=${offset}`;
                    const respAdj = await fetch(urlWithAdj);
                    const dataAdj = await respAdj.json();

                    if (dataAdj.code === 200) {
                        const h = dataAdj.data.hijri;
                        hijriText.innerText = `${h.day} ${h.month.ar} ${h.year}`;
                        weekdayText.innerText = h.weekday.ar;

                        if (offset !== 0) {
                            offsetInfo.innerText = `(تم تطبيق تعديل: ${offset > 0 ? '+' : ''}${offset} يوم)`;
                        } else {
                            offsetInfo.innerText = '';
                        }
                        resultBox.style.display = 'block';
                    }
                }
            } catch (e) {
                console.error(e);
                alert("حدث خطأ في التحويل");
            }
        }
    </script>

</body>

</html>