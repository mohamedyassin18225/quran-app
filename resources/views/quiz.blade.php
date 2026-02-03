<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المسابقات الدينية | تطبيق الصلاة</title>
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
            --wrong: #ef4444;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --gold: #fbbf24;
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

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        /* ----- Cards & Layouts ----- */
        .quiz-card {
            background: var(--secondary);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            position: relative;
            display: none;
            /* Hidden by default, toggled via JS */
        }

        .quiz-card.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ----- Home / Categories ----- */
        .category-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        .cat-btn {
            background: rgba(30, 41, 59, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.1);
            color: var(--text-light);
            padding: 20px;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .cat-btn:hover {
            border-color: var(--accent);
            background: rgba(16, 185, 129, 0.1);
            transform: translateY(-2px);
        }

        .cat-icon {
            font-size: 2.5rem;
        }

        .cat-title {
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* ----- Difficulty ----- */
        .diff-btn {
            width: 100%;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 12px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            background: rgba(30, 41, 59, 0.5);
            color: var(--text-light);
            font-family: inherit;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .diff-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .diff-btn.easy {
            border-color: #34d399;
        }

        .diff-btn.medium {
            border-color: #fbbf24;
        }

        .diff-btn.hard {
            border-color: #ef4444;
        }

        /* ----- Quiz Interface ----- */
        .progress-bar-container {
            background: rgba(0, 0, 0, 0.3);
            height: 8px;
            border-radius: 4px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: var(--accent);
            width: 0%;
            transition: width 0.3s;
        }

        .question {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .option-btn {
            background: rgba(30, 41, 59, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.1);
            color: var(--text-light);
            padding: 15px 20px;
            border-radius: 12px;
            font-family: inherit;
            font-size: 1rem;
            text-align: right;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .option-btn:hover {
            border-color: var(--accent);
            background: rgba(16, 185, 129, 0.1);
        }

        .option-btn.correct {
            border-color: var(--accent);
            background: rgba(16, 185, 129, 0.3);
        }

        .option-btn.wrong {
            border-color: var(--wrong);
            background: rgba(239, 68, 68, 0.3);
        }

        /* ----- Results ----- */
        .score-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 8px solid var(--accent);
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 3rem;
            font-weight: bold;
            margin: 0 auto 30px;
            background: rgba(16, 185, 129, 0.1);
        }

        .btn-reset {
            background: var(--accent);
            color: #0f172a;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 700;
            cursor: pointer;
            font-size: 1rem;
            font-family: inherit;
            margin-top: 10px;
        }

        .back-link {
            align-self: flex-end;
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.5rem;
            margin-bottom: 20px;
            cursor: pointer;
        }

        /* Toast */
        .badge-toast {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(-100px);
            background: var(--gold);
            color: #0f172a;
            padding: 15px 25px;
            border-radius: 50px;
            font-weight: 700;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            z-index: 2000;
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge-toast.show {
            transform: translateX(-50%) translateY(50px);
        }
    </style>
</head>

<body>

    <a href="/" class="back-link" id="nav-back">&rarr;</a>

    <div class="container">
        <div class="header">
            <h1>مسابقات دينية</h1>
            <p style="color:var(--text-dim)">اختبر معلوماتك الإسلامية</p>
        </div>

        <!-- 1. Category Selection -->
        <div class="quiz-card active" id="view-home">
            <h2 style="text-align:center; margin-bottom:20px;">اختر مسابقة</h2>
            <div class="category-grid">
                <div class="cat-btn" onclick="selectCategory('quran')">
                    <div class="cat-icon">📖</div>
                    <div class="cat-title">القرآن الكريم</div>
                </div>
                <div class="cat-btn" onclick="selectCategory('seerah')">
                    <div class="cat-icon">🕌</div>
                    <div class="cat-title">السيرة النبوية</div>
                </div>
                <div class="cat-btn" onclick="selectCategory('fiqh')">
                    <div class="cat-icon">⚖️</div>
                    <div class="cat-title">الفقه والعقيدة</div>
                </div>
                <div class="cat-btn" onclick="selectCategory('general')">
                    <div class="cat-icon">💡</div>
                    <div class="cat-title">ثقافة عامة</div>
                </div>
            </div>
        </div>

        <!-- 2. Difficulty Selection -->
        <div class="quiz-card" id="view-difficulty">
            <h2 style="text-align:center; margin-bottom:20px;">اختر المستوى</h2>
            <button class="diff-btn easy" onclick="startGame('easy')">سهل 🟢</button>
            <button class="diff-btn medium" onclick="startGame('medium')">متوسط 🟡</button>
            <button class="diff-btn hard" onclick="startGame('hard')">صعب 🔴</button>
            <button class="btn-reset"
                style="background:transparent; border:1px solid var(--text-dim); color:var(--text-dim); margin-top:20px"
                onclick="showView('view-home')">عودة</button>
        </div>

        <!-- 3. Quiz Interface -->
        <div class="quiz-card" id="view-quiz">
            <div class="progress-bar-container">
                <div class="progress-bar" id="progress"></div>
            </div>

            <div
                style="margin-bottom:10px; color:var(--text-dim); font-size:0.9rem; display:flex; justify-content:space-between;">
                <span>السؤال <span id="q-current">1</span> من <span id="q-total">10</span></span>
                <span id="q-category-label" style="color:var(--accent)"></span>
            </div>

            <div class="question" id="question-text">
                ...
            </div>

            <div class="options" id="options-container">
                <!-- Options here -->
            </div>
        </div>

        <!-- 4. Results -->
        <div class="quiz-card" style="text-align:center;" id="view-result">
            <h2>النتيجة النهائية</h2>
            <div class="score-circle" id="final-score">0%</div>
            <p id="score-msg" style="margin-bottom:30px; font-size:1.1rem; color:var(--text-dim);">...</p>

            <div id="new-badges-area" style="margin-bottom:20px;"></div>

            <button class="btn-reset" onclick="showView('view-home')">القائمة الرئيسية</button>
        </div>
    </div>

    <div id="badgeToast" class="badge-toast">
        <span style="font-size:1.5rem;">🏆</span>
        <span>تم فتح إنجاز جديد!</span>
    </div>

    <script>
        // --- Question Bank ---
        // This would ideally be fetched from an API or a larger JSON file
        const questionBank = {
            quran: {
                easy: [
                    { q: "ما هي السورة التي تعدل ثلث القرآن؟", options: ["الفاتحة", "الإخلاص", "الكافرون", "الناس"], a: 1 },
                    { q: "كم عدد سور القرآن الكريم؟", options: ["110", "112", "114", "116"], a: 2 },
                    { q: "ما هي أطول سورة في القرآن؟", options: ["النساء", "آل عمران", "البقرة", "الأعراف"], a: 2 },
                    { q: "ما هي أقصر سورة في القرآن؟", options: ["الكوثر", "النصر", "العصر", "الإخلاص"], a: 0 },
                    { q: "ما هي السورة التي تسمى قلب القرآن؟", options: ["الملك", "يس", "الرحمن", "الواقعة"], a: 1 }
                ],
                medium: [
                    { q: "كم عدد آيات سورة الفاتحة (مع البسملة)؟", options: ["5", "6", "7", "8"], a: 2 },
                    { q: "في أي جزء تقع سورة النبأ؟", options: ["28", "29", "30", "27"], a: 2 },
                    { q: "ما هي السورة التي لا تبدأ بالبسملة؟", options: ["التوبة", "الأنفال", "محمد", "يونس"], a: 0 },
                    { q: "كم مرة ذكر اسم النبي محمد في القرآن؟", options: ["3", "4", "5", "6"], a: 1 },
                    { q: "ما هي السورة التي ذكرت فيها البسملة مرتين؟", options: ["النحل", "النمل", "النجم", "النساء"], a: 1 }
                ],
                hard: [
                    { q: "ما هي أطول آية في القرآن الكريم؟", options: ["آية الكرسي", "آية الدين", "آية المباهلة", "آية الميراث"], a: 1 },
                    { q: "من هو الصحابي الوحيد الذي ذكر اسمه في القرآن؟", options: ["زيد بن حارثة", "أبو بكر", "عمر بن الخطاب", "علي بن أبي طالب"], a: 0 },
                    { q: "كم عدد السجدات في القرآن الكريم؟", options: ["14", "15", "13", "12"], a: 1 }, // Most common opinion 15
                    { q: "ما هي السورة التي تنتهي آياتها بحرف السين؟", options: ["الناس", "النازعات", "الشمس", "الليل"], a: 0 },
                    { q: "كم عدد الأنبياء المذكورين في القرآن؟", options: ["20", "25", "30", "124000"], a: 1 }
                ]
            },
            seerah: {
                easy: [
                    { q: "من هو خاتم الأنبياء؟", options: ["عيسى", "موسى", "محمد ﷺ", "إبراهيم"], a: 2 },
                    { q: "في أي عام ولد النبي محمد ﷺ؟", options: ["عام الفيل", "عام الحزن", "عام الوفود", "عام الهجرة"], a: 0 },
                    { q: "من هي أم النبي محمد ﷺ؟", options: ["عائشة", "خديجة", "آمنة بنت وهب", "حليمة السعدية"], a: 2 },
                    { q: "أين ولد النبي محمد ﷺ؟", options: ["المدينة", "مكة", "الطائف", "القدس"], a: 1 },
                    { q: "من هو أول من آمن من الرجال؟", options: ["علي بن أبي طالب", "أبو بكر الصديق", "عمر بن الخطاب", "عثمان بن عفان"], a: 1 }
                ],
                medium: [
                    { q: "كم كان عمر النبي ﷺ حين توفي؟", options: ["60", "63", "65", "53"], a: 1 },
                    { q: "من هو كفيل النبي ﷺ بعد وفاة جده؟", options: ["أبو طالب", "أبو لهب", "العباس", "حمزة"], a: 0 },
                    { q: "في أي سنة كانت غزوة بدر؟", options: ["1 هـ", "2 هـ", "3 هـ", "4 هـ"], a: 1 },
                    { q: "من هو الصحابي الذي نام في فراش النبي ليلة الهجرة؟", options: ["أبو بكر", "عمر", "علي", "عثمان"], a: 2 },
                    { q: "ما اسم ناقة الرسول ﷺ في الهجرة؟", options: ["القصواء", "العضباء", "الجدعاء", "الدلدل"], a: 0 }
                ],
                hard: [
                    { q: "من قتل مسيلمة الكذاب؟", options: ["خالد بن الوليد", "وحشي بن حرب", "أبو دجانة", "زيد بن الخطاب"], a: 1 },
                    { q: "كم مرة حج النبي ﷺ؟", options: ["مرة واحدة", "مرتان", "ثلاث مرات", "لم يحج"], a: 0 },
                    { q: "من هو أمين هذه الأمة؟", options: ["أبو عبيدة بن الجراح", "سعد بن معاذ", "سالم مولى أبي حذيفة", "مصعب بن عمير"], a: 0 },
                    { q: "في أي سنة فرض الصيام؟", options: ["1 هـ", "2 هـ", "3 هـ", "4 هـ"], a: 1 },
                    { q: "من هي آخر زوجات النبي ﷺ وفاة؟", options: ["عائشة", "حفصة", "أم سلمة", "زينب بنت جحش"], a: 2 }
                ]
            },
            fiqh: {
                easy: [
                    { q: "ما هو الركن الثاني من أركان الإسلام؟", options: ["الشهادتان", "الصلاة", "الزكاة", "الصوم"], a: 1 },
                    { q: "كم عدد الصلوات المفروضة في اليوم؟", options: ["3", "4", "5", "6"], a: 2 },
                    { q: "ما هي الصلاة التي ليس فيها ركوع ولا سجود؟", options: ["الجمعة", "العيد", "الجنازة", "الخسوف"], a: 2 },
                    { q: "شهر الصيام هو شهر؟", options: ["شعبان", "رمضان", "رجب", "محرم"], a: 1 },
                    { q: "الوضوء واجب قبل؟", options: ["النوم", "الأكل", "الصلاة", "السفر"], a: 2 }
                ],
                medium: [
                    { q: "أقل نصاب الذهب للزكاة هو؟", options: ["20 جرام", "50 جرام", "85 جرام", "100 جرام"], a: 2 },
                    { q: "صلاة الكسوف تكون عند ذهاب ضوء؟", options: ["الشمس", "القمر", "النجوم", "النهار"], a: 0 },
                    { q: "يوم عرفة هو يوم؟", options: ["8 ذو الحجة", "9 ذو الحجة", "10 ذو الحجة", "11 ذو الحجة"], a: 1 },
                    { q: "عدة المرأة المتوفى عنها زوجها؟", options: ["3 قروء", "4 أشهر و10 أيام", "سنة كاملة", "3 أشهر"], a: 1 },
                    { q: "من مبطلات الصلاة؟", options: ["الضحك بصوت", "التبسم", "النظر للسماء", "حك الأنف"], a: 0 }
                ],
                hard: [
                    { q: "صلاة الوتر حكمها عند الجمهور؟", options: ["فرض عين", "سنة مؤكدة", "مباحة", "واجبة"], a: 1 },
                    { q: "أقل مدة للحيض عند الشافعية؟", options: ["ساعة", "يوم وليلة", "3 أيام", "7 أيام"], a: 1 },
                    { q: "ما هو الميقات المكاني لأهل مصر والشام؟", options: ["ذو الحليفة", "الجحفة", "قرن المنازل", "يلملم"], a: 1 },
                    { q: "زكاة الفطر تجب على؟", options: ["الغني فقط", "البالغ فقط", "كل مسلم قادر", "المزكى عنه"], a: 2 },
                    { q: "كم عدد تكبيرات صلاة الجنازة؟", options: ["3", "4", "5", "2"], a: 1 }
                ]
            },
            general: {
                easy: [
                    { q: "من هو أول مؤذن في الإسلام؟", options: ["بلال بن رباح", "أبو بكر", "عمر", "عثمان"], a: 0 },
                    { q: "ما هو الكتاب المنزل على عيسى عليه السلام؟", options: ["التوراة", "الإنجيل", "الزبور", "القرآن"], a: 1 },
                    { q: "من هو أبو البشر؟", options: ["نوح", "إبراهيم", "آدم", "موسى"], a: 2 },
                    { q: "كم عدد خلفاء الراشدين؟", options: ["3", "4", "5", "6"], a: 1 },
                    { q: "القرآن نزل باللغة؟", options: ["العربية", "العبرية", "السريانية", "الفارسية"], a: 0 }
                ],
                medium: [
                    { q: "من هو الملقب بذي النورين؟", options: ["عمر بن الخطاب", "عثمان بن عفان", "علي بن أبي طالب", "زيد بن حارثة"], a: 1 },
                    { q: "ما هي أول عاصمة في الإسلام؟", options: ["مكة", "المدينة", "دمشق", "الكوفة"], a: 1 },
                    { q: "من هو قائد معركة القادسية؟", options: ["خالد بن الوليد", "سعد بن أبي وقاص", "أبو عبيدة", "عمرو بن العاص"], a: 1 },
                    { q: "كم سنة استمر نزول القرآن؟", options: ["20", "23", "25", "40"], a: 1 },
                    { q: "من هي أول شهيدة في الإسلام؟", options: ["خديجة", "سمية بنت خياط", "أسماء بنت أبي بكر", "نسيبة بنت كعب"], a: 1 }
                ],
                hard: [
                    { q: "من هو حبر الأمة وترجمان القرآن؟", options: ["عبدالله بن عمر", "عبدالله بن عباس", "عبدالله بن مسعود", "أبي بن كعب"], a: 1 },
                    { q: "في أي سنة تحولت القبلة؟", options: ["1 هـ", "2 هـ", "3 هـ", "4 هـ"], a: 1 },
                    { q: "من هو الصحابي الذي اهتز العرش لوفاته؟", options: ["سعد بن معاذ", "مصعب بن عمير", "جعفر الطيار", "حمزة بن عبدالمطلب"], a: 0 },
                    { q: "ما اسم الدابة التي ركبها النبي في الإسراء؟", options: ["البراق", "القصواء", "الجمل", "اليعفور"], a: 0 },
                    { q: "من هو النبي الذي ابتلعه الحوت؟", options: ["موسى", "عيسى", "يونس", "يوسف"], a: 2 }
                ]
            }
        };

        // --- State ---
        let currentCategory = null;
        let currentDifficulty = null;
        let currentQuestions = [];
        let currentIndex = 0;
        let score = 0;
        let answered = false;

        // --- Navigation ---
        function showView(id) {
            document.querySelectorAll('.quiz-card').forEach(el => el.classList.remove('active'));
            document.getElementById(id).classList.add('active');

            // Handle Back Button
            const backBtn = document.getElementById('nav-back');
            if (id === 'view-home') {
                backBtn.style.visibility = 'visible';
                backBtn.href = '/';
                backBtn.onclick = null;
            } else if (id === 'view-difficulty') {
                backBtn.style.visibility = 'visible';
                backBtn.removeAttribute('href');
                backBtn.onclick = () => showView('view-home');
            } else if (id === 'view-quiz') {
                backBtn.style.visibility = 'hidden'; // Lock them in quiz
            } else {
                backBtn.style.visibility = 'visible';
                backBtn.href = '/';
                backBtn.onclick = null;
            }
        }

        // --- Logic ---
        function selectCategory(cat) {
            currentCategory = cat;
            showView('view-difficulty');
        }

        function startGame(diff) {
            currentDifficulty = diff;

            // Get questions for cat/diff
            // If we run out of questions, maybe fallback or repeat (simplified for now)
            const pool = questionBank[currentCategory][currentDifficulty] || [];

            // Shuffle
            currentQuestions = [...pool].sort(() => Math.random() - 0.5);

            // Limit to 5 or 10? Let's do 5 for quick play
            currentQuestions = currentQuestions.slice(0, 5);

            if (currentQuestions.length === 0) {
                alert("عذراً، لا توجد أسئلة كافية في هذا القسم حالياً.");
                return;
            }

            currentIndex = 0;
            score = 0;
            answered = false;

            // Updates
            const catNames = { quran: "القرآن الكريم", seerah: "السيرة النبوية", fiqh: "الفقه", general: "ثقافة عامة" };
            document.getElementById('q-category-label').innerText = catNames[currentCategory] + " (" + diff + ")";
            document.getElementById('q-total').innerText = currentQuestions.length;

            showView('view-quiz');
            renderQuestion();
        }

        function renderQuestion() {
            answered = false;
            const q = currentQuestions[currentIndex];

            document.getElementById('q-current').innerText = currentIndex + 1;
            document.getElementById('question-text').innerText = q.q;

            // Progress bar
            const pct = (currentIndex / currentQuestions.length) * 100;
            document.getElementById('progress').style.width = pct + '%';

            const container = document.getElementById('options-container');
            container.innerHTML = '';

            q.options.forEach((opt, idx) => {
                const btn = document.createElement('button');
                btn.className = 'option-btn';
                btn.innerText = opt;
                btn.onclick = () => checkAnswer(idx, btn);
                container.appendChild(btn);
            });
        }

        function checkAnswer(selectedIndex, btn) {
            if (answered) return;
            answered = true;

            const q = currentQuestions[currentIndex];
            const options = document.querySelectorAll('.option-btn');

            if (selectedIndex === q.a) {
                btn.classList.add('correct');
                score++;
            } else {
                btn.classList.add('wrong');
                options[q.a].classList.add('correct');
            }

            setTimeout(() => {
                currentIndex++;
                if (currentIndex < currentQuestions.length) {
                    renderQuestion();
                } else {
                    finishQuiz();
                }
            }, 1500);
        }

        function finishQuiz() {
            showView('view-result');
            const total = currentQuestions.length;
            const pct = Math.round((score / total) * 100);

            document.getElementById('final-score').innerText = pct + '%';

            let msg = "";
            if (pct === 100) msg = "ما شاء الله! إجابات مثالية! 🌟";
            else if (pct >= 80) msg = "ممتاز! معلوماتك قوية! 👏";
            else if (pct >= 50) msg = "جيد! واصل التعلم. 📚";
            else msg = "حاول مرة أخرى لتستفيد أكثر. 💪";

            document.getElementById('score-msg').innerText = msg;

            // Gamification & Badges
            checkQuizAchievements(pct);
        }

        // --- Badges Logic (Reusing LocalStorage from Tracker) ---
        function getMyBadges() {
            return JSON.parse(localStorage.getItem('my_badges') || '[]');
        }

        function unlockBadge(badgeId, badgeName) {
            const myBadges = getMyBadges();
            if (!myBadges.includes(badgeId)) {
                myBadges.push(badgeId);
                localStorage.setItem('my_badges', JSON.stringify(myBadges));

                showBadgeToast(badgeName);

                // Show in results
                const area = document.getElementById('new-badges-area');
                area.innerHTML += `<div style="color:var(--gold); font-weight:bold;">🏆 تم فتح إنجاز: ${badgeName}</div>`;
            }
        }

        function showBadgeToast(name) {
            const toast = document.getElementById('badgeToast');
            toast.children[1].innerText = `إنجاز جديد: ${name}`;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 4000);
        }

        function checkQuizAchievements(pct) {
            // Track total quizzes played
            let totalPlayed = parseInt(localStorage.getItem('quiz_total_played') || '0');
            totalPlayed++;
            localStorage.setItem('quiz_total_played', totalPlayed);

            // 1. Knowledge Seeker (First Play)
            if (totalPlayed >= 1) unlockBadge('quiz_starter', 'طالب علم');

            // 2. Scholar (5 Quizzes)
            if (totalPlayed >= 5) unlockBadge('quiz_champion', 'بطل المسابقات');

            // 3. Perfect Scores (Specific Categories)
            if (pct === 100) {
                if (currentCategory === 'quran') unlockBadge('quran_master', 'حافظ القرآن');
                if (currentCategory === 'seerah') unlockBadge('seerah_expert', 'عالم السيرة');
                // History/General could map to other badges if we added them
            }
        }

    </script>
</body>

</html>