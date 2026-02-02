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
            min-width: 80px;
            text-align: center;
            color: var(--accent);
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

        .loading {
            text-align: center;
            margin-top: 20px;
            color: var(--text-dim);
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&rarr;</a>

    <div class="container">
        <div class="header">
            <h1>المناسبات الإسلامية</h1>
            <p id="current-hijri-date" style="color:var(--text-dim); text-align:center;">جاري تحميل التاريخ...</p>
        </div>

        <div id="events-list">
            <!-- Events will be populated here -->
            @foreach($events as $event)
                <div class="event-card" data-month="{{ $event['month'] }}" data-day="{{ $event['day'] }}">
                    <div class="event-name">{{ $event['name'] }}</div>
                    <div class="event-date">
                        {{ $event['day'] }} / {{ $event['month'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Fetch current Hijri date to highlight upcoming events
        async function initCalendar() {
            try {
                // Aladhan API for current date
                const today = new Date();
                const d = today.getDate();
                const m = today.getMonth() + 1;
                const y = today.getFullYear();

                const response = await fetch(`https://api.aladhan.com/v1/gToH/${d}-${m}-${y}`);
                const data = await response.json();

                if (data.code === 200) {
                    const hijri = data.data.hijri;
                    const hDay = parseInt(hijri.day);
                    const hMonth = parseInt(hijri.month.number);
                    const hYear = hijri.year;

                    document.getElementById('current-hijri-date').innerText =
                        `اليوم: ${hDay} ${hijri.month.ar} ${hYear} هـ`;

                    highlightUpcoming(hMonth, hDay);
                }
            } catch (e) {
                console.error("Failed to fetch Hijri date", e);
                document.getElementById('current-hijri-date').innerText = "تعذر تحميل التاريخ الحالي";
            }
        }

        function highlightUpcoming(currentMonth, currentDay) {
            const cards = document.querySelectorAll('.event-card');
            let nextEvent = null;
            let minDiff = Infinity;

            cards.forEach(card => {
                const eMonth = parseInt(card.dataset.month);
                const eDay = parseInt(card.dataset.day);

                // Calculate days from year start approx (ignoring 29/30 diff)
                const currentDayOfYear = (currentMonth - 1) * 30 + currentDay;
                const eventDayOfYear = (eMonth - 1) * 30 + eDay;

                let diff = eventDayOfYear - currentDayOfYear;

                // If event passed this year, it's next year (add 354 days)
                if (diff < 0) diff += 354;

                if (diff >= 0 && diff < minDiff) {
                    minDiff = diff;
                    nextEvent = card;
                }
            });

            if (nextEvent) {
                nextEvent.classList.add('upcoming');
                const badge = document.createElement('span');
                badge.innerText = ' (القادمة)';
                badge.style.fontSize = '0.8rem';
                badge.style.color = 'var(--accent)';
                nextEvent.querySelector('.event-name').appendChild(badge);
            }
        }

        initCalendar();
    </script>

</body>

</html>