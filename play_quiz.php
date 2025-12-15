<?php
include 'config/database.php';
session_start();
$quiz_id = isset($_GET['id']) ? $_GET['id'] : 1;

$query_info = mysqli_query($conn, "SELECT * FROM daftar_quiz WHERE id = '$quiz_id'");
$info_quiz = mysqli_fetch_assoc($query_info);

$query_soal = mysqli_query($conn, "SELECT * FROM soal_quiz WHERE quiz_id = '$quiz_id'");
$soal_array = [];
while ($row = mysqli_fetch_assoc($query_soal)) {
    $soal_array[] = $row;
}

$json_soal = json_encode($soal_array);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playing - <?php echo $info_quiz['judul']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/play_quiz.css"> <link rel="stylesheet" href="assets/css/play.css">    </head>
<body>
    <div class="body">
    <header>
        <p>SulaPedia</p>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="jelajah.php">Jelajahi</a></li>
                <li><a href="quiz.php">Quiz</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <?php if(isset($_SESSION['status']) && $_SESSION['status'] == "login"): ?>
                <span style="margin-right: 10px; font-weight: 500;">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a href="logout.php" style="background-color: #8B0000; color: white; padding: 8px 15px; border-radius: 20px; text-decoration: none; font-size: 14px;">Logout</a>
            <?php else: ?>
                <a href="login.php" style="background-color: #49574A; color: #FEFAE0; padding: 8px 20px; border-radius: 20px; text-decoration: none; font-weight: bold;">Login</a>
            <?php endif; ?>
            </div>
         <div class="hamburger-menu" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

       
        <div class="header-text">
            <h1>Sulapedia Quiz</h1>
            <p>Uji pengetahuanmu tentang Sulawesi!</p>
        </div>

        <div class="game-card">
            
            <div class="game-header">
                <div class="question-counter">
                    <h2>Soal <span id="current-no">1</span>/<span id="total-no">10</span></h2>
                </div>
                <div class="category-badge">
                    <?php echo $info_quiz['kategori']; ?>
                </div>
            </div>

            <div class="progress-track">
                <div class="progress-fill" id="progress-fill"></div>
            </div>

            <div class="question-area">
                <p id="question-text">Loading Soal...</p>
            </div>

            <div class="options-area" id="options-container">
                </div>

            <div class="game-footer">
                <button id="btn-prev" onclick="prevQuestion()" disabled>&larr; Sebelumnya</button>
                <button id="btn-next" onclick="nextQuestion()">Selanjutnya &rarr;</button>
            </div>

        </div>

        <form id="score-form" action="result.php" method="POST" style="display:none;">
            <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
            <input type="hidden" name="score" id="final-score">
        </form>

    </main>
</div>
    <?php include("includes/footer.php/footer.php")?>

    <script>
        const questions = <?php echo $json_soal; ?>;
        let currentIdx = 0;
        let userAnswers = new Array(questions.length).fill(null);

        const elNo = document.getElementById('current-no');
        const elTotal = document.getElementById('total-no');
        const elQuestion = document.getElementById('question-text');
        const elOptions = document.getElementById('options-container');
        const elProgress = document.getElementById('progress-fill');
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');

        elTotal.innerText = questions.length;
        loadQuestion(0);

        function loadQuestion(index) {
            const q = questions[index];
            elNo.innerText = index + 1;
            elQuestion.innerText = q.pertanyaan;

            const percent = ((index + 1) / questions.length) * 100;
            elProgress.style.width = percent + '%';

            elOptions.innerHTML = '';
            const opsis = [
                { key: 'A', text: q.opsi_a },
                { key: 'B', text: q.opsi_b },
                { key: 'C', text: q.opsi_c },
                { key: 'D', text: q.opsi_d }
            ];

            opsis.forEach(op => {
                const btn = document.createElement('div');
                btn.className = 'option-btn';
               
                if (userAnswers[index] === op.key) {
                    btn.classList.add('selected');
                }
                
                btn.onclick = () => selectOption(index, op.key);
                
                btn.innerHTML = `
                    <div class="circle-letter">${op.key}</div>
                    <div class="option-text">${op.text}</div>
                `;
                elOptions.appendChild(btn);
            });
            btnPrev.disabled = (index === 0);
            if (index === questions.length - 1) {
                btnNext.innerText = 'Selesai';
            } else {
                btnNext.innerText = 'Selanjutnya \u2192';
            }
        }

        function selectOption(qIndex, answer) {
            userAnswers[qIndex] = answer;
            loadQuestion(qIndex); 
        }

        function nextQuestion() {
            if (currentIdx < questions.length - 1) {
                currentIdx++;
                loadQuestion(currentIdx);
            } else {
                finishQuiz();
            }
        }

        function prevQuestion() {
            if (currentIdx > 0) {
                currentIdx--;
                loadQuestion(currentIdx);
            }
        }

        function finishQuiz() {
            let score = 0;
            questions.forEach((q, i) => {
                if (userAnswers[i] === q.jawaban_benar) {
                    score++;
                }
            });

            alert('Quiz Selesai! Skor Kamu: ' + score + '/' + questions.length);
            window.location.href = "quiz.php";
        }
        
        function toggleMenu() {
            const menu = document.querySelector('.nav-links');
            menu.classList.toggle('active');
        }
    </script>
</body>
</html>