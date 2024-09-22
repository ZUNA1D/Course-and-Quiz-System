<?php
include '../connect.php';
include "header.php";
session_start();

$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;

if (!$course_id) {
    die("Course ID is required.");
}

function handleFileUpload($file, $allowedTypes) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

   
    if ($file["size"] > 5000000) { 
        return "File is too large.";
    }

    
    if (!in_array($fileType, $allowedTypes)) {
        return "Sorry, only " . implode(", ", $allowedTypes) . " files are allowed.";
    }

    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        return "Sorry, there was an error uploading your file.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_content':
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                $allowedTypes = array("pdf", "mp4");
                $file = handleFileUpload($_FILES["file"], $allowedTypes);
                
                if (strpos($file, "uploads/") === 0) {
                    $query = "INSERT INTO content (tutor_id, course_id, title, description, thumbnail) 
                              VALUES ('{$_SESSION['teacher_id']}', '$course_id', '$title', '$description', '$file')";
                    if (mysqli_query($conn, $query)) {
                        $success_message = "Content added successfully.";
                    } else {
                        $error_message = "Error: " . mysqli_error($conn);
                    }
                } else {
                    $error_message = $file;
                }
                break;

            case 'edit_content':
                $content_id = mysqli_real_escape_string($conn, $_POST['content_id']);
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $description = mysqli_real_escape_string($conn, $_POST['description']);
                
                $query = "UPDATE content SET title='$title', description='$description' 
                          WHERE id='$content_id' AND tutor_id='{$_SESSION['teacher_id']}'";
                if (mysqli_query($conn, $query)) {
                    $success_message = "Content updated successfully.";
                } else {
                    $error_message = "Error: " . mysqli_error($conn);
                }
                break;

            case 'delete_content':
                $content_id = mysqli_real_escape_string($conn, $_POST['content_id']);
                $query = "DELETE FROM content WHERE id='$content_id' AND tutor_id='{$_SESSION['teacher_id']}'";
                if (mysqli_query($conn, $query)) {
                    $success_message = "Content deleted successfully.";
                } else {
                    $error_message = "Error: " . mysqli_error($conn);
                }
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Content Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <br>
                        <h5>Course Content Management</h5>
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
                                <h5 class="card-title mb-4">Add New Content</h5>
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="action" value="add_content">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="file" class="form-label">File (PDF or MP4)</label>
                                        <input type="file" class="form-control" id="file" name="file" accept=".pdf,.mp4" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Content</button>
                                </form>

                                <hr>

                                <h5 class="card-title mb-4">Content List</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>File</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = "SELECT * FROM content WHERE course_id='$course_id' AND tutor_id='{$_SESSION['teacher_id']}'";
                                        $result = mysqli_query($conn, $query);
                                        while ($content = mysqli_fetch_assoc($result)):
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($content['title']); ?></td>
                                            <td><?php echo htmlspecialchars($content['description']); ?></td>
                                            <td><a href="<?php echo $content['thumbnail']; ?>" target="_blank">View File</a></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $content['id']; ?>">
                                                    Edit
                                                </button>
                                                <form method="post" style="display:inline;">
                                                    <input type="hidden" name="action" value="delete_content">
                                                    <input type="hidden" name="content_id" value="<?php echo $content['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this content?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>

                                       
                                        <div class="modal fade" id="editModal<?php echo $content['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $content['id']; ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel<?php echo $content['id']; ?>">Edit Content</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post">
                                                            <input type="hidden" name="action" value="edit_content">
                                                            <input type="hidden" name="content_id" value="<?php echo $content['id']; ?>">
                                                            <div class="mb-3">
                                                                <label for="editTitle<?php echo $content['id']; ?>" class="form-label">Title</label>
                                                                <input type="text" class="form-control" id="editTitle<?php echo $content['id']; ?>" name="title" value="<?php echo htmlspecialchars($content['title']); ?>" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="editDescription<?php echo $content['id']; ?>" class="form-label">Description</label>
                                                                <textarea class="form-control" id="editDescription<?php echo $content['id']; ?>" name="description" rows="3" required><?php echo htmlspecialchars($content['description']); ?></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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