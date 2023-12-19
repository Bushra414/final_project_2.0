<?php
session_start();
include 'connection.php';



// Process login form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "SELECT * FROM teacher_info WHERE email = '$email' AND phone = '$phone'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['TID'];
        $_SESSION['user_email'] = $row['email'];
        $_SESSION['user_phone'] = $row['phone'];
        $_SESSION['user_name'] = $row['first_name'];
        header("Location: teacher_dashboard.php");
        exit();
    } else {
        $login_error = "Invalid email or phone";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>Teacher Login</title>
</head>
<body>
    <!-- Login Form -->
    <div class="container">

    <label class="title">Teacher Login</label>

    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" class="input" required>

        <label for="phone">phone</label>
        <input type="tel" name="phone" class="input" required>

        <input type="submit" value="Login" name="login" class="btn">
        
        <?php
        if (isset($login_error)) {
            echo "<p class='error'>$login_error</p>";
        }
        ?>
    </form>
    <div class="link">

<a href="teacher_index.php">Are you already a part of our staff?</a>
</div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
```
