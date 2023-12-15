<?php
session_start();
include 'table_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $stmt = $con->prepare("CALL DeleteStudent(?)");
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        $_SESSION['delete_success'] = true;
    } else {
        $_SESSION['delete_success'] = false;
    }

    $stmt->close();
} else {
    $_SESSION['delete_success'] = false;
}

$con->close();
header("Location: all_students.php");
exit();
?>
