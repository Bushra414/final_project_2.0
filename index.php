<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $FirstName = $_POST['firstname'];
    $LastName = $_POST['lastname'];
    $DateOfBirth = $_POST['dateofbirth'];
    $Gender = $_POST['gender'];
    $Address = $_POST['address'];
    $Email = $_POST['email'];
    $Phone = $_POST['phone'];

    $sql = "INSERT INTO student_info (first_name, last_name, date_of_birth, gender, address, email, phone)
            VALUES ('$FirstName', '$LastName', '$DateOfBirth', '$Gender', '$Address', '$Email', '$Phone')";

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
    <title>Student Registry</title>
</head>
<body>
    
    <form action="" method="post">
    <div class="container">
    <h2>Student Registry</h2>
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
        <label for="firstname">First Name</label>
        <input type="text" name="firstname" class="input">
        
        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" class="input">

        <label for="dateofbirth">Date of Birth</label>
        <input type="date" name="dateofbirth" class="input">

        <label for="gender">Gender</label>
        <select name="gender" class="input">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label for="address">Address</label>
        <input type="text" name="address" class="input">

        <label for="email">Email</label>
        <input type="email" name="email" class="input">

        <label for="phone">Phone</label>
        <input type="tel" name="phone" class="input">

        <input type="submit" value="Submit" class="btn">
    </form>
    <a href="student_login.php">u a student?</a>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
```

