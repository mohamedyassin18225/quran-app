<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بحث في القرآن | تطبيق الصلاة</title>
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
            max-width: 600px;
        }

        .header h1 {
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        .search-box {
            position: relative;
            margin-bottom: 30px;
        }

        input[type="text"] {
            width: 100%;
            padding: 15px 20px;
            border-radius: 30px;
            border: 2px solid var(--secondary);
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-light);
            font-family: 'Cairo', sans-serif;
            font-size: 1.1rem;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus {
            border-color: var(--accent);
        }

        button.search-btn {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--accent);
            color: #0f172a;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            font-family: 'Cairo', sans-serif;
        }

        .results {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .result-card {
            background: var(--secondary);
            padding: 20px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .result-ayah {
            font-family: 'Amiri', serif;
            font-size: 1.4rem;
            line-height: 2.2;
            color: #fff;
            margin-bottom: 10px;
        }

        .result-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            color: var(--accent);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 10px;
        }

        .highlight {
            background-color: rgba(251, 191, 36, 0.4);
            /* Gold highlight */
            border-radius: 4px;
            padding: 0 2px;
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

    <a href="/quran" class="back-link">&rarr;</a>

    <div class="container">
        <div class="header">
            <h1>بحث في القرآن الكريم</h1>
        </div>

        <div class="search-box">
            <input type="text" id="searchInput" placeholder="اكتب كلمة للبحث (مثال: الصبر)...">
            <button class="search-btn" onclick="performSearch()">بحث</button>
        </div>

        <div id="status" style="text-align:center; color: var(--text-dim); margin-bottom: 20px;"></div>

        <div class="results" id="results">
            <!-- Results will appear here -->
        </div>
    </div>

    <script>
        const input = document.getElementById('searchInput');
        input.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') performSearch();
        });

        async function performSearch() {
            const query = input.value.trim();
            const resultsContainer = document.getElementById('results');
            const status = document.getElementById('status');

            if (!query) return;
            if (query.length < 2) {
                status.innerText = "الرجاء إدخال حرفين على الأقل";
                return;
            }

            // Clear previous
            resultsContainer.innerHTML = '';
            status.innerText = 'جارِ البحث...';

            try {
                // Fetch from AlQuran Cloud API
                // /search/{keyword}/all/ar
                const response = await fetch(`https://api.alquran.cloud/v1/search/${encodeURIComponent(query)}/all/ar`);
                const data = await response.json();

                if (data.code === 200) {
                    const matches = data.data.matches;
                    const count = data.data.count;

                    if (count === 0) {
                        status.innerText = `لم يتم العثور على نتائج لـ "${query}"`;
                    } else {
                        status.innerText = `تم العثور على ${count} نتيجة`;

                        matches.forEach(match => {
                            const card = document.createElement('div');
                            card.className = 'result-card';

                            // Highlight the keyword
                            const text = match.text.replace(new RegExp(query, 'gi'), `<span class="highlight">${query}</span>`);

                            card.innerHTML = `
                                <div class="result-ayah">${text} ﴿${match.numberInSurah}﴾</div>
                                <div class="result-meta">
                                    <span>${match.surah.name}</span>
                                    <a href="/quran/${match.surah.number}#ayah-${match.numberInSurah}" style="color:var(--text-dim); text-decoration:none;">
                                        الذهاب للآية &larr;
                                    </a>
                                </div>
                            `;
                            resultsContainer.appendChild(card);
                        });
                    }
                } else {
                    status.innerText = "حدث خطأ أثناء البحث.";
                }
            } catch (e) {
                console.error(e);
                status.innerText = "فشل الاتصال بالخادم. تأكد من الإنترنت.";
            }
        }
    </script>

</body>

</html>