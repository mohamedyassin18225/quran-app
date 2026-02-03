<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأربعون النووية | تطبيق الصلاة</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">
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
            max-width: 800px;
        }

        .header h1 {
            font-weight: 700;
            margin-bottom: 5px;
            text-align: center;
        }

        /* Hero Section (Hadith of Day) */
        .hero-card {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(30, 41, 59, 0.8));
            border: 1px solid var(--accent);
            padding: 25px;
            border-radius: 20px;
            margin: 30px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-label {
            background: var(--accent);
            color: #0f172a;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 15px;
        }

        .hero-text {
            font-family: 'Amiri', serif;
            font-size: 1.3rem;
            line-height: 2;
            max-height: 200px;
            overflow-y: auto;
        }

        /* Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .card {
            background: var(--secondary);
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            justify-content: center;
            height: 120px;
        }

        .card:hover {
            transform: translateY(-5px);
            background: #475569;
        }

        .card-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent);
            opacity: 0.5;
        }

        .card-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 5px;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            display: none;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-content {
            background: var(--secondary);
            width: 100%;
            max-width: 600px;
            max-height: 80vh;
            border-radius: 20px;
            padding: 25px;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1rem;
        }

        .modal-body {
            overflow-y: auto;
            margin-top: 20px;
            font-family: 'Amiri', serif;
            font-size: 1.4rem;
            line-height: 2.2;
            text-align: justify;
        }

        .modal-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--accent);
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }

        .back-link {
            align-self: flex-end;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .loader {
            text-align: center;
            margin-top: 50px;
            font-size: 1.2rem;
            color: var(--text-dim);
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&rarr;</a>

    <div class="container">
        <div class="header">
            <h1>الأربعون النووية</h1>
            <p style="color:var(--text-dim)">أحاديث النبي صلى الله عليه وسلم</p>
        </div>

        <div id="loading" class="loader">جارِ تحميل الأحاديث...</div>

        <div id="content" style="display:none;">
            <!-- Random Hadith -->
            <div class="hero-card" onclick="openRandom()">
                <div class="hero-label">حديث اليوم</div>
                <div class="hero-text" id="hero-text">
                    ...
                </div>
                <div style="margin-top:10px; font-size:0.85rem; color:var(--text-dim); text-align:left;">
                    اضغط للقراءة الكاملة &larr;
                </div>
            </div>

            <!-- List -->
            <h3 style="margin-bottom:10px;">كل الأحاديث</h3>
            <div class="grid" id="hadith-grid">
                <!-- Items injected here -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="modal" onclick="closeModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <button class="close-btn" onclick="closeModal()">✕</button>
            <div class="modal-title" id="modal-title">الحديث الأول</div>
            <div class="modal-body" id="modal-body">
                ...
            </div>
        </div>
    </div>

    <script>
        let allHadiths = [];

        async function init() {
            try {
                // Using a reliable CDN for Nawawi's 40
                const response = await fetch('https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/ara-nawawi.json');
                const data = await response.json();

                if (data && data.hadiths) {
                    allHadiths = data.hadiths;
                    render();
                } else {
                    document.getElementById('loading').innerText = "حدث خطأ في جلب البيانات.";
                }
            } catch (e) {
                console.error(e);
                document.getElementById('loading').innerText = "تأكد من الاتصال بالإنترنت.";
            }
        }

        function render() {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('content').style.display = 'block';

            // 1. Grid
            const grid = document.getElementById('hadith-grid');
            allHadiths.forEach((h, index) => {
                const card = document.createElement('div');
                card.className = 'card';
                // Some APIs differ in structure. FawazAhmed API: h.hadithnumber, h.text
                const num = h.hadithnumber;

                card.innerHTML = `
                    <div class="card-number">${num}</div>
                    <div class="card-title">الحديث رقم ${num}</div>
                `;
                card.onclick = () => openModal(index);
                grid.appendChild(card);
            });

            // 2. Random Hero
            const randIndex = Math.floor(Math.random() * allHadiths.length);
            const randHadith = allHadiths[randIndex];
            const heroText = document.getElementById('hero-text');
            // Truncate
            heroText.innerText = randHadith.text.substring(0, 150) + "...";

            // Store random index for click
            document.querySelector('.hero-card').dataset.index = randIndex;
        }

        function openModal(index) {
            if (typeof index === 'undefined') return;
            const h = allHadiths[index];
            document.getElementById('modal-title').innerText = `الحديث رقم ${h.hadithnumber}`;
            document.getElementById('modal-body').innerText = h.text;

            // Show
            const modal = document.getElementById('modal');
            modal.style.display = 'flex';
        }

        function openRandom() {
            const index = document.querySelector('.hero-card').dataset.index;
            openModal(parseInt(index));
        }

        function closeModal(e) {
            if (e && e.target !== e.currentTarget) return; // if clicked inside context
            document.getElementById('modal').style.display = 'none';
        }

        init();
    </script>

</body>

</html>