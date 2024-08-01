<?php
session_start();
//error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
  header('location:logout.php');
} else {

  $pid = intval($_GET['id']); // get patient id

  $sql = mysqli_query($con, "SELECT 
    p.id,
    p.hospital_id,
    p.first_name,
    p.middle_name,
    p.last_name,
    p.date_of_birth,
    p.phone_number,
    p.alternate_phone_number,
    p.email,
    p.attendant_name,
    p.alternate_email,
    p.gender,
    p.aadhar_card,
    p.pan_card,
    p.tpa,
    p.is_active,
    p.created_by,
    p.inserted_by,
    p.created_at,
    pai.patient_id,
    pai.address_line_1,
    pai.address_line_2,
    pai.city,
    pai.state,
    pai.country,
    pai.pincode,
    c.id,
    c.country_name,
    h.id AS hospital_id,
    h.name AS hospital_name
    FROM 
    patients p
    LEFT JOIN
    patients_additional_info pai
    ON
    p.id = pai.patient_id
    LEFT JOIN
    countries c
    ON 
    pai.country = c.id
    LEFT JOIN
    hospitals h
    ON
    p.hospital_id = h.id
    WHERE 
    p.id = $pid");

  $num = mysqli_fetch_assoc($sql);

  $patient = (object) $num;

  date_default_timezone_set('Asia/Kolkata'); // change according timezone
  $currentTime = date('Y-m-d h:i:s A', time());

  if (isset($_POST['submit'])) {

    $sql = mysqli_query($con, "SELECT id,first_name,middle_name,last_name,email,alternate_email,phone_number,alternate_phone_number,date_of_birth,gender,aadhar_card,pan_card,tpa FROM patients where id='$pid'");

    $num = mysqli_fetch_array($sql);

    if ($num > 0) {
      $first_name = $_POST['firstName'];
      $middle_name = $_POST['middleName'];
      $last_name = $_POST['lastName'];
      $attendant_name = $_POST['attendant_name'];
      $email = $_POST['email'];
      $alternate_email = $_POST['alternate_email'];
      $phone_number = $_POST['phone_number'];
      $alternate_phone_number = $_POST['alternate_phone_number'];
      $gender = $_POST['gender'];
      $date_of_birth = $_POST['date_of_birth'];
      $aadhar_card = $_POST['aadhar_card'];
      $pan_card = $_POST['pan_card'];


      $conn = mysqli_query($con, "UPDATE patients set first_name='$first_name',middle_name='$middle_name',last_name='$last_name',phone_number='$phone_number',alternate_phone_number='$alternate_phone_number',attendant_name='$attendant_name',email='$email',alternate_email='$alternate_email',gender='$gender',date_of_birth='$date_of_birth',aadhar_card='$aadhar_card',pan_card='$pan_card', updated_at='$currentTime' where id='$pid'");


      if ($conn) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Info Updated Successfully.'
                });

                setTimeout(function(){
                    window.location.href = 'edit-patient.php?id=$pid';
                }, 3000);
            });
           
            
           
        </script>";
      }
    } else {
      $_SESSION['msg1'] = "Your Profile Updated Successfully !!";
    }
  }


  if (isset($_POST['submit-additional-info'])) {

    $sql = mysqli_query($con, "SELECT 
    p.id,
    pai.address_line_1, 
    pai.address_line_2,
    pai.city,
    pai.state,
    pai.country,
    pai.pincode
    FROM 
        patients p
    JOIN 
        patients_additional_info pai ON p.id = pai.patient_id
    WHERE 
        p.id = '$pid'");

    $num = mysqli_fetch_array($sql);

    if ($num > 0) {
      $address_line_1 = $_POST['address_line_1'];
      $address_line_2 = $_POST['address_line_2'];
      $city = $_POST['city'];
      $state = $_POST['state'];
      $country = $_POST['country'];
      $pincode = $_POST['pincode'];

      $con = mysqli_query($con, "UPDATE patients_additional_info SET address_line_1='$address_line_1',address_line_2='$address_line_2',city='$city',state='$state',country='$country',pincode='$pincode', updated_at='$currentTime' where patient_id='{$num['id']}'");

      if ($sql) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Additional Info Updated Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-patient.php?id=$pid`;
                }, 3000);
            });
        </script>";
      }
    } else {
      $address_line_1 = $_POST['address_line_1'];
      $address_line_2 = $_POST['address_line_2'];
      $city = $_POST['city'];
      $state = $_POST['state'];
      $country = $_POST['country'];
      $pincode = $_POST['pincode'];

      $con = mysqli_query($con, "INSERT INTO `patients_additional_info`(`patient_id`, `address_line_1`, `address_line_2`, `city`, `state`, `country`, `pincode`, `created_at`) 
      VALUES ('$pid','$address_line_1','$address_line_2','$city','$state','$country','$pincode','$currentTime')");

      if ($sql) {
        echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Patient Additional Info Updated Successfully.'
                });

                setTimeout(function(){
                    window.location.href = `edit-patient.php?id=$pid`;
                }, 3000);
            });
        </script>";
      }
    }
  }


?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedsCred | Edit Patient</title>
    <link rel="shortcut icon" type="image/x-icon" href="dist/fav.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
    <link rel="stylesheet" href="./plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="./plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="./plugins/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="./plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="./plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="./plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="./plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="./plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" href="./plugins/bs-stepper/css/bs-stepper.min.css">
    <link rel="stylesheet" href="./plugins/dropzone/min/dropzone.min.css">

    <link rel="stylesheet" href="./plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="./plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
      });
    </script>

  </head>

  <body class="hold-transition sidebar-mini">
    <div class="wrapper">
      <?php include('include/navbar.php'); ?>
      <?php include('include/sidebar.php'); ?>

      <div class="content-wrapper">
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Patient Profile</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item"><a href="patients.php">Patients</a></li>
                  <li class="breadcrumb-item active"><?php echo ($patient->first_name) ?> <?php echo ($patient->last_name) ?></li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-3">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                    <div class="text-center">
                      <img class="profile-user-img img-fluid img-circle" src="./dist/img/user4-128x128.jpg" alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center"><?php echo ($patient->first_name) ?> <?php echo ($patient->middle_name) ?> <?php echo ($patient->last_name) ?></h3>

                    <p class="text-muted text-center">Date of Registration <b><?php echo ($patient->created_at) ?></b></p>

                    <ul class="list-group list-group-unbordered mb-3">
                      <li class="list-group-item">
                        <b>Email</b> <a class="float-right"><?php echo ($patient->email) ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>Phone Number</b> <a class="float-right"><?php echo ($patient->phone_number) ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>Date Of Birth</b> <a class="float-right"><?php echo ($patient->date_of_birth) ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>gender</b> <a class="float-right"><?php echo ($patient->gender) ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>Created At</b> <a class="float-right"><?php echo ($patient->created_at) ?></a>
                      </li>
                    </ul>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>

              <!-- /.col -->
              <div class="col-md-9">
                <div class="card">
                  <div class="card-header p-2">
                    <ul class="nav nav-pills">

                      <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Update Patient Info</a></li>
                      <li class="nav-item"><a class="nav-link" href="#additional-info" data-toggle="tab">Update Patient Addtional Info</a></li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="active tab-pane" id="settings">
                        <form class="form-horizontal" method="post">



                          <div class="form-group row">
                            <div class="col-md-4">
                              <label for="inputFirstName" class="col-sm-12 col-form-label">First Name</label>
                              <div class="col-sm-12">
                                <input type="text" class="form-control" value="<?php echo ($patient->first_name) ?>" id="inputFirstName" name="firstName" placeholder="Name">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label for="inputMiddleName" class="col-sm-12 col-form-label">Middle Name</label>
                              <div class="col-sm-12">
                                <input type="text" class="form-control" value="<?php echo ($patient->middle_name) ?>" id="inputMiddleName" name="middleName" placeholder="Name">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label for="inputLastName" class="col-sm-12 col-form-label">Last Name</label>
                              <div class="col-sm-12">
                                <input type="text" class="form-control" value="<?php echo ($patient->last_name) ?>" id="inputLastName" name="lastName" placeholder="Name">
                              </div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-md-4">
                              <label for="inputEmail" class="col-sm-12 col-form-label">Attendant Name</label>
                              <div class="col-sm-12">
                                <input name="attendant_name" type="attendant_name" value="<?php echo ($patient->attendant_name) ?>" class="form-control" id="inputattendant_name" placeholder="Attendant Name">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label for="inputEmail" class="col-sm-12 col-form-label">Email</label>
                              <div class="col-sm-12">
                                <input name="email" type="email" value="<?php echo ($patient->email) ?>" class="form-control" id="inputEmail" placeholder="Email">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label for="inputEmail" class="col-sm-12 col-form-label">Alternate Email</label>
                              <div class="col-sm-12">
                                <input name="alternate_email" type="email" value="<?php echo ($patient->alternate_email) ?>" class="form-control" id="inputEmail" placeholder="Email">
                              </div>
                            </div>

                          </div>
                          <div class="form-group row">
                            <div class="col-md-6">
                              <label for="inputPhoneNumber" class="col-sm-12 col-form-label">Phone Number</label>
                              <div class="col-sm-12">
                                <input type="text" name="phone_number" value="<?php echo ($patient->phone_number) ?>" class="form-control" id="inputPhoneNumber" placeholder="Phone Number">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label for="inputAlternatePhoneNumber" class="col-sm-12 col-form-label">Alternate Phone Number</label>
                              <div class="col-sm-12">
                                <input type="text" name="alternate_phone_number" value="<?php echo ($patient->alternate_phone_number) ?>" class="form-control" id="inputAlternatePhoneNumber" placeholder="Alternate Phone Number">
                              </div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-md-6">
                              <label for="gender" class="col-sm-12 col-form-label">Gender</label>
                              <div class="col-sm-12">
                                <select class="form-control select2" name="gender" id="inputGender" style="width: 100%;">
                                  <option disabled <?php if (!$patient->gender) echo 'selected="selected"'; ?>>Select Gender</option>
                                  <option value="Male" <?php if ($patient->gender == 'Male') echo 'selected="selected"'; ?>>Male</option>
                                  <option value="Female" <?php if ($patient->gender == 'Female') echo 'selected="selected"'; ?>>Female</option>
                                  <option value="Others" <?php if ($patient->gender == 'Others') echo 'selected="selected"'; ?>>Others</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label for="inputDOB" class="col-sm-12 col-form-label">Date Of Birth</label>
                              <div class="col-sm-12">
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="date_of_birth" value="<?php echo ($patient->date_of_birth) ?>" />
                                  <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-md-6">
                              <label for="inputAadharCard" class="col-sm-12 col-form-label">Aadhar Card</label>
                              <div class="col-sm-12">
                                <input type="text" name="aadhar_card" value="<?php echo ($patient->aadhar_card) ?>" class="form-control" id="inputAadharCard" placeholder="Phone Number">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label for="inputPanCard" class="col-sm-12 col-form-label">PAN Card</label>
                              <div class="col-sm-12">
                                <input type="text" name="pan_card" value="<?php echo ($patient->pan_card) ?>" class="form-control" id="inputPanCard" placeholder="Phone Number">
                              </div>
                            </div>
                          </div>


                          <div class="form-group row">
                            <div class="col-md-12">
                              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default" style="margin-top: 10px;">
                                Submit
                              </button>
                            </div>
                            <div class="modal fade" id="modal-default">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Profile Updation!</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <p>Are you sure you want to update your profile?</p>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="submit" class="btn btn-danger">Submit</button>
                                  </div>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                            </div>
                          </div>
                        </form>
                      </div>

                      <div class="tab-pane" id="additional-info">
                        <form class="form-horizontal" method="post">
                          <div class="form-group row">
                            <div class="col-md-12">
                              <label for="inputAddressLine1">Address Line 1</label>
                              <div>
                                <input type="text" class="form-control" value="<?php echo ($patient->address_line_1) ?>" id="inputAddressLine1" name="address_line_1" placeholder="Address Line 1">
                              </div>
                            </div>

                          </div>
                          <div class="form-group row">
                            <div class="col-md-12">
                              <label for="inputAddressLine2">Address Line 1</label>
                              <div>
                                <input type="text" class="form-control" value="<?php echo ($patient->address_line_2) ?>" id="inputAddressLine2" name="address_line_2" placeholder="Address Line 2">
                              </div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-md-3">
                              <label for="inputCity">City</label>
                              <input type="text" value="<?php echo ($patient->city) ?>" class="form-control" name="city" id="inputCity" placeholder="City">
                            </div>
                            <div class="col-md-3">
                              <label for="inputState">State</label>
                              <input type="text" value="<?php echo ($patient->state) ?>" class="form-control" name="state" id="inputState" placeholder="State">
                            </div>
                            <div class="col-md-3">
                              <label for="country">Country</label>
                              <select class="form-control select2" name="country" id="inputCountry">
                                <option value="<?php echo ($patient->country); ?>">
                                  <?php echo ($patient->country_name); ?>
                                </option>
                                <?php $ret = mysqli_query($con, "SELECT id,country_name FROM countries");
                                while ($row = mysqli_fetch_array($ret)) {
                                ?>
                                  <option value="<?php echo htmlentities($row['id']); ?>">
                                    <?php echo htmlentities($row['country_name']); ?>
                                  </option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="col-md-3">
                              <label for="inputPinCode">Pin Code</label>
                              <input type="text" value="<?php echo ($patient->pincode) ?>" class="form-control" name="pincode" id="inputPinCode" placeholder="pincode">
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-md-12">
                              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-default-2" style="margin-top: 10px;">
                                Submit
                              </button>
                            </div>
                            <div class="modal fade" id="modal-default-2">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title">Profile Updation!</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <p>Are you sure you want to update your profile?</p>
                                  </div>
                                  <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="submit-additional-info" class="btn btn-danger">Submit</button>
                                  </div>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>


                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>

            <div class="row">

              <div class="col-md-12">

                <div class="card card-primary card-outline">
                  <div class="content-header" style="text-align: center;width:100%;display: flex;justify-content:space-between;">
                    <div class="row">
                      <h3 style="margin-left:10px"><b>Case Details</b></h3>
                    </div>
                    <div class="row">
                      <a href='add-case.php?id=<?php echo ($pid); ?>' class="btn btn-primary" style="margin-right:10px"><b>Add New Case</b></a>
                    </div>
                  </div>
                  <table class="table table-striped projects">
                    <thead>
                      <tr>
                        <th style="width: 8%">
                          Sr No.
                        </th>
                        <th style="width: 10%">
                          Patient Id
                        </th>
                        <th style="width: 10%">
                          Case Id
                        </th>
                        <th style="width: 20%">
                          Hospital Case Id
                        </th>
                        <th style="width: 20%">
                          Treatment Name
                        </th>
                        <th style="width: 20%">
                          Doctor Name
                        </th>
                        <th style="width: 20%">
                          Hospital Name
                        </th>
                        <th style="width: 20%" class="text-center">
                          Status
                        </th>
                        <th style="width: 20%">
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                      $sql = mysqli_query(
                        $con,
                        "SELECT 
                          pci.id,
                          pci.hospital_id,
                          pci.patient_id,
                          pci.case_id,
                          pci.treatment_name,
                          pci.doctor_id,
                          pci.expected_doa,
                          pci.status,
                          pci.hospital_id AS hospital_patients_id,
                          pci.patient_id,
                          pci.doctor_id,
                          h.id AS hospital_id,
                          h.name AS hospital_name,
                          ss.status AS status_logs_status,
                          ss.is_active,
                          s.status_name
                          FROM patient_cases_info pci
                          LEFT JOIN hospitals h ON pci.hospital_id = h.id 
                          LEFT JOIN patients p ON pci.patient_id = p.id 
                          LEFT JOIN status_logs ss ON pci.id = ss.case_id
                          LEFT JOIN 
                            status s ON ss.status = s.id
                          WHERE p.id = $pid AND ss.is_active = '1'"
                      );
                      $cnt = 1;
                      while ($row = mysqli_fetch_array($sql)) {
                      ?>
                        <tr>
                          <td>
                            <?php echo ($cnt) ?>
                          </td>
                          <td>
                            <a href="edit-patient.php?id=<?php echo $row['patient_id']; ?>" style="color:#000"><?php echo $row['patient_id'] ?></a>
                          </td>
                          <!-- Case Id -->
                          <td>
                            <a href="edit-case.php?id=<?php echo $row['id']; ?>" style="color:#000"><?php echo $row['id'] ?></a>
                          </td>
                          <!-- Hospital Case Id -->
                          <td>
                            <a style="color:#000"><?php echo $row['case_id'] ?></a>
                          </td>
                          <td>
                            <a style="color:#000"><?php echo $row['treatment_name'] ?></a>
                          </td>
                          <td>
                            <a style="color:#000"><?php echo $row['doctor_id'] ?></a>
                          </td>
                          <td>
                            <a href="edit-hospital.php?id=<?php echo $row['hospital_id']; ?>">
                              <?php echo $row['hospital_name'] ?>
                            </a>

                          </td>
                          <td>
                            <a style="color:#000"><?php
                                                  echo $row['status_name'] ?></a>
                          </td>
                          <td class="project-actions text-right">

                            <a class="btn btn-info btn-sm" href="edit-case.php?id=<?php echo $row['id']; ?>">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                            </a>
                          </td>
                        </tr>
                      <?php
                        $cnt = $cnt + 1;
                      } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->


        </section>
      </div>
      <?php include('include/footer.php') ?>
    </div>


    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    </div>

    <script src="./plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="./plugins/toastr/toastr.min.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="./plugins/jquery/jquery.min.js"></script>
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./plugins/select2/js/select2.full.min.js"></script>
    <script src="./plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="./plugins/daterangepicker/daterangepicker.js"></script>
    <script src="./plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="./plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="./plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script src="./plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <script src="./plugins/dropzone/min/dropzone.min.js"></script>
    <script src="./dist/js/adminlte.min.js"></script>
    <script src="./dist/js/demo.js"></script>


    <script>
      $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
          theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
          'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
          'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
          format: 'YYYY-MM-DD'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
          icons: {
            time: 'far fa-clock'
          }
        });

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: 'MM/DD/YYYY hh:mm A'
          }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
          },
          function(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
          }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
          format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
          $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function() {
          $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

      })
      // BS-Stepper Init
      document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
      })

      // DropzoneJS Demo Code Start
      Dropzone.autoDiscover = false

      // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
      var previewNode = document.querySelector("#template")
      previewNode.id = ""
      var previewTemplate = previewNode.parentNode.innerHTML
      previewNode.parentNode.removeChild(previewNode)

      var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "/target-url", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
      })

      myDropzone.on("addedfile", function(file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function() {
          myDropzone.enqueueFile(file)
        }
      })

      // Update the total progress bar
      myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
      })

      myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1"
        // And disable the start button
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
      })

      // Hide the total progress bar when nothing's uploading anymore
      myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0"
      })

      // Setup the buttons for all transfers
      // The "add files" button doesn't need to be setup because the config
      // `clickable` has already been specified.
      document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
      }
      document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true)
      }
      // DropzoneJS Demo Code End
    </script>
  </body>

  </html>
<?php } ?>