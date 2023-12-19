<?php
session_start();
include 'connection.php';
include 'models.php'; // Make sure this file includes the functions

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insert_marks_button'])) {
    // Process the form submission to insert marks
    $sid = mysqli_real_escape_string($conn, $_POST['sid']);
    $subid = mysqli_real_escape_string($conn, $_POST['subid']);
    $marks = mysqli_real_escape_string($conn, $_POST['marks']);

    // Validate the input if needed

    if (insertStudentMarks($sid, $subid, $marks)) {
        echo "Marks inserted successfully for Student ID $sid and Subject ID $subid";
    } else {
        echo "Error inserting marks for Student ID $sid and Subject ID $subid";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Marks</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<header>
    <h1>Insert Marks</h1>
    <form method="post" action="teacher_login.php">
        <button type="submit" class="btn" name="back_button">Back to Dashboard</button>
    </form>
</header>
<div class="container">
    <form method="post" action="<?php $_SERVER["PHP_SELF"]?>">
        <label for="sid">Student:</label>
        <select name="sid" id="sid" required>
            <?php
            $students = getAllStudentNames();
            foreach ($students as $student) {
                echo "<option value=\"" . $student['SID'] . "\">" . $student['first_name'] . " " . $student['last_name'] . "</option>";
            }
            ?>
        </select>

        <label for="subid">Subject:</label>
        <select name="subid" id="subid" required>
            <?php
            $subjects = getAllSubjects();
            foreach ($subjects as $subject) {
                echo "<option value=\"" . $subject['SubID'] . "\">" . $subject['subject_name'] . "</option>";
            }
            ?>
        </select>

        <label for="marks">Marks:</label>
        <input type="number" name="marks" id="marks" required>
        
        <button type="submit" class="btn" name="insert_marks_button">Insert Marks</button>
    </form>
</div>

</body>
</html>
```


