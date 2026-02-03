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

        .quiz-card {
            background: var(--secondary);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            position: relative;
        }

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

        .score-box {
            text-align: center;
            display: none;
        }

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
            <h1>مسابقات دينية</h1>
            <p style="color:var(--text-dim)">اختبر معلوماتك الإسلامية</p>
        </div>

        <div class="quiz-card" id="quiz-box">
            <div class="progress-bar-container">
                <div class="progress-bar" id="progress"></div>
            </div>

            <div style="margin-bottom:10px; color:var(--text-dim); font-size:0.9rem;">
                السؤال <span id="q-current">1</span> من <span id="q-total">10</span>
            </div>

            <div class="question" id="question-text">
                ...
            </div>

            <div class="options" id="options-container">
                <!-- Options here -->
            </div>
        </div>

        <div class="quiz-card score-box" id="score-box">
            <h2>النتيجة النهائية</h2>
            <div class="score-circle" id="final-score">0%</div>
            <p id="score-msg" style="margin-bottom:30px; font-size:1.1rem; color:var(--text-dim);">...</p>
            <button class="btn-reset" onclick="restartQuiz()">إعادة المحاولة</button>
        </div>
    </div>

    <script>
        const questions = [
            {
                q: "ما هي السورة التي تعدل ثلث القرآن؟",
                options: ["سورة الفاتحة", "سورة الإخلاص", "سورة الكافرون", "سورة الناس"],
                answer: 1 // 0-indexed
            },
            {
                q: "من هو النبي الذي ألقي في النار ولم تحرقه؟",
                options: ["موسى عليه السلام", "عيسى عليه السلام", "إبراهيم عليه السلام", "نوح عليه السلام"],
                answer: 2
            },
            {
                q: "كم عدد سور القرآن الكريم؟",
                options: ["110 سورة", "112 سورة", "114 سورة", "116 سورة"],
                answer: 2
            },
            {
                q: "ما هي الصلاة التي ليس فيها ركوع ولا سجود؟",
                options: ["صلاة العيد", "صلاة الجنازة", "صلاة الوتر", "صلاة الضحى"],
                answer: 1
            },
            {
                q: "من هو أول مؤذن في الإسلام؟",
                options: ["بلال بن رباح", "أبو بكر الصديق", "عمر بن الخطاب", "عثمان بن عفان"],
                answer: 0
            },
            {
                q: "ما هي أطول سورة في القرآن الكريم؟",
                options: ["النساء", "آل عمران", "البقرة", "الأعراف"],
                answer: 2
            },
            {
                q: "في أي عام كانت غزوة بدر؟",
                options: ["السنة الأولى للهجرة", "السنة الثانية للهجرة", "السنة الثالثة للهجرة", "السنة الرابعة للهجرة"],
                answer: 1
            },
            {
                q: "من هو خاتم الأنبياء والمرسلين؟",
                options: ["عيسى عليه السلام", "موسى عليه السلام", "محمد صلى الله عليه وسلم", "إبراهيم عليه السلام"],
                answer: 2
            },
            {
                q: "ما هو الركن الخامس من أركان الإسلام؟",
                options: ["الزكاة", "الصوم", "الحج", "الشهادتان"],
                answer: 2
            },
            {
                q: "من هو الصحابي الذي تستحي منه الملائكة؟",
                options: ["عمر بن الخطاب", "عثمان بن عفان", "علي بن أبي طالب", "أبو بكر الصديق"],
                answer: 1
            }
        ];

        let currentQuestion = 0;
        let score = 0;
        let answered = false;

        function init() {
            currentQuestion = 0;
            score = 0;
            answered = false;

            // Shuffle questions slightly? Or keep static for now. 
            // Better to shuffle for replayability.
            // questions.sort(() => Math.random() - 0.5); 

            document.getElementById('quiz-box').style.display = 'block';
            document.getElementById('score-box').style.display = 'none';
            document.getElementById('q-total').innerText = questions.length;

            showQuestion();
        }

        function showQuestion() {
            answered = false;
            const q = questions[currentQuestion];

            document.getElementById('q-current').innerText = currentQuestion + 1;
            document.getElementById('question-text').innerText = q.q;

            // Progress
            const pct = ((currentQuestion) / questions.length) * 100;
            document.getElementById('progress').style.width = pct + '%';

            const container = document.getElementById('options-container');
            container.innerHTML = '';

            q.options.forEach((opt, index) => {
                const btn = document.createElement('button');
                btn.className = 'option-btn';
                btn.innerText = opt;
                btn.onclick = () => checkAnswer(index, btn);
                container.appendChild(btn);
            });
        }

        function checkAnswer(selectedIndex, btn) {
            if (answered) return;
            answered = true;

            const q = questions[currentQuestion];
            const options = document.querySelectorAll('.option-btn');

            if (selectedIndex === q.answer) {
                btn.classList.add('correct');
                score++;
            } else {
                btn.classList.add('wrong');
                // Show corect one
                options[q.answer].classList.add('correct');
            }

            // Next question delay
            setTimeout(() => {
                currentQuestion++;
                if (currentQuestion < questions.length) {
                    showQuestion();
                } else {
                    showResults();
                }
            }, 1500);
        }

        function showResults() {
            document.getElementById('quiz-box').style.display = 'none';
            document.getElementById('score-box').style.display = 'block';

            const pct = Math.round((score / questions.length) * 100);
            document.getElementById('final-score').innerText = pct + '%';

            let msg = "";
            if (pct === 100) msg = "ممتاز! معلوماتك دينية رائعة! 🌟";
            else if (pct >= 80) msg = "جيد جداً! أحسنت! 👏";
            else if (pct >= 50) msg = "جيد! واصل التعلم. 📚";
            else msg = "حاول مرة أخرى لتتعلم المزيد. 💪";

            document.getElementById('score-msg').innerText = msg;
        }

        function restartQuiz() {
            init();
        }

        init();
    </script>

</body>

</html>