<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: student_login.php");
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: student_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./sty.css">

</head>
<header>
    <h1><?php echo  "Welcome " . $_SESSION['user_name'] . ", this is your results table" ?></h1>
    <a href="?logout=true" style="position: absolute; top: 10px; right: 10px; background-color: red; color: white; padding: 5px 10px; text-decoration: none;">Logout</a>
  </header>
<body>
  <div class="container" style="width: 700px;">

    <table id="subjectResults">
      <tr>
        <th>Subject</th>
        <th>Result</th>
      </tr>
      <?php
    include 'connection.php';
    $sid = $_SESSION['user_id'];
    $query = "SELECT * FROM student_result WHERE sid = $sid";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        $subjectID = $row['SubID'];
        $subjectQuery = "SELECT subject_name FROM subjects WHERE SubID = $subjectID";
        $subjectResult = mysqli_query($conn, $subjectQuery);
        if(mysqli_num_rows($subjectResult) > 0) {
          $subjectRow = mysqli_fetch_assoc($subjectResult);
          $subjectName = $subjectRow['subject_name'];
        }
        echo "<tr>";
        echo "<td>" . $subjectName . "</td>";
        echo "<td>" . $row['marks'] . "</td>";
        echo "</tr>";
      }
    }
    ?>
  </table>
</div>

  <script>
    // ... (any additional scripts) ...
  </script>
</body>
</html>
```
