<?php

include '../connect.php';

if(isset($_POST['signup'])){
    $name = $_POST["teacher-name"];
    $email = $_POST["teacher-email"];
    $password = md5($_POST["teacher-password"]);
    $checkEmail = "SELECT * FROM teacher WHERE email='$email'";
    
    $result = $conn->query($checkEmail);
    // $result = mysqli_query($conn,$checkEmail);
    if ($result->num_rows>0){
        echo "Email Already Exists";
    }else{
        $insertQuery = "INSERT INTO teacher(name, email, password) values ('$name', '$email', '$password')";
        if ($conn->query($insertQuery)==true){
            echo "Account Successfully Created";
            header("location: ../login.php");
        }else{
            echo "ERROR: ".$conn->error;
        }
    }
}


if(isset($_POST['login'])){
    $email = $_POST["teacher-email"];
    $password = md5($_POST["teacher-password"]);

    $sql = "SELECT * FROM teacher WHERE password='$password' and email='$email'";
    $result=$conn->query($sql);
    if ($result->num_rows>0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email']=$row['email'];
        $_SESSION['teacher_id']=$row['id'];
        $_SESSION['name']=$row['name'];
        header("location: teacher.php");
        exit();
    }else{
        echo "Not Found. Incorrect Email or password";
    }
}


?>