<?php
session_start();
include 'connection.php';
include 'models.php'; // Make sure this file includes the functions

$studentNames = getAllStudentNames();
$subjects = getAllSubjects();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher's Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<header>
    <h1><?php echo "Welcome " . $_SESSION['user_name'] . ", these are your students"; ?></h1>
    <form method="post" action="teacher_login.php">
        <button type="submit" name="logout_button">Log Out</button>
    </form>
</header>
<div class="container">
    <table>
        <tr>
            <th>SID</th>
            <th>Student Name</th>
            <?php
            foreach ($subjects as $subject) {
                echo "<th>" . $subject["subject_name"] . "</th>";
            }
            ?>
        </tr>
        <?php
        foreach ($studentNames as $student) {
            echo "<tr>";
            echo "<td>" . $student['SID'] . "</td>";
            echo "<td>" . $student['first_name'] . " " . $student['last_name'] . "</td>";
            foreach ($subjects as $subject) {
                $marks = getStudentMarks($student['SID'], $subject["SubID"]);
                echo "<td>" . ($marks !== null ? $marks : "N/A") . "</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
