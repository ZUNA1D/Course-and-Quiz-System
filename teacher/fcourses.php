<?php
session_start();
include "../connect.php";
include "header.php";

if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit();
}

function handleFileUpload($file) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check file size
    if ($file["size"] > 500000) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }

    // If everything is ok, try to upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file;
        }
    }

    return false;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create_course':
                $thumbnail = handleFileUpload($_FILES["thumbnail"]);
                if ($thumbnail) {
                    $title = mysqli_real_escape_string($conn, $_POST['title']);
                    $description = mysqli_real_escape_string($conn, $_POST['description']);
                    $teacher_id = $_SESSION['teacher_id'];
                    
                    $query = "INSERT INTO course (tutor_id, title, description, thumb) 
                              VALUES ('$teacher_id', '$title', '$description', '$thumbnail')";
                    
                    if (mysqli_query($conn, $query)) {
                        $success_message = "Course created successfully.";
                    } else {
                        $error_message = "Error: " . mysqli_error($conn);
                    }
                }
                break;
            case 'delete_course':
                $course_id = mysqli_real_escape_string($conn, $_POST['id']);
                $query = "DELETE FROM course WHERE id = '$course_id' AND tutor_id = '{$_SESSION['teacher_id']}'";
                
                if (mysqli_query($conn, $query)) {
                    $success_message = "Course deleted successfully.";
                } else {
                    $error_message = "Error: " . mysqli_error($conn);
                }
                break;
            case 'remove_student':
                $enrollment_id = mysqli_real_escape_string($conn, $_POST['enrollment_id']);
                $query = "DELETE FROM enrollments WHERE id = '$enrollment_id' AND course_id IN (SELECT id FROM course WHERE tutor_id = '{$_SESSION['teacher_id']}')";
                if (mysqli_query($conn, $query)) {
                    $success_message = "Student removed from the course successfully.";
                } else {
                    $error_message = "Error: " . mysqli_error($conn);
                }
                break;
        }
    }
}
?>


<body>
    <div class="container">
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <br>
                        <h5>Course Management</h5>
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
                                <h5 class="card-title mb-4">Create Course</h5>
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="create_course">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Course Title</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Course Description</label>
                                        <textarea class="form-control" id="description" name="description" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="thumbnail" class="form-label">Course Thumbnail</label>
                                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Create Course</button>
                                </form>

                                <hr>

                                <h5 class="card-title mb-4">Your Courses</h5>
                                <?php 
                                $query = "SELECT * FROM course WHERE tutor_id = '{$_SESSION['teacher_id']}'";
                                $result = mysqli_query($conn, $query);
                                while ($course = mysqli_fetch_assoc($result)):
                                ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h5>
                                        <p class="card-text"><?php echo htmlspecialchars($course['description']); ?></p>
                                        <img src="<?php echo htmlspecialchars($course['thumb']); ?>" alt="Course Thumbnail" style="max-width: 200px;">
                                        <hr>
                                        <h6>Enrolled Students</h6>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $enrollment_query = "SELECT e.id as enrollment_id, s.id as student_id, s.name as student_name 
                                                                     FROM enrollments e 
                                                                     JOIN student s ON e.student_id = s.id 
                                                                     WHERE e.course_id = '{$course['id']}'";
                                                $enrollment_result = mysqli_query($conn, $enrollment_query);
                                                while ($enrollment = mysqli_fetch_assoc($enrollment_result)):
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($enrollment['student_name']); ?></td>
                                                    <td>
                                                        <form method="post" style="display:inline;">
                                                            <input type="hidden" name="action" value="remove_student">
                                                            <input type="hidden" name="enrollment_id" value="<?php echo $enrollment['enrollment_id']; ?>">
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this student from the course?')">Remove</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        </table>
                                        
                                        <a href="contents.php?course_id=<?php echo $course['id']; ?>" class="btn btn-primary">Manage Content</a>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="action" value="delete_course">
                                            <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Delete Course</button>
                                        </form>
                                    </div>
                                </div>
                                <?php endwhile; ?>
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