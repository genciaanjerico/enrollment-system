<?php

include 'table_connect.php';


if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $query = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = $student_id");

    if ($row = mysqli_fetch_array($query)) {
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Details</title>

  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<header id="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-lg">
        <a class="navbar-brand" href="#">Enrollment System</a>
        <a class="navbar-brand" href="student_enrollment.php">Enroll Student</a>
        <a class="navbar-brand" href="all_students.php">All Students</a>
      </div>
    </nav>
  </header>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Student Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="all_students.php">All Students</a></li>
              <li class="breadcrumb-item active">Student Details</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
        

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Student Details</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
       
                <tbody>
    <?php
    $student_id = intval($_GET['student_id']);
    $query = mysqli_query($con, "SELECT si.*, se.student_type, se.student_course
                                  FROM student_info si
                                  LEFT JOIN student_enroll se ON si.student_id = se.student_id
                                  WHERE si.student_id = '$student_id'");

    while ($result = mysqli_fetch_array($query)) {
    ?>
        <tr>
            <th>Student ID</th>
            <td colspan="3"><?php echo $result['student_id'] ?></td>
        </tr>

        <tr>
            <th>Name</th>
            <td><?php echo $result['first_name'] . " " . $result['middle_name'] . " " . $result['last_name'] ?></td>
            <th>Gender</th>
            <td><?php echo $result['gender'] ?></td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td><?php echo $result['dob'] ?></td>
            <th>Address</th>
            <td><?php echo $result['address'] ?></td>
        </tr>
        <tr>
            <th>Student Type</th>
            <td><?php echo $result['student_type'] ?></td>
            <th>Course</th>
            <td><?php echo $result['student_course'] ?></td>
        </tr>
        <tr>
            <th>Created At</th>
            <td colspan="3"><?php echo $result['created_at'] ?></td>
        </tr>

        <tr>
            <td colspan="4" style="text-align:center;">
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateModal">Update Student</button>
            </td>
        </tr>
    <?php
    }
    ?>
</tbody>




                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>


</div>



<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Student Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                $query = mysqli_query($con, "SELECT si.*, se.student_type, se.student_course
                                                FROM student_info si 
                                                JOIN student_enroll se ON si.student_id = se.student_id
                                                WHERE si.student_id = '$student_id'");
                $result = mysqli_fetch_array($query);
                ?>

                <form method="post" action="update_student.php"> 
                <div class="form-group">
                    <label for="updateFirstName">First Name</label>
                    <input type="text" class="form-control" id="updateFirstName" name="updateFirstName" placeholder="First Name" value="<?php echo $result['first_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="updateMiddleName">Middle Name</label>
                    <input type="text" class="form-control" id="updateMiddleName" name="updateMiddleName" placeholder="Middle Name" value="<?php echo $result['middle_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="updateLastName">Last Name</label>
                    <input type="text" class="form-control" id="updateLastName" name="updateLastName" placeholder="Last Name" value="<?php echo $result['last_name']; ?>">
                </div>
                
                <div class="form-group">
                  <label for="updateGender">Gender</label>
                  <select class="form-control" id="updateGender" name="updateGender">
                      <option value="Male" <?php echo ($result['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                      <option value="Female" <?php echo ($result['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                  </select>
                </div>
                <div class="form-group">
                    <label for="updateDOB">Date of Birth</label>
                    <input type="date" class="form-control" id="updateDOB" name="updateDOB" value="<?php echo $result['dob']; ?>">
                </div>
                <div class="form-group">
                    <label for="updateAddress">Address</label>
                    <input type="text" class="form-control" id="updateAddress" name="updateAddress" placeholder="Address" value="<?php echo $result['address']; ?>">
                </div>

                <div class="form-group">
                    <label for="updateStudentType">Student Type</label>
                    <select class="form-control" id="updateStudentType" name="updateStudentType">
                      <option value="NEW" <?php echo ($result['student_type'] == 'NEW') ? 'selected' : ''; ?>>NEW</option>
                      <option value="REGULAR" <?php echo ($result['student_type'] == 'REGULAR') ? 'selected' : ''; ?>>REGULAR</option>
                      <option value="TRANSFEREE" <?php echo ($result['student_type'] == 'TRANSFEREE') ? 'selected' : ''; ?>>TRANSFEREE</option>
                      <option value="RETURNEE" <?php echo ($result['student_type'] == 'RETURNEE') ? 'selected' : ''; ?>>RETURNEE</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="updateStudentCourse">Course</label>
                    <select class="form-control" id="updateStudentCourse" name="updateStudentCourse">
                        <option value="BSIS" <?php echo ($result['student_course'] == 'BSIS') ? 'selected' : ''; ?>>BSIS</option>
                        <option value="BSIT" <?php echo ($result['student_course'] == 'BSIT') ? 'selected' : ''; ?>>BSIT</option>
                        <option value="BSCS" <?php echo ($result['student_course'] == 'BSCS') ? 'selected' : ''; ?>>BSCS</option>
                        <option value="BSEMC" <?php echo ($result['student_course'] == 'BSEMC') ? 'selected' : ''; ?>>BSEMC</option>
                    </select>
                </div>

              </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <input type="hidden" name="student_id" value="<?php echo $result['student_id']; ?>">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
                
            
        </div>
    </div>
</div>









<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../plugins/jszip/jszip.min.js"></script>
<script src="../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
</body>
</html>

<?php
    } else {
        echo "Student not found.";
    }
} else {
    echo "Invalid request.";
}
?>



