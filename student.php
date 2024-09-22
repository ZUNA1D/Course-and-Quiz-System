<?php
session_start();
if(!isset($_SESSION['email'])){
    ?>
    <script type="text/javascript">
        window.location="login.php";
    </script>
    <?php
}
include 'connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/feature.css">
</head>
<body>
    <section class="main-section">
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="student.php">EdTech</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="student_courses.php">Courses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="s_quizzes.php">Exam</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="all-content-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card my-5">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-4">Student Dashboard</h5>
                                
                                <!-- Profile Section -->
                                <section id="profile">
                                    <div class="profile-container">
                                        <h2>Welcome, <?php echo $_SESSION['name'];?></h2>
                                    </div>
                                </section>

                                <!-- Enrolled Courses Section -->
                                <section id="enrolled-courses" class="mt-5">
                                    <h3>Your Enrolled Courses</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Course Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $student_id = $_SESSION['id'];
                                            $query = "SELECT c.id, c.title 
                                                      FROM course c 
                                                      JOIN enrollments e ON c.id = e.course_id 
                                                      WHERE e.student_id = $student_id";
                                            $result = mysqli_query($conn, $query);
                                            while ($course = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($course['title']) . "</td>";
                                                echo "<td><a href='view_course.php?id=" . $course['id'] . "' class='btn btn-primary btn-sm'>View</a></td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
