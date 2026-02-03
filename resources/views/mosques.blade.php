<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المساجد القريبة | تطبيق الصلاة</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e293b">

    <style>
        :root {
            --primary: #1e293b;
            --secondary: #334155;
            --accent: #10b981;
            /* Emerald */
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--primary);
            color: var(--text-light);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .header {
            background-color: rgba(30, 41, 59, 0.95);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .header h1 {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
        }

        .back-link {
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        #map {
            flex-grow: 1;
            width: 100%;
            height: 100%;
            background-color: #cbd5e1;
        }

        .status-toast {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background-color: var(--secondary);
            color: var(--text-light);
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
            z-index: 1001;
            display: none;
            white-space: nowrap;
        }

        /* Customize Leaflet Popup */
        .leaflet-popup-content-wrapper {
            background-color: var(--primary);
            color: var(--text-light);
            border-radius: 12px;
            font-family: 'Cairo', sans-serif;
        }

        .leaflet-popup-tip {
            background-color: var(--primary);
        }

        .popup-content h3 {
            margin: 0 0 5px 0;
            color: var(--accent);
        }

        .btn-navigate {
            display: inline-block;
            background-color: var(--accent);
            color: #0f172a;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 8px;
            font-size: 0.9rem;
        }

        .leaflet-container a.leaflet-popup-close-button {
            color: var(--text-dim);
        }
    </style>
</head>

<body>

    <div class="header">
        <a href="/" class="back-link">&rarr;</a>
        <h1>المساجد القريبة</h1>
        <div style="width: 24px;"></div> <!-- Spacer -->
    </div>

    <div id="map"></div>
    <div id="status" class="status-toast">جارِ تحديد موقعك...</div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        const status = document.getElementById('status');
        let map;
        let userMarker;
        let markers = [];

        function showStatus(msg, duration = 3000) {
            status.innerText = msg;
            status.style.display = 'block';
            if (duration > 0) {
                setTimeout(() => {
                    status.style.display = 'none';
                }, duration);
            }
        }

        function initMap() {
            // Default center (Mecca) until perm granted
            map = L.map('map').setView([21.4225, 39.8262], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            if ("geolocation" in navigator) {
                showStatus("جارِ تحديد موقعك...", 0);
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        onLocationFound(lat, lng);
                    },
                    (error) => {
                        showStatus("تعذر تحديد الموقع. يرجى تفعيل GPS.");
                    }
                );
            } else {
                showStatus("المتصفح لا يدعم تحديد الموقع.");
            }
        }

        function onLocationFound(lat, lng) {
            map.setView([lat, lng], 15);

            // Add user marker
            const userIcon = L.divIcon({
                className: 'user-marker-icon',
                html: '<div style="background-color: #3b82f6; width: 16px; height: 16px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 10px rgba(59,130,246,0.5);"></div>',
                iconSize: [20, 20]
            });

            userMarker = L.marker([lat, lng], { icon: userIcon }).addTo(map)
                .bindPopup("موقعك الحالي").openPopup();

            showStatus("جاري البحث عن المساجد...");
            fetchMosques(lat, lng);
        }

        async function fetchMosques(lat, lng) {
            // Overpass API Query for mosques around 2km
            const query = `
                [out:json][timeout:25];
                (
                  node["amenity"="place_of_worship"]["religion"="muslim"](around:2000, ${lat}, ${lng});
                  way["amenity"="place_of_worship"]["religion"="muslim"](around:2000, ${lat}, ${lng});
                  relation["amenity"="place_of_worship"]["religion"="muslim"](around:2000, ${lat}, ${lng});
                );
                out center;
            `;

            const url = `https://overpass-api.de/api/interpreter?data=${encodeURIComponent(query)}`;

            try {
                const response = await fetch(url);

                if (!response.ok) {
                    if (response.status === 429) {
                        throw new Error("تجاوزت حد الطلبات (Rate Limit). يرجى الانتظار قليلاً.");
                    }
                    throw new Error(`HTTP Error: ${response.status}`);
                }

                const data = await response.json();

                if (data.elements && data.elements.length > 0) {
                    showStatus(`تم العثور على ${data.elements.length} مسجد`);
                    displayMosques(data.elements);
                } else {
                    showStatus("لم يتم العثور على مساجد قريبة في نطاق 2 كم.");
                }

            } catch (error) {
                console.error("Fetch Mosques Error:", error);
                showStatus("عذراً: " + error.message);
            }
        }

        function displayMosques(elements) {
            // Using a simple custom SVG icon for reliability
            // We need to create a definition for the icon first
            const mosqueSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32"><path fill="#10b981" d="M12 2L2 12h3v8h6v-6h2v6h6v-8h3L12 2z"/></svg>';
            const mosqueIconUrl = 'data:image/svg+xml;base64,' + btoa(mosqueSvg);

            const mosqueIcon = L.icon({
                iconUrl: mosqueIconUrl,
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });

            elements.forEach(element => {
                let mLat, mLng, name;

                if (element.type === 'node') {
                    mLat = element.lat;
                    mLng = element.lon;
                } else if (element.type === 'way' || element.type === 'relation') {
                    mLat = element.center ? element.center.lat : null;
                    mLng = element.center ? element.center.lon : null;

                    // If center is not provided directly in output (needs 'out center;'), check if we have it
                    // 'out center;' in query should provide it.
                }

                if (mLat && mLng) {
                    name = element.tags.name || element.tags['name:ar'] || element.tags['name:en'] || "مسجد";

                    const marker = L.marker([mLat, mLng], { icon: mosqueIcon }).addTo(map);

                    const popupContent = `
                        <div class="popup-content">
                            <h3>${name}</h3>
                            <a href="https://www.google.com/maps/dir/?api=1&destination=${mLat},${mLng}" 
                               target="_blank" class="btn-navigate">
                               ذهاب للنقطة 📍
                            </a>
                        </div>
                    `;

                    marker.bindPopup(popupContent);
                    markers.push(marker);
                }
            });
        }

        // Run
        initMap();

    </script>
</body>

</html>