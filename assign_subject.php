<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST['subject'];
    

    $sql = "INSERT INTO subjects (subject_name)
            VALUES ('$subject')";

    if ($conn->query($sql) === TRUE) {
    echo "welcome";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Subject Registry</title>
</head>
<body>
    
    <form action="" method="post">
    <div class="container">
    <h2>Teacher Registry</h2>
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
        <label for="subject">Subject</label>
        <input type="text" name="subject" class="input">

        <input type="submit" value="Submit" class="btn">
    </form>
    <a href="teacher_login.php">u a teacher?</a>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>