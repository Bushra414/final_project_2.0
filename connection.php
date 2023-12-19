
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mini";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    mysqli_query($conn, "SET GLOBAL FOREIGN_KEY_CHECKS=0");
?>
