<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حاسبة الزكاة | تطبيق الصلاة</title>
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
        }

        .header h1 {
            font-weight: 700;
            margin-bottom: 5px;
            text-align: center;
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
            margin-bottom: 12px;
            font-weight: 600;
            color: var(--text-dim);
        }

        input[type="number"] {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
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
            padding: 15px;
            border-radius: 12px;
            width: 100%;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
            transition: opacity 0.2s;
        }

        button:hover {
            opacity: 0.9;
        }

        .result-box {
            margin-top: 30px;
            background: rgba(16, 185, 129, 0.1);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid var(--accent);
            display: none;
            text-align: center;
        }

        .zakat-amount {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent);
            margin: 10px 0;
            direction: ltr;
            /* Keeping amount LTR for readability often helps, or RTL if purely Arabic numerals */
        }

        .nisab-info {
            margin-top: 25px;
            font-size: 0.9rem;
            color: var(--text-dim);
            background: rgba(0, 0, 0, 0.2);
            padding: 15px;
            border-radius: 8px;
            line-height: 1.6;
        }

        .back-link {
            align-self: flex-end;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&rarr;</a>

    <div class="container">
        <div class="header">
            <h1>حاسبة الزكاة</h1>
            <p style="color:var(--text-dim); text-align:center;">احسب زكاة المال (2.5%)</p>
        </div>

        <div class="card">
            <label for="amount">المبلغ المدخر (مر عليه الحول):</label>
            <input type="number" id="amount" placeholder="أدخل المبلغ هنا..." step="0.01">

            <button onclick="calculateZakat()">احسب الزكاة</button>

            <div id="result" class="result-box">
                <div>مبلغ الزكاة المستحق:</div>
                <div class="zakat-amount" id="zakat-value">0.00</div>
            </div>

            <div class="nisab-info">
                <strong>معلومة عن النصاب:</strong><br>
                يجب إخراج الزكاة إذا بلغ المال النصاب ومر عليه عام هجري كامل.<br>
                نصاب الذهب: 85 جرام.<br>
                نصاب الفضة: 595 جرام.<br>
                قيمة الزكاة هي ربع العشر (2.5%).
            </div>
        </div>
    </div>

    <script>
        function calculateZakat() {
            const amount = parseFloat(document.getElementById('amount').value);
            const resultBox = document.getElementById('result');
            const resultValue = document.getElementById('zakat-value');

            if (isNaN(amount) || amount <= 0) {
                alert('الرجاء إدخال مبلغ صحيح.');
                return;
            }

            const zakat = amount * 0.025;

            // Format with commas, 2 decimal places
            resultValue.innerText = zakat.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            resultBox.style.display = 'block';
        }
    </script>

</body>

</html>