<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: student_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      padding: 20px;
    }
    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
      border-radius: 12px;
      overflow: hidden;
    }
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #4CAF50;
      color: white;
      font-weight: bold;
    }
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  </style>
</head>
<header>
    <h1><?php echo  "Welcome " . $_SESSION['user_name'] . ", this is your results table" ?></h1>
  </header>
<body>
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

  <script>
    // ... (any additional scripts) ...
  </script>
</body>
</html>
