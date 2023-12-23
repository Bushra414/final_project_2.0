<?php
include 'connection.php';

function getAllStudentNames() {
    global $conn;

    $result = $conn->query("SELECT SID, first_name, last_name FROM student_info");

    $studentNames = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $studentNames[] = $row;
        }
    }

    return $studentNames;
}

function getAllSubjects() {
    global $conn;

    $result = $conn->query("SELECT SubID, subject_name FROM subjects");

    $subjects = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subjects[] = $row;
        }
    }

    return $subjects;
}

function getStudentMarks($sid, $subid) {
    global $conn;

    $sid = mysqli_real_escape_string($conn, $sid);
    $subid = mysqli_real_escape_string($conn, $subid);

    $result = $conn->query("SELECT marks FROM student_result WHERE SID = '$sid' AND SubID = '$subid'");


    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['marks'];
    } else {
        return null; // Return null if no marks found for the specified SID and SubID
    }
}
function insertStudentMarks($sid, $subid, $marks) {
    global $conn;

    $sid = mysqli_real_escape_string($conn, $sid);
    $subid = mysqli_real_escape_string($conn, $subid);
    $marks = mysqli_real_escape_string($conn, $marks);

    // Check if the student already has a mark for the specified subject
    $checkQuery = "SELECT marks FROM student_result WHERE SID = '$sid' AND SubID = '$subid'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        return "Error: The student is already graded for this subject."; // Return error message if the student already has a mark
    } else {
        $sql = "INSERT INTO student_result (SID, SubID, marks) VALUES ('$sid', '$subid', '$marks')";

        if ($conn->query($sql) === TRUE) {
            return true; // Insert successful
        } else {
            return false; // Insert failed
        }
    }
}
function deleteStudent($sid) {
    global $conn;

    // Ensure SID is an integer
    $sid = (int)$sid;

    // Check if the student with the given SID exists
    $checkQuery = "SELECT SID FROM student_info WHERE SID = $sid";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Student exists, proceed with deletion
        $deleteQuery = "DELETE FROM student_info WHERE SID = $sid";
        if ($conn->query($deleteQuery) === TRUE) {
            return true; // Deletion successful
        } else {
            return false; // Deletion failed
        }
    } else {
        // Student with the given SID does not exist
        return false;
    }
}
function updateStudentMarks($studentName, $subjectName, $marks) {
    global $conn;

    $studentName = mysqli_real_escape_string($conn, $studentName);
    $subjectName = mysqli_real_escape_string($conn, $subjectName);
    $marks = mysqli_real_escape_string($conn, $marks);

    // Get the SID and SubID from the student's name and subject's name
    $sidQuery = "SELECT SID FROM student_info WHERE CONCAT(first_name, ' ', last_name) = '$studentName'";
    $subidQuery = "SELECT SubID FROM subjects WHERE subject_name = '$subjectName'";
    $sidResult = $conn->query($sidQuery);
    $subidResult = $conn->query($subidQuery);

    if ($sidResult->num_rows > 0 && $subidResult->num_rows > 0) {
        $sid = $sidResult->fetch_assoc()['SID'];
        $subid = $subidResult->fetch_assoc()['SubID'];

        // Check if the student with the given SID and SubID already has marks
        $checkQuery = "SELECT marks FROM student_result WHERE SID = '$sid' AND SubID = '$subid'";
        $checkResult = $conn->query($checkQuery);

        if ($checkResult->num_rows > 0) {
            // Student has marks, proceed with update
            $sql = "UPDATE student_result SET marks = '$marks' WHERE SID = '$sid' AND SubID = '$subid'";

            if ($conn->query($sql) === TRUE) {
                return true; // Update successful
            } else {
                return false; // Update failed
            }
        } else {
            // Student with the given SID and SubID does not have marks
            return "Error: No marks found for this student in this subject. Please insert marks first."; // Return error message if no marks found
        }
    } else {
        // Student with the given name or subject with the given name does not exist
        return false;
    }
}
