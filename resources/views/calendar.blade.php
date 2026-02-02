<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المناسبات الإسلامية | تطبيق الصلاة</title>
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
            max-width: 600px;
        }

        .header h1 {
            font-weight: 700;
            margin-bottom: 5px;
            text-align: center;
        }

        .event-card {
            background: var(--secondary);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: transform 0.2s;
        }

        .event-card.upcoming {
            border-color: var(--accent);
            background: rgba(16, 185, 129, 0.1);
        }

        .event-date {
            background: rgba(0, 0, 0, 0.3);
            padding: 10px 15px;
            border-radius: 10px;
            font-weight: 700;
            min-width: 120px;
            /* Wider for Gregorian */
            text-align: center;
            color: var(--accent);
            font-size: 0.9rem;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .event-date .hijri-small {
            font-size: 0.75rem;
            color: var(--text-dim);
            font-weight: 400;
        }

        .event-name {
            font-size: 1.1rem;
            font-weight: 600;
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
            <h1>المناسبات الإسلامية</h1>
            <p id="current-hijri-date" style="color:var(--text-dim); text-align:center;">جاري تحميل التواريخ
                الميلادية...</p>
        </div>

        <div id="events-list">
            @foreach($events as $event)
                <div class="event-card" id="event-{{ $event['month'] }}-{{ $event['day'] }}"
                    data-month="{{ $event['month'] }}" data-day="{{ $event['day'] }}">
                    <div class="event-name">{{ $event['name'] }}</div>
                    <div class="event-date">
                        <span class="gregorian">...</span>
                        <span class="hijri-small">{{ $event['day'] }} / {{ $event['month'] }} (هجري)</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        async function initCalendar() {
            try {
                // 1. Get Today's Hijri Date to determine Year
                const today = new Date();
                const d = today.getDate();
                const m = today.getMonth() + 1;
                const y = today.getFullYear();

                const response = await fetch(`https://api.aladhan.com/v1/gToH/${d}-${m}-${y}`);
                const data = await response.json();

                if (data.code === 200) {
                    const hijri = data.data.hijri;
                    const curHDay = parseInt(hijri.day);
                    const curHMonth = parseInt(hijri.month.number);
                    const curHYear = parseInt(hijri.year);

                    document.getElementById('current-hijri-date').innerText =
                        `العام الهجري الحالي: ${curHYear}`;

                    // 2. Process each event
                    const cards = document.querySelectorAll('.event-card');

                    // Arrays to perform batch or sequential updates
                    // Note: Aladhan has rate limits, but sequential client calls usually ok for ~10 items

                    for (const card of cards) {
                        const eMonth = parseInt(card.dataset.month);
                        const eDay = parseInt(card.dataset.day);

                        // Determine target Hijri Year (Current or Next)
                        let targetHYear = curHYear;

                        // Simple logic: If event month is before current month, it's next year
                        // Or if same month but day is passed
                        if (eMonth < curHMonth || (eMonth === curHMonth && eDay < curHDay)) {
                            targetHYear = curHYear + 1;
                        }

                        // Mark if upcoming (nearest future event)
                        // This logic can be refined, but let's first get the date

                        await fetchGregorianDate(card, eDay, eMonth, targetHYear);
                    }

                    highlightNextEvent();
                }
            } catch (e) {
                console.error("Calendar init failed", e);
                document.getElementById('current-hijri-date').innerText = "تعذر تحميل التواريخ";
            }
        }

        async function fetchGregorianDate(card, day, month, year) {
            try {
                // API expects DD-MM-YYYY (Hijri)
                const url = `https://api.aladhan.com/v1/hToG/${day}-${month}-${year}`;
                const resp = await fetch(url);
                const json = await resp.json();

                if (json.code === 200) {
                    const greg = json.data.gregorian;
                    // Format: "11 Mar 2024"
                    // Manually translating months or using API's en month
                    // Let's use standard locale Date string
                    const dateObj = new Date(greg.date.split('-').reverse().join('-')); // DD-MM-YYYY -> YYYY-MM-DD for standard parse? API returns DD-MM-YYYY
                    // Wait, API returns DD-MM-YYYY. new Date() expects ISO YYYY-MM-DD or MM/DD/YYYY
                    const [gDay, gMonth, gYear] = greg.date.split('-');
                    const dateParsed = new Date(`${gYear}-${gMonth}-${gDay}`);

                    const options = { year: 'numeric', month: 'short', day: 'numeric', weekday: 'short' };
                    // Force AR locale for display if possible, or EN as user requested Gregorian (usually Western format implies Western names, but Arabs use Jan/Feb too)
                    // Let's use Arabic-Egypt locale for Gregorian month names (Yanayir, Fibrayir etc or just standard)
                    const dateStr = dateParsed.toLocaleDateString('ar-EG', options); // 'ar-EG' usually gives good localized Gregorian

                    card.querySelector('.gregorian').innerText = dateStr;
                    card.dataset.gregorianIso = `${gYear}-${gMonth}-${gDay}`; // Store for sorting/highlighting
                }
            } catch (e) {
                console.error("Failed to convert date", e);
                card.querySelector('.gregorian').innerText = "خطأ";
            }
        }

        function highlightNextEvent() {
            const cards = document.querySelectorAll('.event-card');
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            let nextCard = null;
            let minDiff = Infinity;

            cards.forEach(card => {
                const iso = card.dataset.gregorianIso;
                if (!iso) return;

                const eventDate = new Date(iso);
                const diff = eventDate - today;

                if (diff >= 0 && diff < minDiff) {
                    minDiff = diff;
                    nextCard = card;
                }
            });

            if (nextCard) {
                nextCard.classList.add('upcoming');
                const badge = document.createElement('span');
                badge.innerText = ' (القادمة)';
                badge.style.fontSize = '0.8rem';
                badge.style.color = 'var(--accent)';
                badge.style.marginRight = '5px';
                nextCard.querySelector('.event-name').appendChild(badge);
            }
        }

        initCalendar();
    </script>

</body>

</html>