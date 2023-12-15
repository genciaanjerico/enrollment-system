<?php

include 'table_connect.php';

session_start();

if(isset($_POST['submit']))
{
  $student_type = $_POST['student_type'];
  $first_name = $_POST['first_name'];
  $middle_name = $_POST['middle_name'];
  $last_name = $_POST['last_name'];
  $gender = $_POST['gender'];
  $dob = $_POST['dob'];
  $address = $_POST['address'];
  $student_course = $_POST['student_course'];

  $student_no = "Student Number-".rand(1111,9999);
  $query = mysqli_query($con, "CALL Insert_Student('$student_type', '$first_name', '$middle_name', '$last_name', '$gender', '$dob', '$address', '$student_course', '$student_no')");
  
  if($query) {
    echo '<script>alert("Record Succesfully Inserted")</script>';
  }
  else {
    echo '<script>alert("Something went wrong. Please try again")</script>';
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enrollment System</title>
  <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
  <style>
    .content {
      width: 800px;
    }
    .mt-50 {
      margin-top: 50px;
    }
    .mt-15 {
      margin-top: 15px;
    }
    .t-center {
      text-align: center;
    }
  </style>
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
  <section class="content container">
    <div class="card mt-50">
      <div class="card-header">
        Student Form
      </div>
      <div class="card-body">
        <form action="" method="post">
          <div class="row">
            <div class="col-4">
              <div class="form-group">
                <label>Student Type</label>
                <select name="student_type" class="form-select">
                  <option selected>Select Student Type</option>
                  <option value="NEW">New</option>
                  <option value="REGULAR">Regular</option>
                  <option value="TRANSFEREE">Transferee</option>
                  <option value="RETURNEE">Returnee</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row mt-15">
            <div class="col">
              <div class="form-group">
                <label>Firstname</label>
                <input type="text" class="form-control" name="first_name" placeholder="Firstname" required>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Middlename</label>
                <input type="text" class="form-control" name="middle_name" placeholder="Middlename" required>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label>Lastname</label>
                <input type="text" class="form-control" name="last_name" placeholder="Lastname" required>
              </div>
            </div>
          </div>
          <div class="row mt-15">
            <div class="col">
              <div class="form-group">
                <label>Gender</label>
                <select name="gender" class="form-select" required>
                  <option selected>Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
            </div>
            <div class="row mt-15">
              <div class="col">
              <div class="form-group">
                <label>Course</label>
                <select name="student_course" class="form-select" required>
                  <option selected>Select Course</option>
                  <option value="BSIS">BSIS</option>
                  <option value="BSIT">BSIT</option>
                  <option value="BSEMC">BSEMC</option>
                  <option value="BSCS">BSCS</option>
                </select>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
               <label>Date of Birth</label>
                <input type="date" class="form-control" name="dob" required>
              </div>
            </div>
          <div class="row mt-15">
            <div class="col">
              <div class="form-group">
               <label>Address</label>
                <textarea class="form-control" name="address" placeholder="please enter your address" required></textarea>
              </div>
            </div>
          </div>
          <div class="mt-15">
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </section>

</body>
</html>