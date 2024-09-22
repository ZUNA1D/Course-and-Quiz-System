<?php
session_start();
include "connect.php";

if (isset($_POST['exam_id']) && isset($_POST['exam_time'])) {
    $_SESSION['exam_id'] = $_POST['exam_id'];
    $_SESSION['exam_time'] = $_POST['exam_time'];
    $_SESSION['exam_start_time'] = time(); // Current timestamp
    $res=mysqli_query($conn, "SELECT * FROM exam WHERE id='$_SESSION[exam_id]'");
    $row=mysqli_fetch_array($res);
    $_SESSION['course']= $row['course'];
    $_SESSION['topic']= $row['topic'];
    echo 'success';
} else {
    echo 'error';
}
?>