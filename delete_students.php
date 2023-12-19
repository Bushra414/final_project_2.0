<?php
session_start();
include 'connection.php';
include 'models.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_button'])) {
    $sidToDelete = $_POST['delete_button'];
    
    if (deleteStudent($sidToDelete)) {
        echo "Student with SID $sidToDelete deleted successfully.";
    } else {
        echo "Error deleting student with SID $sidToDelete. Student may not exist or deletion failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">

    <title>Document</title>
</head>
<body>
    <div class="container">
        <ul>
            <?php
            $students = getAllStudentNames();
            foreach ($students as $student) {
                echo "<li>" . $student['first_name'] . " " . $student['last_name'] . 
                    " <form method='post' action='" . $_SERVER['PHP_SELF'] . "'>" .
                    "<input type='hidden' name='delete_button' value='" . $student['SID'] . "'>" .
                    "<button type='submit'>Delete</button>" .
                    "</form></li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>
