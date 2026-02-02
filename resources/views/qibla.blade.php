<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحديد القبلة | تطبيق الصلاة</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e293b">

    <style>
        :root {
            --primary: #1e293b;
            --secondary: #334155;
            --accent: #10b981;
            /* Emerald */
            --kaaba: #fbbf24;
            /* Gold */
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
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            text-align: center;
        }

        .header {
            position: absolute;
            top: 20px;
            width: 100%;
            text-align: center;
        }

        .header h1 {
            font-weight: 700;
            margin: 0;
            font-size: 2rem;
        }

        .compass-container {
            position: relative;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            border: 5px solid var(--secondary);
            background: linear-gradient(145deg, #243145, #1a2333);
            box-shadow: 20px 20px 60px #1a2332, -20px -20px 60px #232f44;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .compass-arrow {
            position: absolute;
            width: 0;
            height: 0;
            border-left: 15px solid transparent;
            border-right: 15px solid transparent;
            border-bottom: 100px solid #ef4444;
            /* North Arrow (Red) */
            top: 40px;
            transform-origin: bottom center;
            z-index: 2;
        }

        .compass-arrow::after {
            content: 'N';
            /* Keep N for North universally? Or uses 'ش' for Shamal? Lets use N for standard compass feel or maybe 'ش' */
            content: 'ش';
            position: absolute;
            top: 110px;
            left: -8px;
            color: var(--text-light);
            font-weight: bold;
            font-size: 16px;
        }

        .qibla-pointer {
            position: absolute;
            width: 6px;
            height: 120px;
            background: var(--kaaba);
            top: 30px;
            transform-origin: bottom center;
            z-index: 3;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(251, 191, 36, 0.5);
            display: none;
            /* Hidden until location found */
        }

        .qibla-pointer::before {
            content: '🕋';
            font-size: 2rem;
            position: absolute;
            top: -35px;
            left: -16px;
        }

        .status-text {
            margin-top: 40px;
            color: var(--text-dim);
            text-align: center;
            max-width: 300px;
            font-weight: 600;
        }

        .btn-start {
            background: var(--accent);
            color: #0f172a;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 700;
            font-family: 'Cairo', sans-serif;
            cursor: pointer;
            margin-top: 20px;
            display: none;
            /* Hidden by default */
        }

        .degree-display {
            font-size: 2rem;
            font-weight: 700;
            margin-top: 20px;
            direction: ltr;
            /* Degrees are numbers */
        }

        .back-link {
            position: absolute;
            top: 20px;
            right: 20px;
            /* Right for RTL */
            left: auto;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
            padding: 10px;
            z-index: 10;
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&rarr;</a>

    <div class="header">
        <h1>اتجاه القبلة</h1>
    </div>

    <div class="compass-container" id="compass">
        <div class="compass-arrow"></div> <!-- Points North -->
        <div class="qibla-pointer" id="qiblaPointer"></div> <!-- Points to Kaaba -->
    </div>

    <div class="degree-display" id="degree">--°</div>
    <div class="status-text" id="status">جارِ تحديد الموقع...</div>

    <button class="btn-start" id="startBtn" onclick="requestPermission()">تفعيل البوصلة</button>

    <script>
        const compass = document.getElementById('compass');
        const qiblaPointer = document.getElementById('qiblaPointer');
        const status = document.getElementById('status');
        const startBtn = document.getElementById('startBtn');
        const degreeDisplay = document.getElementById('degree');

        let qiblaAngle = 0; // The angle of Mecca relative to North (from this user)

        // Mecca Coordinates
        const MECCA_LAT = 21.4225;
        const MECCA_LNG = 39.8262;

        function init() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        calculateQibla(lat, lng);
                        status.innerText = "تم تحديد الموقع. ضع هاتفك بشكل مسطح.";

                        // Check if iOS 13+ permission is needed
                        if (typeof DeviceOrientationEvent !== 'undefined' && typeof DeviceOrientationEvent.requestPermission === 'function') {
                            startBtn.style.display = 'block';
                            status.innerText = "اضغط على 'تفعيل البوصلة' للبدء.";
                        } else {
                            // Non-iOS or older devices usually just work
                            startCompass();
                        }
                    },
                    (error) => {
                        status.innerText = "خطأ: تعذر تحديد الموقع. تأكد من تفعيل GPS.";
                    }
                );
            } else {
                status.innerText = "المتصفح لا يدعم تحديد الموقع.";
            }
        }

        function calculateQibla(lat, lng) {
            const phiK = MECCA_LAT * Math.PI / 180.0;
            const lambdaK = MECCA_LNG * Math.PI / 180.0;
            const phi = lat * Math.PI / 180.0;
            const lambda = lng * Math.PI / 180.0;

            const psi = 180.0 / Math.PI * Math.atan2(
                Math.sin(lambdaK - lambda),
                Math.cos(phi) * Math.tan(phiK) - Math.sin(phi) * Math.cos(lambdaK - lambda)
            );

            qiblaAngle = Math.round(psi);
            if (qiblaAngle < 0) qiblaAngle += 360;

            qiblaPointer.style.display = 'block';
            qiblaPointer.style.transform = `rotate(${qiblaAngle}deg)`;
        }

        function requestPermission() {
            DeviceOrientationEvent.requestPermission()
                .then(response => {
                    if (response === 'granted') {
                        startBtn.style.display = 'none';
                        startCompass();
                    } else {
                        status.innerText = "تم رفض الإذن.";
                    }
                })
                .catch(console.error);
        }

        function startCompass() {
            window.addEventListener('deviceorientation', handleOrientation);
        }

        function handleOrientation(event) {
            let compassHeading;

            if (event.webkitCompassHeading) {
                // iOS
                compassHeading = event.webkitCompassHeading;
            } else {
                // Android (approximate)
                compassHeading = 360 - event.alpha;
            }

            // Using standard transform logic
            compass.style.transform = `rotate(${-compassHeading}deg)`;

            degreeDisplay.innerText = Math.round(compassHeading) + "°";
            status.innerText = "در حتى يشير الخط الذهبي للأعلى!";
        }

        // Start everything
        init();

    </script>
</body>

</html>