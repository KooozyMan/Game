<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>حروف وألوف</title>
    <?php $this->load->view('partials/header'); ?>
</head>

<body>
    <div class="board">
        <?php
        $cols = count($grid[0] ?? []);
        $rows = count($grid);
        ?>

        <?php foreach ($grid as $colIndex => $row): ?>
            <div class="hex-column <?= $colIndex % 2 == 1 ? 'offset' : '' ?>">
                <?php foreach ($row as $cell): ?>

                    <?php if (!isset($cell['id']))
                        continue; ?>

                    <?php if ($cell['id'] === -1): ?>
                        <div class="hexagon-button green-edge"></div>
                    <?php elseif ($cell['id'] === 0): ?>
                        <div class="hexagon-button red-edge"></div>
                    <?php else: ?>
                        <button class="hexagon-button" data-id="<?= $cell['id'] ?>"
                            data-letter="<?= htmlspecialchars($cell['letter'], ENT_QUOTES) ?>">
                            <?= htmlspecialchars($cell['letter'], ENT_QUOTES) ?>
                        </button>
                    <?php endif; ?>

                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="overlay" onclick="closePopUp()"></div>
    <div id="pop-up" style="display:none;">
        <form>
            <h2 id="display_letter" class="letter-showcase"></h2>
            <select id="type" class="types">
                <option value="">-- Select --</option>
                <?php foreach ($types as $t): ?>
                    <option value="<?= $t['type_id'] ?>"><?= $t['type'] ?></option>
                <?php endforeach; ?>
            </select>
            <button id="question-curtain" type="button" onclick="showQuestion()" class="question-curtain"></button>
            <textarea id="question" class="question" style="display:none;" readonly></textarea>
            <div id="timer-container">
                <span id="timer">01:00</span>
            </div>
            <div class="win">
                <button type="button" class="green-win green" onclick="colorLetter('green')">Green Won</button>
                <button type="button" class="red-win red" onclick="colorLetter('red')">Red Won</button>
            </div>
            <button type="button" class="reset" onclick="colorLetter('reset')">Reset Letter</button>
            <button type="button" class="close-pop-up red" onclick="closePopUp()">Close</button>
        </form>
    </div>
</body>
<script>
    const secondsTimer = 60;
    const secondsText = '01:00'

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.hexagon-button').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.id;
                const letter = btn.dataset.letter;
                popUp(id, letter);
            });
        });
    });

    function colorLetter(color) {
        const id = window.currentLetter;

        const btn = document.querySelector(`.hexagon-button[data-id='${id}']`);
        if (!btn) return;
        btn.classList.add('unborder')

        if (color == 'green') {
            btn.classList.remove('red');
            btn.classList.add(color);

        } else if (color == 'red') {
            btn.classList.remove('green');
            btn.classList.add(color);

        } else {
            btn.classList.remove('green');
            btn.classList.remove('red');
            btn.classList.remove('unborder');
        }

        closePopUp();
    }

    function popUp(id, letter) {
        if (id == null) {
            return;
        }

        document.getElementById('overlay').style.display = 'block';
        document.getElementById('pop-up').style.display = 'block';
        document.getElementById('display_letter').innerText = letter;
        const btn = document.getElementById('question-curtain');
        btn.classList.add('green');
        btn.classList.remove('red');
        document.getElementById('question-curtain').innerText = 'Show Question and Start Timer';

        window.currentLetter = id;
    }

    function closePopUp() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('pop-up').style.display = 'none';
        document.getElementById('question-curtain').style.display = 'block';
        document.getElementById('question').style.display = 'none';
        clearInterval(timerInterval);
        document.getElementById('timer').innerText = '01:00';
    }

    function showQuestion() {
        const letter = window.currentLetter;
        const type = document.getElementById('type').value;

        if (type == '') {
            const btn = document.getElementById('question-curtain');
            btn.classList.add('red');
            document.getElementById('question-curtain').innerText = 'Choose a type first';
            return;
        }
        startTimer(secondsTimer);
        console.log(letter + type);
        document.getElementById('question-curtain').style.display = 'none';
        document.getElementById('question').style.display = 'block';

        fetch("<?= site_url('Main/getQuestion') ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "letter=" + encodeURIComponent(letter) + "&type_id=" + encodeURIComponent(type)
        })
            .then(res => res.text())
            .then(text => {
                try {
                    const data = JSON.parse(text);

                    if (data.status === "success") {
                        document.getElementById('question').innerText = data.question + data.answer;
                    } else if (data.status === "error1") {
                        document.getElementById('question').innerText = "لم يتم العثور على سؤال";
                    } else if (data.status === "error2") {
                        document.getElementById('question').innerText = "Some error";
                    }
                } catch (e) {
                    console.error("Not JSON, got:", text);
                    document.getElementById('question').innerText = "⚠️ Server returned invalid response";
                }
            })
            .catch(err => {
                console.error("Network error:", err);
                document.getElementById('question').innerText = "حدث خطأ في الاتصال";
            });

    }

    let timerInterval;

    function startTimer(durationSeconds) {
        clearInterval(timerInterval);
        let time = durationSeconds;

        function updateDisplay() {
            const minutes = Math.floor(time / 60).toString().padStart(2, '0');
            const seconds = (time % 60).toString().padStart(2, '0');
            document.getElementById('timer').innerText = `${minutes}:${seconds}`;
            if (time <= 0) clearInterval(timerInterval);
            time--;
        }

        updateDisplay();
        timerInterval = setInterval(updateDisplay, 1000);
    }
</script>

</html>