<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exam_id = $_SESSION['exam_id'];
    $email = $_SESSION['email'];
    $student_id = $_SESSION['id'];
    $total_question = 0;
    $correct_answer = 0;
    $wrong_answer = 0;
    
    $start_time = $_SESSION['exam_start_time'];  
    $current_time = time();                      
    $exam_time = round(($current_time - $start_time) / 60);  // Total time in minutes

    //  correct answers
    $question_query = mysqli_query($conn, "SELECT id, ans FROM question WHERE exam_id='$_SESSION[exam_id]'");
    $correct_answers = [];
    while ($row = mysqli_fetch_assoc($question_query)) {
        $correct_answers[$row['id']] = $row['ans'];
        $total_question++;
    }

    // check answers
    foreach ($_POST as $question_id => $user_answer) {
        if (isset($correct_answers[$question_id])) {
            if ($correct_answers[$question_id] == $user_answer) {
                $correct_answer++;
            } else {
                $wrong_answer++;
            }
        }
    }

    // Save result to database
    $insert_result = mysqli_query($conn, "INSERT INTO result (student_id, exam_id, total_question, correct_answer, wrong_answer, exam_time) 
                                          VALUES ($student_id, $exam_id, $total_question, $correct_answer, $wrong_answer, $exam_time)");

    if ($insert_result) {
        $_SESSION['exam_completed'] = true;
        header("Location: results.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error saving results. Please try again.";
        header("Location: exam.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: exam.php");
    exit();
}
?>