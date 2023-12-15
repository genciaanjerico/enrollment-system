<?php
include 'table_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $first_name = isset($_POST['updateFirstName']) ? $_POST['updateFirstName'] : '';
    $middle_name = isset($_POST['updateMiddleName']) ? $_POST['updateMiddleName'] : '';
    $last_name = isset($_POST['updateLastName']) ? $_POST['updateLastName'] : '';
    $gender = $_POST['updateGender'];
    $dob = isset($_POST['updateDOB']) ? $_POST['updateDOB'] : '';
    $address = isset($_POST['updateAddress']) ? $_POST['updateAddress'] : '';
    $student_type = $_POST['updateStudentType'];
    $student_course = $_POST['updateStudentCourse'];

    $stmt = mysqli_prepare($con, "CALL UpdateStudentInfo(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "issssssss", $student_id, $first_name, $middle_name, $last_name, $gender, $dob, $address, $student_type, $student_course);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        
        echo '<script>';
        echo 'alert("Student information updated successfully!");';
        echo 'window.location.href = "all_students.php";';
        echo '</script>';
        exit();
    } else {
        echo "Error updating student information: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($con);
?>
