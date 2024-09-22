<?php
include 'connect.php';
include 'header.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: student.php");
    exit();
}

$course_id = mysqli_real_escape_string($conn, $_GET['id']);
$student_id = $_SESSION['id'];

// Check if the student is enrolled in this course
$enrollment_check = "SELECT * FROM enrollments WHERE student_id = $student_id AND course_id = $course_id";
$enrollment_result = mysqli_query($conn, $enrollment_check);

if (mysqli_num_rows($enrollment_result) == 0) {
    header("Location: student.php");
    exit();
}

// Fetch course details
$course_query = "SELECT * FROM course WHERE id = $course_id";
$course_result = mysqli_query($conn, $course_query);
$course = mysqli_fetch_assoc($course_result);

// Fetch course contents
$content_query = "SELECT * FROM content WHERE course_id = $course_id ORDER BY id";
$content_result = mysqli_query($conn, $content_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['title']); ?> - Course Contents</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h1><?php echo htmlspecialchars($course['title']); ?></h1>
        <p><?php echo htmlspecialchars($course['description']); ?></p>

        <h2 class="mt-4">Course Contents</h2>
        <div class="list-group">
            <?php while ($content = mysqli_fetch_assoc($content_result)): ?>
                <div class="list-group-item">
                    <h5 class="mb-1"><?php echo htmlspecialchars($content['title']); ?></h5>
                    <p class="mb-1"><?php echo htmlspecialchars($content['description']); ?></p>
                    <?php if ($content['thumbnail']): ?>
                        <a href="<?php echo "teacher/".$content['thumbnail']; ?>" class="btn btn-primary btn-sm mt-2" target="_blank">View Content</a>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>

        <a href="student.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
