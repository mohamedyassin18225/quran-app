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
            --like: #f43f5e;
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
            background-image: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            background-attachment: fixed;
        }

        .container {
            width: 100%;
            max-width: 800px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
            color: var(--accent);
        }

        /* Search Bar */
        .search-container {
            position: sticky;
            top: 10px;
            z-index: 90;
            margin-bottom: 20px;
        }

        .search-input {
            width: 100%;
            padding: 15px 20px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(30, 41, 59, 0.9);
            backdrop-filter: blur(10px);
            color: var(--text-light);
            font-family: inherit;
            font-size: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }

        /* Filter Tabs */
        .tabs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .tab {
            padding: 8px 16px;
            border-radius: 20px;
            background: var(--secondary);
            color: var(--text-dim);
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9rem;
            border: 1px solid transparent;
        }

        .tab.active {
            background: var(--accent);
            color: #0f172a;
            font-weight: 700;
        }

        /* Hero Section */
        .hero-card {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(30, 41, 59, 0.8));
            border: 1px solid var(--accent);
            padding: 25px;
            border-radius: 20px;
            margin-bottom: 30px;
            position: relative;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .hero-card:active {
            transform: scale(0.99);
        }

        .hero-label {
            background: var(--accent);
            color: #0f172a;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 15px;
        }

        .hero-text {
            font-family: 'Amiri', serif;
            font-size: 1.2rem;
            line-height: 1.8;
            max-height: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
        }

        /* Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 15px;
        }

        .card {
            background: rgba(30, 41, 59, 0.6);
            border-radius: 16px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            position: relative;
            height: 140px;
        }

        .card:hover {
            transform: translateY(-5px);
            background: rgba(30, 41, 59, 0.9);
            border-color: var(--accent);
        }

        .card-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--accent);
            opacity: 0.3;
            position: absolute;
            top: 10px;
            left: 15px;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 700;
            margin-top: auto;
            margin-bottom: 5px;
            z-index: 2;
        }

        .card-preview {
            font-size: 0.8rem;
            color: var(--text-dim);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            z-index: 2;
        }

        .fav-btn-mini {
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            border: none;
            color: var(--text-dim);
            cursor: pointer;
            font-size: 1.2rem;
            z-index: 10;
            transition: color 0.2s;
        }

        .fav-btn-mini.active {
            color: var(--like);
        }

        .fav-btn-mini:hover {
            transform: scale(1.1);
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            z-index: 1000;
            display: none;
            justify-content: center;
            align-items: center;
            padding: 20px;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: #1e293b;
            width: 100%;
            max-width: 600px;
            max-height: 85vh;
            border-radius: 24px;
            padding: 30px;
            position: relative;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .close-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .modal-header-row {
            display: flex;
            justify-content: space-between;
            /* title right, actions left */
            align-items: center;
            margin-bottom: 20px;
            margin-top: 10px;
            padding-right: 10px;
        }

        .modal-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--accent);
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-left: 50px;
            /* space from close btn */
        }

        .action-btn {
            background: transparent;
            border: 1px solid var(--text-dim);
            color: var(--text-dim);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .action-btn:hover {
            border-color: var(--text-light);
            color: var(--text-light);
        }

        .action-btn.active {
            border-color: var(--like);
            color: var(--like);
            background: rgba(244, 63, 94, 0.1);
        }

        .modal-body {
            overflow-y: auto;
            flex-grow: 1;
            font-family: 'Amiri', serif;
            font-size: 1.4rem;
            line-height: 2.2;
            text-align: justify;
            padding: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            margin-top: 10px;
        }

        .back-link {
            align-self: flex-start;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.2rem;
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .loader {
            text-align: center;
            margin-top: 50px;
            font-size: 1.2rem;
            color: var(--text-dim);
        }

        .toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--accent);
            color: #0f172a;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: bold;
            display: none;
            z-index: 2000;
        }
    </style>
</head>

