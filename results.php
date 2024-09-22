<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['exam_completed'])) {
    header('Location: student.php');
    exit();
}

$email = $_SESSION['email'];
$exam_id = $_SESSION['exam_id'];

// Fetch the latest result for this user
$result_query = mysqli_query($conn, "SELECT * FROM result WHERE student_id='$_SESSION[id]' AND exam_id='$_SESSION[exam_id]' ORDER BY id DESC LIMIT 1");

if ($result_query && mysqli_num_rows($result_query) > 0) {
    $result = mysqli_fetch_assoc($result_query);
} else {
    $error_message = "No results found. Please contact the admin.";
}

// exam details
$exam_query = mysqli_query($conn, "SELECT course, topic FROM exam WHERE id = $exam_id");
$exam_details = mysqli_fetch_assoc($exam_query);

// Clearing the exam_completed session variable, exam shesh...
unset($_SESSION['exam_completed']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/results.css">

</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="text-center">Exam Results</h1>
            </div>
            <div class="card-body">
                <?php if (isset($error_message)): ?>
                    <p class="text-danger"><?php echo $error_message; ?></p>
                <?php else: ?>
                    <div class="result-item"><strong>Course:</strong> <?php echo htmlspecialchars($exam_details['course']); ?></div>
                    <div class="result-item"><strong>Topic:</strong> <?php echo htmlspecialchars($exam_details['topic']); ?></div>
                    <div class="result-item"><strong>Total Questions:</strong> <?php echo $result['total_question']; ?></div>
                    <div class="result-item"><strong>Correct Answers:</strong> <?php echo $result['correct_answer']; ?></div>
                    <div class="result-item"><strong>Wrong Answers:</strong> <?php echo $result['wrong_answer']; ?></div>
                    <div class="result-item"><strong>Exam Time:</strong> <?php echo $result['exam_time']; ?> minutes</div>
                    
                    <div class="score text-center mt-4">
                        Score: <?php echo round(($result['correct_answer'] / $result['total_question']) * 100, 2); ?>%
                    </div>
                <?php endif; ?>
                
                <div class="text-center mt-4">
                    <a href="student.php" class="btn btn-primary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>