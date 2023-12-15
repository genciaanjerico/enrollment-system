<?php

include 'table_connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}


$studentId = $_GET['student_id']; 


$stmt = $pdo->prepare("CALL GetStudentInfo(:student_id)");
$stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
$stmt->execute();

$student = $stmt->fetch(PDO::FETCH_ASSOC);


header('Content-Type: application/json');
echo json_encode($student);
?>
