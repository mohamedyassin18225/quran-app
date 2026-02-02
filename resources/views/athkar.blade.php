<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الأذكار | أذكار الصباح والمساء</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#1e293b">
    <style>
        :root {
            --primary: #1e293b;
            --secondary: #334155;
            --accent: #10b981;
            --accent-glow: rgba(16, 185, 129, 0.4);
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --card-bg: rgba(30, 41, 59, 0.7);
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            margin: 0;
            padding: 20px;
            text-align: right;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .back-btn {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .back-btn:hover {
            color: var(--accent);
        }

        h1 {
            margin: 0;
            font-weight: 700;
            font-size: 1.8rem;
            letter-spacing: 0;
        }

        .tabs {
            display: flex;
            justify-content: center;
            background: rgba(0, 0, 0, 0.2);
            padding: 5px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .tab-btn {
            flex: 1;
            background: transparent;
            border: none;
            color: var(--text-dim);
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Cairo', sans-serif;
            font-weight: 600;
            transition: all 0.3s;
        }

        .tab-btn.active {
            background: var(--accent);
            color: #0f172a;
            font-weight: 700;
        }

        .athkar-list {
            display: none;
        }

        .athkar-list.active {
            display: block;
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .thikr-card {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid transparent;
            transition: transform 0.2s;
        }

        .thikr-card:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.05);
        }

        .arabic-text {
            font-family: 'Amiri', serif;
            font-size: 1.6rem;
            text-align: right;
            line-height: 2;
            margin-bottom: 15px;
            color: #e2e8f0;
        }

        .meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 10px;
            margin-top: 15px;
            font-size: 0.85rem;
            color: var(--accent);
        }

        .count {
            background: rgba(16, 185, 129, 0.1);
            padding: 2px 8px;
            border-radius: 6px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <a href="/" class="back-btn">
                <span>الرئيسية</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1>الأذكار</h1>
        </div>

        <div class="tabs" style="flex-wrap: wrap; gap: 10px;">
            <button class="tab-btn active" onclick="switchTab('morning')">أذكار الصباح</button>
            <button class="tab-btn" onclick="switchTab('evening')">أذكار المساء</button>
            <button class="tab-btn" onclick="switchTab('travel')">السفر</button>
            <button class="tab-btn" onclick="switchTab('distress')">الكرب</button>
            <button class="tab-btn" onclick="switchTab('home')">المنزل</button>
        </div>

        <!-- Morning Athkar -->
        <div id="morning" class="athkar-list active">
            <div class="thikr-card">
                <div class="arabic-text">اللَّهُ لَا إِلَٰهَ إِلَّا هُوَ الْحَيُّ الْقَيُّومُ ۚ لَا تَأْخُذُهُ سِنَةٌ
                    وَلَا نَوْمٌ ۚ لَّهُ مَا فِي السَّمَاوَاتِ وَمَا فِي الْأَرْضِ ۗ مَن ذَا الَّذِي يَشْفَعُ عِندَهُ
                    إِلَّا بِإِذْنِهِ ۚ يَعْلَمُ مَا بَيْنَ أَيْدِيهِمْ وَمَا خَلْفَهُمْ ۖ وَلَا يُحِيطُونَ بِشَيْءٍ
                    مِّنْ عِلْمِهِ إِلَّا بِمَا شَاءَ ۚ وَسِعَ كُرْسِيُّهُ السَّمَاوَاتِ وَالْأَرْضَ ۖ وَلَا يَئُودُهُ
                    حِفْظُهُمَا ۚ وَهُوَ الْعَلِيُّ الْعَظِيمُ</div>
                <div class="meta">
                    <span>آية الكرسي</span>
                    <span class="count">مرة واحدة</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">
                    قُلْ هُوَ اللَّهُ أَحَدٌ ... <br>
                    قُلْ أَعُوذُ بِرَبِّ الْفَلَقِ ... <br>
                    قُلْ أَعُوذُ بِرَبِّ النَّاسِ ...
                </div>
                <div class="meta">
                    <span>الإخلاص والمعوذتين</span>
                    <span class="count">3 مرات</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">أَصْبَحْنَا وَأَصْبَحَ الْمُلْكُ لِلَّهِ، وَالْحَمْدُ لِلَّهِ، لاَ إِلَـهَ
                    إِلاَّ اللهُ وَحْدَهُ لاَ شَرِيكَ لَهُ، لَهُ الْمُلْكُ وَلَهُ الْحَمْدُ وَهُوَ عَلَى كُلِّ شَيْءٍ
                    قَدِيرٌ. رَبِّ أَسْأَلُكَ خَيْرَ مَا فِي هَذَا الْيَوْمِ وَخَيْرَ مَا بَعْدَهُ، وَأَعُوذُ بِكَ مِنْ
                    شَرِّ مَا فِي هَذَا الْيَوْمِ وَشَرِّ مَا بَعْدَهُ...</div>
                <div class="meta">
                    <span>رواه مسلم</span>
                    <span class="count">مرة واحدة</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">اللَّهُمَّ بِكَ أَصْبَحْنَا وَبِكَ أَمْسَيْنَا ، وَبِكَ نَحْيَا وَبِكَ نَمُوتُ
                    وَإِلَيْكَ النُّشُورُ</div>
                <div class="meta">
                    <span>رواه الترمذي</span>
                    <span class="count">مرة واحدة</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">اللَّهُمَّ أَنْتَ رَبِّي لَا إِلَهَ إِلَّا أَنْتَ، خَلَقْتَنِي وَأَنَا
                    عَبْدُكَ، وَأَنَا عَلَى عَهْدِكَ وَوَعْدِكَ مَا اسْتَطَعْتُ، أَعُوذُ بِكَ مِنْ شَرِّ مَا صَنَعْتُ،
                    أَبُوءُ لَكَ بِنِعْمَتِكَ عَلَيَّ، وَأَبُوءُ لَكَ بِذَنْبِي فَاغْفِرْ لِي فَإِنَّهُ لَا يَغْفِرُ
                    الذُّنُوبَ إِلَّا أَنْتَ</div>
                <div class="meta">
                    <span>سيد الاستغفار</span>
                    <span class="count">مرة واحدة</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">بِسْمِ اللهِ الَّذِي لَا يَضُرُّ مَعَ اسْمِهِ شَيْءٌ فِي الْأَرْضِ وَلَا فِي
                    السَّمَاءِ وَهُوَ السَّمِيعُ الْعَلِيمُ</div>
                <div class="meta">
                    <span>رواه أبو داود</span>
                    <span class="count">3 مرات</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">رَضِيتُ بِاللَّهِ رَبًّا، وَبِالْإِسْلَامِ دِينًا، وَبِمُحَمَّدٍ نَبِيًّا</div>
                <div class="meta">
                    <span>رواه أبو داود</span>
                    <span class="count">3 مرات</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">سُبْحَانَ اللَّهِ وَبِحَمْدِهِ</div>
                <div class="meta">
                    <span>رواه مسلم</span>
                    <span class="count">100 مرة</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">يَا حَيُّ يَا قَيُّومُ بِرَحْمَتِكَ أَسْتَغِيثُ أَصْلِحْ لِي شَأْنِي كُلَّهُ
                    وَلَا تَكِلْنِي إِلَى نَفْسِي طَرْفَةَ عَيْنٍ</div>
                <div class="meta">
                    <span>رواه الحاكم</span>
                    <span class="count">مرة واحدة</span>
                </div>
            </div>
        </div>

        <!-- Evening Athkar -->
        <div id="evening" class="athkar-list">

            <div class="thikr-card">
                <div class="arabic-text">اللَّهُ لَا إِلَٰهَ إِلَّا هُوَ الْحَيُّ الْقَيُّومُ ۚ لَا تَأْخُذُهُ سِنَةٌ
                    وَلَا نَوْمٌ...</div>
                <div class="meta">
                    <span>آية الكرسي</span>
                    <span class="count">مرة واحدة</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">
                    قُلْ هُوَ اللَّهُ أَحَدٌ ... <br>
                    قُلْ أَعُوذُ بِرَبِّ الْفَلَقِ ... <br>
                    قُلْ أَعُوذُ بِرَبِّ النَّاسِ ...
                </div>
                <div class="meta">
                    <span>الإخلاص والمعوذتين</span>
                    <span class="count">3 مرات</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">أَمْسَيْنَا وَأَمْسَى الْمُلْكُ لِلَّهِ، وَالْحَمْدُ لِلَّهِ، لاَ إِلَـهَ
                    إِلاَّ اللهُ وَحْدَهُ لاَ شَرِيكَ لَهُ، لَهُ الْمُلْكُ وَلَهُ الْحَمْدُ وَهُوَ عَلَى كُلِّ شَيْءٍ
                    قَدِيرٌ. رَبِّ أَسْأَلُكَ خَيْرَ مَا فِي هَذِهِ اللَّيْلَةِ وَخَيْرَ مَا بَعْدَهَا، وَأَعُوذُ بِكَ
                    مِنْ شَرِّ مَا فِي هَذِهِ اللَّيْلَةِ وَشَرِّ مَا بَعْدَهَا...</div>
                <div class="meta">
                    <span>رواه مسلم</span>
                    <span class="count">مرة واحدة</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">اللَّهُمَّ بِكَ أَمْسَيْنَا وَبِكَ أَصْبَحْنَا ، وَبِكَ نَحْيَا وَبِكَ نَمُوتُ
                    وَإِلَيْكَ الْمَصِيرُ</div>
                <div class="meta">
                    <span>رواه الترمذي</span>
                    <span class="count">مرة واحدة</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">اللَّهُمَّ أَنْتَ رَبِّي لَا إِلَهَ إِلَّا أَنْتَ، خَلَقْتَنِي وَأَنَا
                    عَبْدُكَ...</div>
                <div class="meta">
                    <span>سيد الاستغفار</span>
                    <span class="count">مرة واحدة</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">أَعُوذُ بِكَلِمَاتِ اللهِ التَّامَّاتِ مِنْ شَرِّ مَا خَلَقَ</div>
                <div class="meta">
                    <span>رواه مسلم</span>
                    <span class="count">3 مرات</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">بِسْمِ اللهِ الَّذِي لَا يَضُرُّ مَعَ اسْمِهِ شَيْءٌ فِي الْأَرْضِ وَلَا فِي
                    السَّمَاءِ وَهُوَ السَّمِيعُ الْعَلِيمُ</div>
                <div class="meta">
                    <span>رواه أبو داود</span>
                    <span class="count">3 مرات</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">رَضِيتُ بِاللَّهِ رَبًّا، وَبِالْإِسْلَامِ دِينًا، وَبِمُحَمَّدٍ نَبِيًّا</div>
                <div class="meta">
                    <span>رواه أبو داود</span>
                    <span class="count">3 مرات</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">سُبْحَانَ اللَّهِ وَبِحَمْدِهِ</div>
                <div class="meta">
                    <span>رواه مسلم</span>
                    <span class="count">100 مرة</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">يَا حَيُّ يَا قَيُّومُ بِرَحْمَتِكَ أَسْتَغِيثُ أَصْلِحْ لِي شَأْنِي كُلَّهُ
                    وَلَا تَكِلْنِي إِلَى نَفْسِي طَرْفَةَ عَيْنٍ</div>
                <div class="meta">
                    <span>رواه الحاكم</span>
                    <span class="count">مرة واحدة</span>
                </div>

                <!-- Travel Athkar -->
                <div id="travel" class="athkar-list">
                    <div class="thikr-card">
                        <div class="arabic-text">سُبْحَانَ الَّذِي سَخَّرَ لَنَا هَذَا وَمَا كُنَّا لَهُ مُقْرِنِينَ *
                            وَإِنَّا إِلَى رَبِّنَا لَمُنْقَلِبُونَ</div>
                        <div class="meta">
                            <span>دعاء ركوب الدابة</span>
                            <span class="count">مرة واحدة</span>
                        </div>
                    </div>
                    <div class="thikr-card">
                        <div class="arabic-text">اللَّهُمَّ إِنَّا نَسْأَلُكَ فِي سَفَرِنَا هَذَا الْبِرَّ وَالتَّقْوَى،
                            وَمِنَ الْعَمَلِ مَا تَرْضَى، اللَّهُمَّ هَوِّنْ عَلَيْنَا سَفَرَنَا هَذَا، وَاطْوِ عَنَّا
                            بُعْدَهُ...</div>
                        <div class="meta">
                            <span>دعاء السفر</span>
                            <span class="count">مرة واحدة</span>
                        </div>
                    </div>
                </div>

                <!-- Distress Athkar -->
                <div id="distress" class="athkar-list">
                    <div class="thikr-card">
                        <div class="arabic-text">لَا إِلَهَ إِلَّا اللَّهُ الْعَظِيمُ الْحَلِيمُ، لَا إِلَهَ إِلَّا
                            اللَّهُ رَبُّ الْعَرْشِ الْعَظِيمِ، لَا إِلَهَ إِلَّا اللَّهُ رَبُّ السَّمَاوَاتِ وَرَبُّ
                            الْأَرْضِ وَرَبُّ الْعَرْشِ الْكَرِيمِ</div>
                        <div class="meta">
                            <span>دعاء الكرب</span>
                            <span class="count">مرة واحدة</span>
                        </div>
                    </div>
                    <div class="thikr-card">
                        <div class="arabic-text">يَا حَيُّ يَا قَيُّومُ بِرَحْمَتِكَ أَسْتَغِيثُ</div>
                        <div class="meta">
                            <span>عند الشدة</span>
                            <span class="count">مرة واحدة</span>
                        </div>
                    </div>
                </div>

                <!-- Home Athkar -->
                <div id="home" class="athkar-list">
                    <div class="thikr-card">
                        <div class="arabic-text">بِسْمِ اللهِ وَلَجْنَا، وَبِسْمِ اللهِ خَرَجْنَا، وَعَلَى رَبِّنَا
                            تَوَكَّلْنَا</div>
                        <div class="meta">
                            <span>عند دخول المنزل</span>
                            <span class="count">مرة واحدة</span>
                        </div>
                    </div>
                    <div class="thikr-card">
                        <div class="arabic-text">بِسْمِ اللَّهِ، تَوَكَّلْتُ عَلَى اللَّهِ، وَلَا حَوْلَ وَلَا قُوَّةَ
                            إِلَّا بِاللَّهِ</div>
                        <div class="meta">
                            <span>عند الخروج من المنزل</span>
                            <span class="count">مرة واحدة</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script>
        function switchTab(tab) {
            // Update buttons
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            const btn = document.querySelector(`.tab-btn[onclick="switchTab('${tab}')"]`);
            if (btn) btn.classList.add('active');

            // Update lists
            document.querySelectorAll('.athkar-list').forEach(list => list.classList.remove('active'));
            const target = document.getElementById(tab);
            if (target) target.classList.add('active');
        }

        // Check URL param on load
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');
            if (tab && (tab === 'morning' || tab === 'evening')) {
                switchTab(tab);
            }
        });
    </script>
</body>

</html>