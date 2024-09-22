<?php
include 'connect.php';
include "header.php";


// Ensure the user is logged in as a student
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Handle course enrollment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enroll'])) {
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
    $student_id = $_SESSION['id'];
    
    // Check if already enrolled
    $check_query = "SELECT * FROM enrollments WHERE student_id = '$student_id' AND course_id = '$course_id'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) == 0) {
        $enroll_query = "INSERT INTO enrollments (student_id, course_id) VALUES ('$student_id', '$course_id')";
        if (mysqli_query($conn, $enroll_query)) {
            $success_message = "Successfully enrolled in the course.";
        } else {
            $error_message = "Error enrolling in the course: " . mysqli_error($conn);
        }
    } else {
        $error_message = "You are already enrolled in this course.";
    }
}

?>



    <div class="container">
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <br>
                        <h5>Available Courses</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                if (isset($success_message)) {
                                    echo "<div class='alert alert-success'>{$success_message}</div>";
                                }
                                if (isset($error_message)) {
                                    echo "<div class='alert alert-danger'>{$error_message}</div>";
                                }
                                ?>
                                <h5 class="card-title mb-4">Course List</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT * FROM course";
                                        $result = mysqli_query($conn, $query);
                                        while ($course = mysqli_fetch_assoc($result)):
                                            $enrolled_query = "SELECT * FROM enrollments 
                                                               WHERE student_id = '{$_SESSION['id']}' 
                                                               AND course_id = '{$course['id']}'";
                                            $enrolled_result = mysqli_query($conn, $enrolled_query);
                                            $is_enrolled = mysqli_num_rows($enrolled_result) > 0;
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($course['title']); ?></td>
                                            <td><?php echo htmlspecialchars($course['description']); ?></td>
                                            <td>
                                                <?php if ($is_enrolled): ?>
                                                    <span class="badge bg-success">Enrolled</span>
                                                <?php else: ?>
                                                    <form method="post">
                                                        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                                                        <button type="submit" name="enroll" class="btn btn-sm btn-primary">Enroll</button>
                                                    </form>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>