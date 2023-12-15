<?php

include 'table_connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>All Students</title>

   <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



</head>
<body>
  <header id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-lg">
        <a class="navbar-brand" href="#">Enrollment System</a>
        <a class="navbar-brand" href="student_enrollment.php">Enroll Student</a>
        <a class="navbar-brand" href="all_students.php">All Students</a>
      </div>
    </nav>
  </header>


  <div class="card mt-50">
    <div class="card-header">
        Student List
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="t-center">#</th>
                    <th>Student Number</th>
                    <th>Name</th>
                    <th class="t-center">Gender</th>
                    <th class="t-center">Date of Birth</th>
                    <th>Address</th>
                    <th class="t-center">Student Type</th>
                    <th>Course</th>
                    <th class="t-center">Created At</th>
                    <th class="t-center">Updated At</th>
                    <th class="t-center">Actions</th>
                </tr>
            </thead>

            <?php
            $query = "CALL GetStudentInfo()";
            $result = mysqli_query($con, $query);

            if (!$result) {
                die("Error executing the stored procedure: " . mysqli_error($con));
            }

            $count = 1;
            while ($row = mysqli_fetch_array($result)) {
            ?>

                <tr>
                    <td class="t-center"><?php echo $count += 1 ?></td>
                    <td class="t-center"><?php echo $row['student_id'] ?></td>
                    <td><?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></td>
                    <td class="t-center"><?php echo $row['gender'] ?></td>
                    <td class="t-center"><?php echo $row['dob'] ?></td>
                    <td><?php echo $row['address'] ?></td>
                    <td class="t-center"><?php echo $row['student_type'] ?></td>
                    <td><?php echo $row['student_course'] ?></td>
                    <td class="t-center"><?php echo $row['created_at'] ?></td>
                    <td class="t-center"><?php echo $row['updated_at'] ?></td>
                    <td class="t-center">
                        <a href="view_details.php?student_id=<?php echo $row['student_id']; ?>" class="btn btn-primary">View Details</a>
                        <a href="delete_student.php?student_id=<?php echo $row['student_id']; ?>" class="btn btn-danger delete-btn">Delete</a>

                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>






</body>
</html>