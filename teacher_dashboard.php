<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: teacher_login.php");
    exit();
}

include 'connection.php';
include 'models.php';

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout_button'])) {
        // Handle logout logic here
        session_destroy();
        header("Location: teacher_login.php");
        exit();
    } elseif (isset($_POST['delete_button'])) {
        // Handle delete student logic here
        $sidToDelete = $_POST['delete_button'];
        $message = deleteStudent($sidToDelete) ? "Student with SID $sidToDelete deleted successfully." : "Error deleting student with SID $sidToDelete.";
        echo $message;
    } elseif (isset($_POST['insert_marks_button'])) {
        // Handle insert marks logic here
        $sid = mysqli_real_escape_string($conn, $_POST['sid']);
        $subid = mysqli_real_escape_string($conn, $_POST['subid']);
        $marks = mysqli_real_escape_string($conn, $_POST['marks']);

        $insertResult = insertStudentMarks($sid, $subid, $marks);
        if ($insertResult === true) {
            echo "Marks inserted successfully for Student ID $sid and Subject ID $subid";
        } elseif ($insertResult === "Error: The student is already graded for this subject.") {
            echo $insertResult;
        } else {
            echo "Error inserting marks for Student ID $sid and Subject ID $subid";
        }
    } elseif (isset($_POST['add_subject_button'])) {
        // Handle add subject logic here
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);

        $sql = "INSERT INTO subjects (subject_name) VALUES ('$subject')";

        if ($conn->query($sql) === TRUE) {
            echo "Subject '$subject' added successfully.";
        } else {
            echo "Error adding subject: " . $conn->error;
        }
    } elseif (isset($_POST['update_marks_button'])) {
        $studentName = mysqli_real_escape_string($conn, $_POST['student_name']);
        $subjectName = mysqli_real_escape_string($conn, $_POST['subject_name']);
        $marks = mysqli_real_escape_string($conn, $_POST['marks']);

        if (updateStudentMarks($studentName, $subjectName, $marks)) {
            echo "Marks updated successfully for $studentName in $subjectName";
        } else {
            echo "Error updating marks for $studentName in $subjectName";
        }
    }
}

// Retrieve data for display
$studentNames = getAllStudentNames();
$subjects = getAllSubjects();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./sty.css">
    <title>Teacher's Dashboard</title>
</head>

<body>
    <header>
        <h1><?php echo "Welcome " . $_SESSION['user_name'] . ", these are your students"; ?></h1>
        <div class="logout-button">
            <form method="post" action="">
                <button type="submit" class="btn red" name="logout_button">Log Out</button>
            </form>
        </div>
    </header>
    <div class="super-container">

        <div class="container">
            <h2>Student List</h2>
            <table>
                <tr>
                    <th>SID</th>
                    <th>Student Name</th>
                    <?php foreach ($subjects as $subject) : ?>
                        <th><?= $subject["subject_name"] ?></th>
                    <?php endforeach; ?>
                </tr>
                <?php foreach ($studentNames as $student) : ?>
                    <tr>
                        <td><?= $student['SID'] ?></td>
                        <td><?= $student['first_name'] . " " . $student['last_name'] ?></td>
                        <?php foreach ($subjects as $subject) : ?>
                            <td><?= getStudentMarks($student['SID'], $subject["SubID"]) ?? "N/A" ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="container">
            <h2>Insert Marks</h2>
            <form method="post" action="">
                <label for="sid">Student:</label>
                <select name="sid" id="sid" required>
                    <?php foreach ($studentNames as $student) : ?>
                        <option value="<?= $student['SID'] ?>"><?= $student['first_name'] . " " . $student['last_name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="subid">Subject:</label>
                <select name="subid" id="subid" required>
                    <?php foreach ($subjects as $subject) : ?>
                        <option value="<?= $subject['SubID'] ?>"><?= $subject['subject_name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="marks">Marks:</label>
                <input type="number" name="marks" id="marks" required>

                <button type="submit" class="btn" name="insert_marks_button">Insert Marks</button>
            </form>
        </div>
        <div class="container">
            <h2>Add Subject</h2>
            <form method="post" action="">
                <label for="subject">Subject:</label>
                <input type="text" name="subject" class="input">
                <button type="submit" class="btn" name="add_subject_button">Add Subject</button>
            </form>
        </div>
        <div class="container">
            <h2>Delete Students</h2>
            <ul>
                <?php foreach ($studentNames as $student) : ?>
                    <li>
                        <?= $student['first_name'] . " " . $student['last_name'] ?>
                        <form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                            <input type='hidden' name='delete_button' value='<?= $student['SID'] ?>'>
                            <button class="btn red" type='submit'>Delete</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="container">
            <h2>Update Marks</h2>
            <form method="post" action="">
                <label for="student_name">Student:</label>
                <select name="student_name" id="student_name" required>
                    <?php foreach ($studentNames as $student) : ?>
                        <option value="<?= $student['first_name'] . ' ' . $student['last_name'] ?>">
                            <?= $student['first_name'] . ' ' . $student['last_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="subject_name">Subject:</label>
                <select name="subject_name" id="subject_name" required>
                    <?php foreach ($subjects as $subject) : ?>
                        <option value="<?= $subject['subject_name'] ?>"><?= $subject['subject_name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="marks">Marks:</label>
                <input type="number" name="marks" id="marks" required>

                <button type="submit" class="btn" name="update_marks_button">Update Marks</button>
            </form>
        </div>
    </div>
    

</body>

</html>
