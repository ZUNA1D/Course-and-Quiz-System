<?php
session_start();
include "../connect.php";
include "header.php";

// Function to handle file upload
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

// Handle form submissions
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
        }
    }
}
?>



    <div class="container">
        <div class="row justify-content-center">
            <?php
            if (isset($success_message)) {
                echo "<div class='alert alert-success'>{$success_message}</div>";
            }
            if (isset($error_message)) {
                echo "<div class='alert alert-danger'>{$error_message}</div>";
            }
            ?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Create Course</strong>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="create_course">
                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Course Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Course Description</label>
                                <textarea class="form-control" id="description" name="description" required></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="thumbnail" class="form-label">Course Thumbnail</label>
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Course</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Course List</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Thumbnail</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $query = "SELECT * FROM course WHERE tutor_id = '{$_SESSION['teacher_id']}'";
                                $result = mysqli_query($conn, $query);
                                $count = 0;
                                while ($course = mysqli_fetch_assoc($result)): 
                                    $count++;
                                ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo htmlspecialchars($course['title']); ?></td>
                                    <td><?php echo htmlspecialchars($course['description']); ?></td>
                                    <td><img src="<?php echo htmlspecialchars($course['thumb']); ?>" alt="Course Thumbnail"></td>
                                    <td>
                                        <a href="contents.php?course_id=<?php echo $course['id']; ?>" class="btn btn-primary btn-sm">Add Content</a>
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="action" value="delete_course">
                                            <input type="hidden" name="id" value="<?php echo $course['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>