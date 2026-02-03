<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أسماء الله الحسنى | تطبيق الصلاة</title>
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
            --accent: #fbbf24;
            /* Golden for Names */
            --accent-glow: rgba(251, 191, 36, 0.4);
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--primary);
            color: var(--text-light);
            margin: 0;
            padding: 20px;
            text-align: right;
            background-image: radial-gradient(circle at center, #2c3e50 0%, #020617 100%);
            background-attachment: fixed;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .header h1 {
            font-family: 'Amiri', serif;
            font-weight: 700;
            margin: 0;
            font-size: 2.5rem;
            color: var(--accent);
            text-shadow: 0 0 15px var(--accent-glow);
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
        }

        .names-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 15px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .name-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            aspect-ratio: 1;
            position: relative;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
            cursor: pointer;
            backdrop-filter: blur(5px);
        }

        .name-card:hover {
            transform: translateY(-5px) scale(1.05);
            background: rgba(251, 191, 36, 0.1);
            border-color: var(--accent);
        }

        .arabic {
            font-family: 'Amiri', serif;
            font-size: 1.6rem;
            color: #fff;
            margin-bottom: 5px;
            transition: color 0.3s;
        }

        .name-card:hover .arabic {
            color: var(--accent);
        }

        .number {
            font-size: 0.75rem;
            color: var(--text-dim);
            position: absolute;
            top: 8px;
            right: 10px;
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
            backdrop-filter: blur(8px);
        }

        .modal-content {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border: 2px solid var(--accent);
            width: 100%;
            max-width: 500px;
            border-radius: 20px;
            padding: 40px 30px;
            position: relative;
            text-align: center;
            box-shadow: 0 0 50px rgba(251, 191, 36, 0.2);
        }

        .modal-number {
            color: var(--text-dim);
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .modal-name-arabic {
            font-family: 'Amiri', serif;
            font-size: 4rem;
            color: var(--accent);
            margin-bottom: 20px;
            text-shadow: 0 0 20px var(--accent-glow);
        }

        .modal-meaning {
            font-size: 1.2rem;
            line-height: 1.6;
            color: var(--text-light);
            margin-bottom: 30px;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: transparent;
            border: none;
            color: var(--text-dim);
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&rarr;</a>

    <div class="header">
        <h1>أسماء الله الحسنى</h1>
        <p style="color:var(--text-dim); margin-top:5px;">التسعة والتسعون اسماً</p>
    </div>

    <div class="names-grid">
        @foreach($names as $name)
            <div class="name-card"
                onclick="openNameModal('{{$name['number']}}', '{{$name['name']}}', '{{ $name['en']['meaning'] ?? "المعنى قريباً" }}')">
                <div class="number">{{ $name['number'] }}</div>
                <div class="arabic">{{ $name['name'] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="modal" onclick="closeModal()">
        <div class="modal-content" onclick="event.stopPropagation()">
            <button class="close-btn" onclick="closeModal()">✕</button>
            <div class="modal-number" id="m-number">#1</div>
            <div class="modal-name-arabic" id="m-name">الله</div>
            <div class="modal-meaning" id="m-meaning">
                ...
            </div>
        </div>
    </div>

    <script>
        function openNameModal(num, name, meaning) {
            document.getElementById('m-number').innerText = '#' + num;
            document.getElementById('m-name').innerText = name;
            // The existing blade var might be bare, we can enhance meaning later if API data is limited
            document.getElementById('m-meaning').innerText = meaning;

            document.getElementById('modal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>

</body>

</html>