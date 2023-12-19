<?php
session_start();
include 'connection.php';
include 'models.php'; // Make sure this file includes the functions

$studentNames = getAllStudentNames();
$subjects = getAllSubjects();

if (isset($_POST['logout_button'])) {
    // Handle logout logic here
    session_destroy();
    header("Location: teacher_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher's Dashboard</title>
    <style>
        @font-face {
            font-family: Poppins-Regular;
            src: url("fonts/Poppins/Poppins-Regular.ttf");
        }
        @font-face {
            font-family: Poppins-Medium;
            src: url("fonts/Poppins/Poppins-Medium.ttf");
        }
        @font-face {
            font-family: Poppins-Bold;
            src: url("fonts/Poppins/Poppins-Bold.ttf");
        }
        @font-face {
            font-family: Poppins-SemiBold;
            src: url("fonts/Poppins/Poppins-SemiBold.ttf");
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            padding: 0;
            background: radial-gradient(
                circle at 8% 50%,
                rgb(21, 211, 224),
                rgb(144, 124, 195),
                rgb(243, 78, 232),
                rgb(244, 57, 138)
            );
            font-family: Poppins-Regular, sans-serif;
            font-size: 16px;
        }
        header {
            color: black;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        h1 {
            margin: 0;
            font-family: Poppins-Bold;
        }
        .logout-button {
            margin-right: 20px;
        }
        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: Poppins-Bold;
        }
        button:hover {
            background-color: #45a049;
        }
        .container {
            border-radius: 30px;
            display: flex;
            flex-direction: column;
            padding: 30px;
            background: white;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            font-family: Poppins-Medium;
        }
        th {
            background-color: #f2f2f2;
            font-family: Poppins-Bold;
        }
    </style>
</head>

<body>
<header>
    <h1><?php echo "Welcome " . $_SESSION['user_name'] . ", these are your students"; ?></h1>
    <div class="logout-button">
        <form method="post" action="">
            <button type="submit" name="logout_button">Log Out</button>
        </form>
    </div>
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
