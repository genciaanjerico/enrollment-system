<?php
session_start();
include 'table_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    echo "<script>
            var confirmDelete = confirm('Are you sure you want to delete this student information?');
            if(confirmDelete) {
                window.location.href = 'delete_student_process.php?student_id=$student_id';
            } else {
                window.location.href = 'all_students.php';
            }
          </script>";

    $con->close();
    exit(); 
} else {
    header("Location: all_students.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Booking</title>
</head>
<body>

</body>
</html>
