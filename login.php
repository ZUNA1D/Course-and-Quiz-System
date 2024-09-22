
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="css/register.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <div class="selection-container">
            <button class="tab-button" onclick="showForm('student')">Login as Student</button>
            <button class="tab-button" onclick="showForm('teacher')">Login as Teacher</button>
        </div>
        <form id="student-form" class="registration-form" action="student_register.php" method="POST">
            <h2>Student login</h2>
            <label for="student-email">Email:</label>
            <input type="email" id="student-email" name="student-email" required>
            <label for="student-phone">password:</label>
            <input type="password" id="student-password" name="student-password" required>
            <button type="submit" name="login">Login as Student</button>
        </form>
        <form id="teacher-form" class="registration-form" action="teacher/teacher_register.php" method="POST">
            <h2>Teacher Login</h2>
            <label for="teacher-email">Email:</label>
            <input type="email" id="teacher-email" name="teacher-email" required>
            <label for="teacher-phone">password:</label>
            <input type="password" id="teacher-password" name="teacher-password" required>
            <button type="submit" name="login">Login as Teacher</button>
        </form>
    </div>

    <script>
        function showForm(formType) {
            document.getElementById('student-form').style.display = "none";
            document.getElementById('teacher-form').style.display = 'none';

            if (formType === 'student') {
                document.getElementById('student-form').style.display = 'flex';
            } else if (formType === 'teacher') {
                document.getElementById('teacher-form').style.display = 'flex';
            }
        }
    </script>
</body>
</html>