<body>

    <div class="container">
        <a href="/" class="back-link">&rarr; الرئيسية</a>

        <div class="header">
            <h1>الأربعون النووية</h1>
            <p style="color:var(--text-dim)">من أحاديث المصطفى صلى الله عليه وسلم</p>
        </div>

        <div class="search-container">
            <input type="text" id="search-box" class="search-input" placeholder="ابحث عن حديث (مثلا: النية، الصلاة)..."
                oninput="filterHadiths()">
        </div>

        <div class="tabs">
            <div class="tab active" id="tab-all" onclick="switchTab('all')">الكل</div>
            <div class="tab" id="tab-fav" onclick="switchTab('fav')">المفضلة ❤️</div>
        </div>

        <div id="loading" class="loader">جارِ تحميل الأحاديث...</div>

        <div id="content" style="display:none;">
            <!-- Random Hero -->
            <div id="hero-section">
                <div class="hero-card" onclick="openRandom()">
                    <div class="hero-label">حديث اليوم</div>
                    <div class="hero-text" id="hero-text">...</div>
                    <div style="margin-top:10px; font-size:0.85rem; color:var(--text-dim); text-align:left;">
                        اضغط للقراءة الكاملة &larr;
                    </div>
                </div>
                <h3 style="margin-bottom:15px;">قائمة الأحاديث</h3>
            </div>

            <!-- Grid -->
            <div class="grid" id="hadith-grid">
                <!-- Items injected here -->
            </div>

            <div id="empty-msg" style="display:none; text-align:center; color:var(--text-dim); margin-top:30px;">
                لا توجد نتائج مطابقة 🔍
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="modal" onclick="closeModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <button class="close-btn" onclick="closeModal()">✕</button>

            <div class="modal-header-row">
                <div class="modal-title" id="modal-title">الحديث الأول</div>
                <div class="modal-actions">
                    <button class="action-btn" id="modal-fav-btn" onclick="toggleFavFromModal()">
                        ❤️
                    </button>
                    <button class="action-btn" onclick="copyHadith()">
                        📋
                    </button>
                    <button class="action-btn" onclick="shareHadith()">
                        🔗
                    </button>
                </div>
            </div>

            <div class="modal-body" id="modal-body">
                ...
            </div>
        </div>
    </div>

    <div id="toast" class="toast">تم النسخ! ✅</div>

    <script>
        let allHadiths = [];
        let favorites = JSON.parse(localStorage.getItem('fav_hadiths') || '[]');
        let currentFilter = 'all'; // 'all' or 'fav'
        let currentModalIndex = -1;

        async function init() {
            try {
                // Using a reliable CDN for Nawawi's 40
                const response = await fetch('https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions/ara-nawawi.json');
                const data = await response.json();

                if (data && data.hadiths) {
                    allHadiths = data.hadiths;
                    renderHero();
                    renderGrid();
                    document.getElementById('loading').style.display = 'none';
                    document.getElementById('content').style.display = 'block';
                } else {
                    document.getElementById('loading').innerText = "حدث خطأ في جلب البيانات.";
                }
            } catch (e) {
                console.error(e);
                document.getElementById('loading').innerText = "تأكد من الاتصال بالإنترنت.";
            }
        }

        // --- Render Logic ---
        function renderHero() {
            const randIndex = Math.floor(Math.random() * allHadiths.length);
            const badith = allHadiths[randIndex];
            document.getElementById('hero-text').innerText = badith.text.substring(0, 150) + "...";
            document.querySelector('.hero-card').dataset.index = randIndex;
        }

        function renderGrid() {
            const grid = document.getElementById('hadith-grid');
            grid.innerHTML = '';

            const term = document.getElementById('search-box').value.toLowerCase();
            let count = 0;

            allHadiths.forEach((h, index) => {
                // Filter Logic
                if (currentFilter === 'fav' && !favorites.includes(index)) return;
                if (term && !h.text.includes(term)) return;

                count++;
                const card = document.createElement('div');
                card.className = 'card';
                const isFav = favorites.includes(index);
                const num = h.hadithnumber;

                card.innerHTML = `
                    <div class="card-number">${num}</div>
                    <button class="fav-btn-mini ${isFav ? 'active' : ''}" onclick="toggleFav(event, ${index})">
                        ${isFav ? '❤️' : '🤍'}
                    </button>
                    <div class="card-title">الحديث ${num}</div>
                    <div class="card-preview">${h.text.substring(0, 50)}...</div>
                `;
                card.onclick = () => openModal(index);
                grid.appendChild(card);
            });

            document.getElementById('empty-msg').style.display = count === 0 ? 'block' : 'none';

            // Hide hero in fav view or search
            document.getElementById('hero-section').style.display = (currentFilter === 'all' && !term) ? 'block' : 'none';
        }

        function filterHadiths() {
            renderGrid();
        }

        function switchTab(tab) {
            currentFilter = tab;
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.getElementById('tab-' + tab).classList.add('active');
            renderGrid();
        }

        // --- Fav Logic ---
        function toggleFav(e, index) {
            e.stopPropagation(); // Prevent modal open
            if (favorites.includes(index)) {
                favorites = favorites.filter(i => i !== index);
            } else {
                favorites.push(index);
            }
            saveFavs();
            renderGrid(); // Refreshes icons
        }

        function toggleFavFromModal() {
            if (currentModalIndex === -1) return;
            toggleFav({ stopPropagation: () => { } }, currentModalIndex);
            updateModalFavIcon();
        }

        function updateModalFavIcon() {
            const btn = document.getElementById('modal-fav-btn');
            if (favorites.includes(currentModalIndex)) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        }

        function saveFavs() {
            localStorage.setItem('fav_hadiths', JSON.stringify(favorites));
        }

        // --- Modal Logic ---
        function openModal(index) {
            currentModalIndex = index;
            const h = allHadiths[index];
            document.getElementById('modal-title').innerText = `الحديث رقم ${h.hadithnumber}`;
            document.getElementById('modal-body').innerText = h.text;
            updateModalFavIcon();
            document.getElementById('modal').style.display = 'flex';
        }

        function openRandom() {
            const index = parseInt(document.querySelector('.hero-card').dataset.index);
            openModal(index);
        }

        function closeModal(e) {
            if (e && e.target !== e.currentTarget) return;
            document.getElementById('modal').style.display = 'none';
        }

        // --- Actions ---
        function copyHadith() {
            const text = document.getElementById('modal-body').innerText;
            navigator.clipboard.writeText(text).then(() => {
                showToast("تم النسخ!");
            });
        }

        function shareHadith() {
            const text = document.getElementById('modal-body').innerText;
            if (navigator.share) {
                navigator.share({
                    title: 'حديث شريف',
                    text: text,
                    url: window.location.href
                });
            } else {
                copyHadith();
            }
        }

        function showToast(msg) {
            const t = document.getElementById('toast');
            t.innerText = msg;
            t.style.display = 'block';
            setTimeout(() => t.style.display = 'none', 2000);
        }

        init();
    </script>

</body>

</html>