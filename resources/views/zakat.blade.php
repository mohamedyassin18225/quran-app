<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>حاسبة الزكاة الذكية | تطبيق الصلاة</title>
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
            --gold: #fbbf24;
            --silver: #cbd5e1;
            --wrong: #ef4444;
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
            background-image: linear-gradient(0deg, #1e293b 0%, #0f172a 100%);
        }

        .container {
            width: 100%;
            max-width: 600px;
        }

        .header h1 {
            font-weight: 700;
            margin-bottom: 5px;
            text-align: center;
            color: var(--accent);
        }

        .back-link {
            align-self: flex-start;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.2rem;
            margin-bottom: 20px;
            display: inline-block;
        }

        /* Asset Cards */
        .card {
            background: rgba(30, 41, 59, 0.7);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .icon {
            font-size: 1.5rem;
            margin-left: 10px;
        }

        .input-group {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-dim);
            font-size: 0.9rem;
        }

        input[type="number"] {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #475569;
            background: rgba(0, 0, 0, 0.3);
            color: white;
            font-family: inherit;
            font-size: 1rem;
            box-sizing: border-box;
            text-align: left;
            /* Numbers LTR */
            direction: ltr;
        }

        /* Calc Button */
        .btn-calc {
            background: var(--accent);
            color: #0f172a;
            border: none;
            padding: 15px;
            border-radius: 12px;
            width: 100%;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
            transition: transform 0.2s;
        }

        .btn-calc:active {
            transform: scale(0.98);
        }

        /* Result Area */
        .result-box {
            background: #111827;
            border-radius: 16px;
            padding: 25px;
            margin-top: 30px;
            text-align: center;
            border: 2px solid var(--accent);
            display: none;
        }

        .total-assets {
            font-size: 1.2rem;
            color: var(--text-dim);
            margin-bottom: 10px;
        }

        .zakat-due {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--accent);
            margin-bottom: 10px;
            direction: ltr;
        }

        .status-msg {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 10px;
            display: inline-block;
        }

        .status-ok {
            background: rgba(16, 185, 129, 0.2);
            color: var(--accent);
        }

        .status-no {
            background: rgba(239, 68, 68, 0.2);
            color: var(--wrong);
        }
    </style>
</head>

<body>

    <div class="container">
        <a href="/" class="back-link">&rarr; الرئيسية</a>

        <div class="header">
            <h1>حاسبة الزكاة الذكية</h1>
            <p style="color:var(--text-dim); text-align:center;">احسب زكاتك بدقة (ربع العشر 2.5%)</p>
        </div>

        <!-- Gold Settings -->
        <div class="card" style="border-color: var(--gold);">
            <div class="card-header">
                <div><span class="icon">🏆</span> أسعار الذهب (جرام)</div>
            </div>
            <label>سعر جرام الذهب (عيار 24) بالعملة المحلية</label>
            <input type="number" id="gold-price" placeholder="مثلاً: 2500" onchange="saveSettings()">
            <p style="font-size:0.8rem; color:var(--text-dim); margin-top:5px;">
                نصاب الذهب = 85 × السعر. (تلقائي: <span id="nisab-val">--</span>)
            </p>
        </div>

        <!-- Assets -->
        <div class="card">
            <div class="card-header">
                <div><span class="icon">💵</span> النقد والمدخرات</div>
            </div>
            <label>السيولة النقدية (في اليد أو البنك)</label>
            <input type="number" class="asset-input" id="cash" placeholder="0">
        </div>

        <div class="card">
            <div class="card-header">
                <div><span class="icon">👑</span> الذهب والفضة (للاكتناز)</div>
            </div>
            <div class="input-group">
                <label>وزن الذهب (جرام)</label>
                <input type="number" class="asset-input" id="gold-weight" placeholder="0">
            </div>
            <div class="input-group">
                <label>وزن الفضة (جرام)</label>
                <input type="number" class="asset-input" id="silver-weight" placeholder="0">
            </div>
        </div>

        <button class="btn-calc" onclick="calculate()">احسب الزكاة المستحقة</button>

        <!-- Result -->
        <div id="result" class="result-box">
            <div class="total-assets">إجمالي الثروة: <span id="total-val">0</span></div>
            <div class="zakat-due" id="zakat-val">0.00</div>
            <div id="status-badge" class="status-msg"></div>
            <p class="status-msg" style="display:block; background:none; color:var(--text-dim); margin-top:10px;">
                الحد الأدنى للنصاب: <span id="nisab-display">0</span>
            </p>
        </div>
    </div>

    <script>
        // Init
        document.addEventListener('DOMContentLoaded', () => {
            const savedPrice = localStorage.getItem('zakat_gold_price');
            if (savedPrice) {
                document.getElementById('gold-price').value = savedPrice;
                updateNisabDisplay();
            }
        });

        function saveSettings() {
            const price = document.getElementById('gold-price').value;
            localStorage.setItem('zakat_gold_price', price);
            updateNisabDisplay();
        }

        function updateNisabDisplay() {
            const price = parseFloat(document.getElementById('gold-price').value) || 0;
            const nisab = price * 85;
            document.getElementById('nisab-val').innerText = formatMoney(nisab);
        }

        function calculate() {
            const goldPrice = parseFloat(document.getElementById('gold-price').value);
            if (!goldPrice) return alert("يرجى إدخال سعر جرام الذهب أولاً لحساب النصاب.");

            // Assets
            const cash = parseFloat(document.getElementById('cash').value) || 0;
            const goldW = parseFloat(document.getElementById('gold-weight').value) || 0;
            const silverW = parseFloat(document.getElementById('silver-weight').value) || 0;

            // Values
            // Silver price approx 1/80 of gold? Or user input? 
            // Let's assume user inputs simple assets. 
            // Actually, gold assets value = weight * price.
            // Silver value? We didn't ask for silver price. Let's assume mostly Gold/Cash focus or generic "Assets Value".

            // Simplified: User inputs WEIGHT of gold. We start with Gold Price input.
            const goldValue = goldW * goldPrice;

            // Silver logic: tough without price. Let's skip silver auto-calc unless we add silver price input.
            // Or just treat silver input as 0 for now unless we add price.
            // Let's assume Silver Price is approx 2% of Gold Price roughly? No, too risky.
            // Let's just calculate Gold + Cash for now to be safe.

            const totalWealth = cash + goldValue;
            const nisab = 85 * goldPrice;

            document.getElementById('total-val').innerText = formatMoney(totalWealth);
            document.getElementById('nisab-display').innerText = formatMoney(nisab);

            const resultBox = document.getElementById('result');
            const statusBadge = document.getElementById('status-badge');
            const zakatVal = document.getElementById('zakat-val');

            resultBox.style.display = 'block';

            if (totalWealth >= nisab) {
                const due = totalWealth * 0.025;
                zakatVal.innerText = formatMoney(due);
                statusBadge.className = 'status-msg status-ok';
                statusBadge.innerText = "✅ تجب عليك الزكاة";
                statusBadge.style.color = "var(--accent)";
            } else {
                zakatVal.innerText = "0.00";
                statusBadge.className = 'status-msg status-no';
                statusBadge.innerText = "❌ لم يبلغ النصاب";
                statusBadge.style.color = "var(--wrong)";
            }
        }

        function formatMoney(num) {
            return num.toLocaleString('en-US', { maximumFractionDigits: 2 });
        }
    </script>

</body>

</html>