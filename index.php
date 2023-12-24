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
    <link rel="stylesheet" href="./styles.css">


    <title>Student Registry</title>
</head>
<body>
    
<form action="" method="post">
    <div class="container">
    <h2>Student's Registry</h2>
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="post">
        <div class="names">
            <div class="pos">

                <label for="firstname">First Name</label>
                <input type="text" name="firstname" class="input" required>
                
            </div>
            <div class="pos">

                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" class="input" required>
                
            </div>
        </div>
        
        <label for="email">Email</label>
        <input type="email" name="email" class="input" required>

        <label for="dateofbirth">Date of Birth</label>
        <input type="date" name="dateofbirth" class="input" required>

        <label for="gender">Gender</label>
        <select name="gender" class="input" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>

        <label for="address">Address</label>
        <input type="text" name="address" class="input" required>

        <label for="phone">Phone</label>
        <input type="tel" name="phone" class="input" required>

        <input type="submit" value="Submit" class="btn">
    </form>
    <div class="link">

        <a href="student_login.php">Are you already a student?</a>
    </div>
    </body>
</html>

<?php
// Close the database connection
$conn->close();
?>
```
