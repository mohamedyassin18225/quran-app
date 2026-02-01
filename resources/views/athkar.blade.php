<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athkar | Morning & Evening</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&family=Amiri:wght@400;700&display=swap"
        rel="stylesheet">
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
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #020617 100%);
            color: var(--text-light);
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            margin: 0;
            padding: 20px;
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
            left: 0;
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
            font-weight: 600;
            font-size: 1.8rem;
            letter-spacing: 1px;
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
            font-family: 'Outfit', sans-serif;
            font-weight: 500;
            transition: all 0.3s;
        }

        .tab-btn.active {
            background: var(--accent);
            color: #0f172a;
            font-weight: 600;
        }

        .athkar-list {
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in;
        }

        .athkar-list.active {
            display: block;
            opacity: 1;
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
            line-height: 1.8;
            margin-bottom: 15px;
            color: #e2e8f0;
        }

        .translation {
            font-size: 0.95rem;
            color: var(--text-dim);
            line-height: 1.5;
            margin-bottom: 10px;
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
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Back
            </a>
            <h1>Athkar</h1>
        </div>

        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('morning')">Morning</button>
            <button class="tab-btn" onclick="switchTab('evening')">Evening</button>
        </div>

        <!-- Morning Athkar -->
        <div id="morning" class="athkar-list active">
            <div class="thikr-card">
                <div class="arabic-text">اللَّهُ لَا إِلَٰهَ إِلَّا هُوَ الْحَيُّ الْقَيُّومُ ۚ لَا تَأْخُذُهُ سِنَةٌ وَلَا نَوْمٌ ۚ لَّهُ مَا فِي السَّمَاوَاتِ وَمَا فِي الْأَرْضِ ۗ مَن ذَا الَّذِي يَشْفَعُ عِندَهُ إِلَّا بِإِذْنِهِ ۚ يَعْلَمُ مَا بَيْنَ أَيْدِيهِمْ وَمَا خَلْفَهُمْ ۖ وَلَا يُحِيطُونَ بِشَيْءٍ مِّنْ عِلْمِهِ إِلَّا بِمَا شَاءَ ۚ وَسِعَ كُرْسِيُّهُ السَّمَاوَاتِ وَالْأَرْضَ ۖ وَلَا يَئُودُهُ حِفْظُهُمَا ۚ وَهُوَ الْعَلِيُّ الْعَظِيمُ</div>
                <div class="translation"><strong>Ayat Al-Kursi:</strong> Allah! There is no god but He, the Ever Living, the Sustainer of all existence...</div>
                <div class="meta">
                    <span>Recite 1x</span>
                    <span class="count">1x</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">
                    قُلْ هُوَ اللَّهُ أَحَدٌ ... <br>
                    قُلْ أَعُوذُ بِرَبِّ الْفَلَقِ ... <br>
                    قُلْ أَعُوذُ بِرَبِّ النَّاسِ ...
                </div>
                <div class="translation"><strong>The 3 Quls:</strong> Surah Al-Ikhlas, Surah Al-Falaq, and Surah An-Nas.</div>
                <div class="meta">
                    <span>Recite 3x each</span>
                    <span class="count">3x</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">أَصْبَحْنَا وَأَصْبَحَ الْمُلْكُ لِلَّهِ، وَالْحَمْدُ لِلَّهِ، لاَ إِلَـهَ إِلاَّ اللهُ وَحْدَهُ لاَ شَرِيكَ لَهُ، لَهُ الْمُلْكُ وَلَهُ الْحَمْدُ وَهُوَ عَلَى كُلِّ شَيْءٍ قَدِيرٌ.  رَبِّ أَسْأَلُكَ خَيْرَ مَا فِي هَذَا الْيَوْمِ وَخَيْرَ مَا بَعْدَهُ، وَأَعُوذُ بِكَ مِنْ شَرِّ مَا فِي هَذَا الْيَوْمِ وَشَرِّ مَا بَعْدَهُ...</div>
                <div class="translation">We have reached the morning and at this very time unto Allah belongs all sovereignty, and all praise is for Allah. None has the right to be worshipped except Allah...</div>
                <div class="meta">
                    <span>Muslim 4/2088</span>
                    <span class="count">1x</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">اللَّهُمَّ بِكَ أَصْبَحْنَا وَبِكَ أَمْسَيْنَا ، وَبِكَ نَحْيَا وَبِكَ نَمُوتُ وَإِلَيْكَ النُّشُورُ</div>
                <div class="translation">O Allah, by You we enter the morning and by You we enter the evening, by You we live and by You we die, and to You is the Final Return.</div>
                <div class="meta">
                    <span>Tirmidhi 3/142</span>
                    <span class="count">1x</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">اللَّهُمَّ أَنْتَ رَبِّي لَا إِلَهَ إِلَّا أَنْتَ، خَلَقْتَنِي وَأَنَا عَبْدُكَ، وَأَنَا عَلَى عَهْدِكَ وَوَعْدِكَ مَا اسْتَطَعْتُ، أَعُوذُ بِكَ مِنْ شَرِّ مَا صَنَعْتُ، أَبُوءُ لَكَ بِنِعْمَتِكَ عَلَيَّ، وَأَبُوءُ لَكَ بِذَنْبِي فَاغْفِرْ لِي فَإِنَّهُ لَا يَغْفِرُ الذُّنُوبَ إِلَّا أَنْتَ</div>
                <div class="translation"><strong>Sayyidul Istighfar:</strong> O Allah, You are my Lord, none has the right to be worshipped except You. You created me and I am Your servant...</div>
                <div class="meta">
                    <span>Bukhari 7/150</span>
                    <span class="count">1x</span>
                </div>
            </div>
            
             <div class="thikr-card">
                <div class="arabic-text">بِسْمِ اللهِ الَّذِي لَا يَضُرُّ مَعَ اسْمِهِ شَيْءٌ فِي الْأَرْضِ وَلَا فِي السَّمَاءِ وَهُوَ السَّمِيعُ الْعَلِيمُ</div>
                <div class="translation">In the Name of Allah, Who with His Name nothing can cause harm in the earth nor in the heavens, and He is the All-Hearing, the All-Knowing.</div>
                <div class="meta">
                    <span>Abu Dawood</span>
                    <span class="count">3x</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">رَضِيتُ بِاللَّهِ رَبًّا، وَبِالْإِسْلَامِ دِينًا، وَبِمُحَمَّدٍ نَبِيًّا</div>
                <div class="translation">I am pleased with Allah as my Lord, with Islam as my religion and with Muhammad (peace and blessings of Allah be upon him) as my Prophet.</div>
                <div class="meta">
                    <span>Abu Dawood 4/318</span>
                    <span class="count">3x</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">سُبْحَانَ اللَّهِ وَبِحَمْدِهِ</div>
                <div class="translation">Glory is to Allah and to Him is the praise.</div>
                <div class="meta">
                    <span>Muslim 4/2071</span>
                    <span class="count">100x</span>
                </div>
            </div>

             <div class="thikr-card">
                <div class="arabic-text">يَا حَيُّ يَا قَيُّومُ بِرَحْمَتِكَ أَسْتَغِيثُ أَصْلِحْ لِي شَأْنِي كُلَّهُ وَلَا تَكِلْنِي إِلَى نَفْسِي طَرْفَةَ عَيْنٍ</div>
                <div class="translation">O Ever Living One, O Eternal One, by Your mercy I call on You to set right all my affairs. Do not place me in charge of my soul even for the blinking of an eye.</div>
                <div class="meta">
                    <span>Hakim 1/545</span>
                    <span class="count">1x</span>
                </div>
            </div>
        </div>

        <!-- Evening Athkar -->
        <div id="evening" class="athkar-list">

             <div class="thikr-card">
                <div class="arabic-text">اللَّهُ لَا إِلَٰهَ إِلَّا هُوَ الْحَيُّ الْقَيُّومُ ۚ لَا تَأْخُذُهُ سِنَةٌ وَلَا نَوْمٌ...</div>
                <div class="translation"><strong>Ayat Al-Kursi:</strong> Allah! There is no god but He, the Ever Living, the Sustainer of all existence...</div>
                <div class="meta">
                    <span>Recite 1x</span>
                    <span class="count">1x</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">
                    قُلْ هُوَ اللَّهُ أَحَدٌ ... <br>
                    قُلْ أَعُوذُ بِرَبِّ الْفَلَقِ ... <br>
                    قُلْ أَعُوذُ بِرَبِّ النَّاسِ ...
                </div>
                <div class="translation"><strong>The 3 Quls:</strong> Surah Al-Ikhlas, Surah Al-Falaq, and Surah An-Nas.</div>
                <div class="meta">
                    <span>Recite 3x each</span>
                    <span class="count">3x</span>
                </div>
            </div>

             <div class="thikr-card">
                <div class="arabic-text">أَمْسَيْنَا وَأَمْسَى الْمُلْكُ لِلَّهِ، وَالْحَمْدُ لِلَّهِ، لاَ إِلَـهَ إِلاَّ اللهُ وَحْدَهُ لاَ شَرِيكَ لَهُ، لَهُ الْمُلْكُ وَلَهُ الْحَمْدُ وَهُوَ عَلَى كُلِّ شَيْءٍ قَدِيرٌ.  رَبِّ أَسْأَلُكَ خَيْرَ مَا فِي هَذِهِ اللَّيْلَةِ وَخَيْرَ مَا بَعْدَهَا، وَأَعُوذُ بِكَ مِنْ شَرِّ مَا فِي هَذِهِ اللَّيْلَةِ وَشَرِّ مَا بَعْدَهَا...</div>
                <div class="translation">We have reached the evening and at this very time unto Allah belongs all sovereignty, and all praise is for Allah. None has the right to be worshipped except Allah...</div>
                <div class="meta">
                    <span>Muslim 4/2088</span>
                    <span class="count">1x</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">اللَّهُمَّ بِكَ أَمْسَيْنَا وَبِكَ أَصْبَحْنَا ، وَبِكَ نَحْيَا وَبِكَ نَمُوتُ وَإِلَيْكَ الْمَصِيرُ</div>
                <div class="translation">O Allah, by You we enter the evening and by You we enter the morning, by You we live and by You we die, and to You is the final return.</div>
                <div class="meta">
                    <span>Tirmidhi 3/142</span>
                    <span class="count">1x</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">اللَّهُمَّ أَنْتَ رَبِّي لَا إِلَهَ إِلَّا أَنْتَ، خَلَقْتَنِي وَأَنَا عَبْدُكَ...</div>
                <div class="translation"><strong>Sayyidul Istighfar:</strong> O Allah, You are my Lord, none has the right to be worshipped except You. You created me and I am Your servant...</div>
                <div class="meta">
                    <span>Bukhari 7/150</span>
                    <span class="count">1x</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">أَعُوذُ بِكَلِمَاتِ اللهِ التَّامَّاتِ مِنْ شَرِّ مَا خَلَقَ</div>
                <div class="translation">I seek protection in the Perfect Words of Allah from every evil that He has created.</div>
                <div class="meta">
                    <span>Muslim 4/2080</span>
                    <span class="count">3x</span>
                </div>
            </div>

             <div class="thikr-card">
                <div class="arabic-text">بِسْمِ اللهِ الَّذِي لَا يَضُرُّ مَعَ اسْمِهِ شَيْءٌ فِي الْأَرْضِ وَلَا فِي السَّمَاءِ وَهُوَ السَّمِيعُ الْعَلِيمُ</div>
                <div class="translation">In the Name of Allah, Who with His Name nothing can cause harm in the earth nor in the heavens, and He is the All-Hearing, the All-Knowing.</div>
                <div class="meta">
                    <span>Abu Dawood</span>
                    <span class="count">3x</span>
                </div>
            </div>

            <div class="thikr-card">
                <div class="arabic-text">رَضِيتُ بِاللَّهِ رَبًّا، وَبِالْإِسْلَامِ دِينًا، وَبِمُحَمَّدٍ نَبِيًّا</div>
                <div class="translation">I am pleased with Allah as my Lord, with Islam as my religion and with Muhammad (peace and blessings of Allah be upon him) as my Prophet.</div>
                <div class="meta">
                    <span>Abu Dawood 4/318</span>
                    <span class="count">3x</span>
                </div>
            </div>

             <div class="thikr-card">
                <div class="arabic-text">سُبْحَانَ اللَّهِ وَبِحَمْدِهِ</div>
                <div class="translation">Glory is to Allah and to Him is the praise.</div>
                <div class="meta">
                    <span>Muslim 4/2071</span>
                    <span class="count">100x</span>
                </div>
            </div>

             <div class="thikr-card">
                <div class="arabic-text">يَا حَيُّ يَا قَيُّومُ بِرَحْمَتِكَ أَسْتَغِيثُ أَصْلِحْ لِي شَأْنِي كُلَّهُ وَلَا تَكِلْنِي إِلَى نَفْسِي طَرْفَةَ عَيْنٍ</div>
                <div class="translation">O Ever Living One, O Eternal One, by Your mercy I call on You to set right all my affairs. Do not place me in charge of my soul even for the blinking of an eye.</div>
                <div class="meta">
                    <span>Hakim 1/545</span>
                    <span class="count">1x</span>
                </div>
            </div>

        </div>

    </div>

    <script>
        function switchTab(tab) {
            // Update buttons
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Update lists
            document.querySelectorAll('.athkar-list').forEach(list => {
                list.style.opacity = '0';
                setTimeout(() => {
                    list.classList.remove('active');
                    if (list.id === tab) {
                        list.classList.add('active');
                        setTimeout(() => list.style.opacity = '1', 50);
                    }
                }, 300);
            });

            // For simple instant switch if needed (removing transition delay logic above for simpler feel):
            document.querySelectorAll('.athkar-list').forEach(list => list.classList.remove('active'));
            document.getElementById(tab).classList.add('active');
            // Re-apply opacity
            document.querySelectorAll('.athkar-list').forEach(list => list.style.opacity = list.classList.contains('active') ? '1' : '0');
        }
    </script>
</body>

</html>