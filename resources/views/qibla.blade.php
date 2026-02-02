<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qibla Finder | Prayer App</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
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
            font-family: 'Outfit', sans-serif;
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
        }

        .header {
            position: absolute;
            top: 20px;
            width: 100%;
            text-align: center;
        }

        .header h1 {
            font-weight: 300;
            margin: 0;
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
            position: absolute;
            top: 110px;
            left: -6px;
            color: var(--text-light);
            font-weight: bold;
            font-size: 14px;
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
        }

        .btn-start {
            background: var(--accent);
            color: #0f172a;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            display: none;
            /* Hidden by default */
        }

        .degree-display {
            font-size: 2rem;
            font-weight: 600;
            margin-top: 20px;
        }

        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
            padding: 10px;
            z-index: 10;
        }
    </style>
</head>

<body>

    <a href="/" class="back-link">&larr;</a>

    <div class="header">
        <h1>Qibla Finder</h1>
    </div>

    <div class="compass-container" id="compass">
        <div class="compass-arrow"></div> <!-- Points North -->
        <div class="qibla-pointer" id="qiblaPointer"></div> <!-- Points to Kaaba -->
    </div>

    <div class="degree-display" id="degree">--°</div>
    <div class="status-text" id="status">Waiting for location access...</div>

    <button class="btn-start" id="startBtn" onclick="requestPermission()">Enable Compass</button>

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
                        status.innerText = "Location Found. Point your phone flat.";

                        // Check if iOS 13+ permission is needed
                        if (typeof DeviceOrientationEvent !== 'undefined' && typeof DeviceOrientationEvent.requestPermission === 'function') {
                            startBtn.style.display = 'block';
                            status.innerText = "Tap 'Enable Compass' to start.";
                        } else {
                            // Non-iOS or older devices usually just work
                            startCompass();
                        }
                    },
                    (error) => {
                        status.innerText = "Error: Could not get location. Enable GPS.";
                    }
                );
            } else {
                status.innerText = "Geolocation is not supported by this browser.";
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
            // We set the pointer rotation RELATIVE to North (which is 0 in the CSS container)
            // But wait, we rotate the CONTAINER based on device alpha.
            // So inside the container, the Qibla pointer should just be fixed at the Qibla angle relative to North.
            qiblaPointer.style.transform = `rotate(${qiblaAngle}deg)`;
        }

        function requestPermission() {
            DeviceOrientationEvent.requestPermission()
                .then(response => {
                    if (response === 'granted') {
                        startBtn.style.display = 'none';
                        startCompass();
                    } else {
                        status.innerText = "Permission denied.";
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

            // Rotating the compass container to match North
            // If heading is 90 (East), we rotate container -90 so North points Left.
            compass.style.transform = `rotate(${-compassHeading}deg)`;

            degreeDisplay.innerText = Math.round(compassHeading) + "°";
            status.innerText = "Turn until the Gold Line points up!";
        }

        // Start everything
        init();

    </script>
</body>

</html>