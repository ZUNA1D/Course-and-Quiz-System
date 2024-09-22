<?php
session_start();
include "connect.php";

if (!isset($_SESSION['exam_id']) || !isset($_SESSION['exam_time']) || !isset($_SESSION['exam_start_time'])) {
    header('Location: index.php'); 
    exit();
}

$exam_id = $_SESSION['exam_id'];
$exam_time = $_SESSION['exam_time'];
$start_time = $_SESSION['exam_start_time'];
$current_time = time();
$time_elapsed = $current_time - $start_time;
$time_remaining = max(0, $exam_time * 60 - $time_elapsed); 

// exam details
$exam_query = mysqli_query($conn, "SELECT course, topic FROM exam WHERE id = $exam_id");
$exam_details = mysqli_fetch_assoc($exam_query);

// questions
$questions_query = mysqli_query($conn, "SELECT * FROM question WHERE exam_id='$_SESSION[exam_id]' ORDER BY question_no");
$questions = mysqli_fetch_all($questions_query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Dashboard</title>
    <link rel="stylesheet" href="css/exam.css">
</head>
<body>
    <div class="container">
        <h1>Exam Dashboard</h1>
        <div id="timer">Time remaining: <span id="time-remaining"></span></div>

        <form id="exam-form" method="POST" action="submit_exam.php">
            <?php foreach ($questions as $index => $question): ?>
                <div class="question">
                    <h3><?php echo htmlspecialchars($question['question_no'] . '. ' . $question['question']); ?></h3>
                    <div class="options">
                        <?php for ($i = 1; $i <= 4; $i++): ?>
                            <div class="option">
                                <label>
                                    <input type="radio" name="<?php echo $question['id']; ?>" value="<?php echo $question["opt$i"]; ?>">
                                    <?php
                                    $option = $question["opt$i"];
                                    if (strpos($option, '.jpg') !== false || strpos($option, '.png') !== false || strpos($option, '.gif') !== false) {
                                        //  image
                                        echo '<img src="teacher/' . htmlspecialchars($option) . '" alt="Option ' . $i . '">';
                                    } else {
                                        //  text
                                        echo htmlspecialchars($option);
                                    }
                                    ?>
                                </label>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <input type="submit" value="Submit Exam" name="submit_exam">
        </form>
    </div>

    <script>
    let timeRemaining = <?php echo $time_remaining; ?>;

    function updateTimer() {
        const hours = Math.floor(timeRemaining / 3600);
        const minutes = Math.floor((timeRemaining % 3600) / 60);
        const seconds = timeRemaining % 60;

        document.getElementById('time-remaining').textContent = 
            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        if (timeRemaining > 0) {
            timeRemaining--;
            setTimeout(updateTimer, 1000);
        } else {
            alert('Exam time is up!');
            document.getElementById('exam-form').submit();
        }
    }

    updateTimer();
    </script>
</body>
</html>