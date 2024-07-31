<?php
session_start();
//error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
  header('location:logout.php');
} else {
  $uname = $_SESSION['login'];
  
  $sql = mysqli_query($con, "SELECT 
    a.first_name,
    a.last_name,
    a.designation,
    a.email,
    a.phone_number,
    a.date_of_birth,
    a.gender,
    a.created_at,
    a.bio,
    ad.address_line_1, 
    ad.address_line_2,
    ad.education,
    ad.city,
    ad.state,
    ad.country,
    ad.pincode,
    c.id AS country_id,
    c.country_name
FROM 
    admin a
JOIN 
    admin_details ad ON a.id = ad.admin_id
JOIN 
    countries c ON ad.country = c.id
WHERE 
    a.email = '$uname'");
  $num = mysqli_fetch_assoc($sql);

  $admin = (object) $num;

  date_default_timezone_set('Asia/Kolkata'); // change according timezone
  $currentTime = date('d-m-Y h:i:s A', time());
  if (isset($_POST['submit'])) {
    $uname = $_SESSION['login'];

    $sql = mysqli_query($con, "SELECT first_name,middle_name,last_name,email,phone_number,bio,gender,date_of_birth,designation FROM admin where email='$uname'");
    $num = mysqli_fetch_array($sql);

    if ($num > 0) {
      $first_name = $_POST['firstName'];
      $middle_name = $_POST['middleName'];
      $last_name = $_POST['lastName'];
      $phone_number = $_POST['phone_number'];
      $bio = $_POST['bio'];
      $gender = $_POST['gender'];
      $date_of_birth = $_POST['date_of_birth'];
      $designation = $_POST['designation'];

      $con = mysqli_query($con, "UPDATE admin set first_name='$first_name',middle_name='$middle_name',last_name='$last_name',phone_number='$phone_number',bio='$bio',gender='$gender',date_of_birth='$date_of_birth',designation='$designation', updated_at='$currentTime' where email='$uname'");

      $_SESSION['msg1'] = "Your Profile Updated Successfully !!";
      header('location:profile.php');
    } else {
      $_SESSION['msg1'] = "Your Profile Updated Successfully !!";
    }
  }

  if (isset($_POST['submit-additional-info'])) {
    $uname = $_SESSION['login'];

    $sql = mysqli_query($con, "SELECT 
    a.id,
    ad.admin_id,
    ad.address_line_1, 
    ad.address_line_2,
    ad.education,
    ad.city,
    ad.state,
    ad.country,
    ad.pincode
    FROM 
        admin a
    JOIN 
        admin_details ad ON a.id = ad.admin_id
    WHERE 
        a.email = '$uname'");
    $num = mysqli_fetch_array($sql);

    if ($num > 0) {
      $address_line_1 = $_POST['address_line_1'];
      $address_line_2 = $_POST['address_line_2'];
      $city = $_POST['city'];
      $state = $_POST['state'];
      $country = $_POST['country'];
      $pincode = $_POST['pincode'];

      $con = mysqli_query($con, "UPDATE admin_details SET address_line_1='$address_line_1',address_line_2='$address_line_2',city='$city',state='$state',country='$country',pincode='$pincode', updated_at='$currentTime' where admin_id='{$num['id']}'");

      $_SESSION['msg1'] = "Your Profile Additional Info Updated Successfully !!";
      header('location:profile.php');
    } else {
      $_SESSION['msg1'] = "Your Profile Additional Info Updated Successfully !!";
    }
  }


?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedsCred | My Profile</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="./plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="./plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="./plugins/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="./plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="./plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="./plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="./plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="./plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="./plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="./plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  </head>

  <body class="hold-transition sidebar-mini">
    <div class="wrapper">
      <!-- Navbar -->
      <?php include('include/navbar.php'); ?>
      <?php include('include/sidebar.php'); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>My Profile</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">User Profile</li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
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

                    <h3 class="profile-username text-center"><?php echo ($admin->first_name) ?> <?php echo ($admin->last_name) ?></h3>

                    <p class="text-muted text-center"><?php echo ($admin->designation) ?></p>

                    <ul class="list-group list-group-unbordered mb-3">
                      <li class="list-group-item">
                        <b>Email</b> <a class="float-right"><?php echo ($admin->email) ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>Phone Number</b> <a class="float-right"><?php echo ($admin->phone_number) ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>Date Of Birth</b> <a class="float-right"><?php echo ($admin->date_of_birth) ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>gender</b> <a class="float-right"><?php echo ($admin->gender) ?></a>
                      </li>
                      <li class="list-group-item">
                        <b>Created At</b> <a class="float-right"><?php echo ($admin->created_at) ?></a>
                      </li>
                    </ul>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Education</strong>

                    <p class="text-muted">
                      <?php echo ($admin->education) ?>
                    </p>

                    <hr>

                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                    <p class="text-muted"><?php echo ($admin->address_line_1) ?>, <?php echo ($admin->address_line_2) ?>, <?php echo ($admin->city) ?>, <?php echo ($admin->state) ?>, <?php echo ($admin->country) ?>, <?php echo ($admin->pincode) ?></p>

                    <hr>




                    <strong><i class="far fa-file-alt mr-1"></i> Bio</strong>

                    <p class="text-muted"><?php echo ($admin->bio) ?></p>
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

                      <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Update Profile</a></li>
                      <li class="nav-item"><a class="nav-link" href="#additional-info" data-toggle="tab">Update Addtional Info</a></li>
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
                                <input type="text" class="form-control" value="<?php echo ($admin->first_name) ?>" id="inputFirstName" name="firstName" placeholder="Name">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label for="inputMiddleName" class="col-sm-12 col-form-label">Middle Name</label>
                              <div class="col-sm-12">
                                <input type="text" class="form-control" value="<?php echo ($admin->last_name) ?>" id="inputMiddleName" name="middleName" placeholder="Name">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label for="inputLastName" class="col-sm-12 col-form-label">Last Name</label>
                              <div class="col-sm-12">
                                <input type="text" class="form-control" value="<?php echo ($admin->last_name) ?>" id="inputLastName" name="lastName" placeholder="Name">
                              </div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-md-6">
                              <label for="inputEmail" class="col-sm-12 col-form-label">Email</label>
                              <div class="col-sm-12">
                                <input disabled type="email" value="<?php echo ($admin->email) ?>" class="form-control" id="inputEmail" placeholder="Email">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label for="inputPhoneNumber" class="col-sm-12 col-form-label">Phone Number</label>
                              <div class="col-sm-12">
                                <input type="text" name="phone_number" value="<?php echo ($admin->phone_number) ?>" class="form-control" id="inputPhoneNumber" placeholder="Phone Number">
                              </div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-md-4">
                              <label for="gender" class="col-sm-12 col-form-label">Gender</label>
                              <div class="col-sm-12">
                                <select class="form-control select2" name="gender" id="inputGender" style="width: 100%;">
                                  <option disabled <?php if (!$admin->gender) echo 'selected="selected"'; ?>>Select Gender</option>
                                  <option value="Male" <?php if ($admin->gender == 'Male') echo 'selected="selected"'; ?>>Male</option>
                                  <option value="Female" <?php if ($admin->gender == 'Female') echo 'selected="selected"'; ?>>Female</option>
                                  <option value="Others" <?php if ($admin->gender == 'Others') echo 'selected="selected"'; ?>>Others</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label for="inputDOB" class="col-sm-12 col-form-label">Date Of Birth</label>
                              <div class="col-sm-12">
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="date_of_birth" value="<?php echo ($admin->date_of_birth) ?>" />
                                  <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label for="inputDesignation" class="col-sm-12 col-form-label">Designation</label>
                              <div class="col-sm-12">
                                <input type="text" class="form-control" value="<?php echo ($admin->designation) ?>" id="inputDesignation" name="designation" placeholder="Designation">
                              </div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-md-12">
                              <label for="inputBio" class="col-sm-12 col-form-label">Bio</label>
                              <div class="col-sm-12">
                                <textarea rows="3" class="form-control" id="inputBio" name="bio" placeholder="Bio"><?php echo htmlspecialchars($admin->bio); ?></textarea>
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
                              <label for="inputAddressLine1" class="col-sm-12 col-form-label">Address Line 1</label>
                              <div class="col-sm-12">
                                <input type="text" class="form-control" value="<?php echo ($admin->address_line_1) ?>" id="inputAddressLine1" name="address_line_1" placeholder="Address Line 1">
                              </div>
                            </div>
                            <div class="col-md-12">
                              <label for="inputAddressLine2" class="col-sm-12 col-form-label">Address Line 1</label>
                              <div class="col-sm-12">
                                <input type="text" class="form-control" value="<?php echo ($admin->address_line_2) ?>" id="inputAddressLine2" name="address_line_2" placeholder="Address Line 2">
                              </div>
                            </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-md-3">
                              <label for="inputCity" class="col-sm-12 col-form-label">City</label>
                              <div class="col-sm-12">
                                <input type="text" value="<?php echo ($admin->city) ?>" class="form-control" name="city" id="inputCity" placeholder="City">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <label for="inputState" class="col-sm-12 col-form-label">State</label>
                              <div class="col-sm-12">
                                <input type="text" value="<?php echo ($admin->state) ?>" class="form-control" name="state" id="inputState" placeholder="State">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <label for="country" class="col-sm-12 col-form-label">Country</label>
                              <select class="form-control select2" name="country" id="inputCountry" style="width: 100%;">
                                <option value="<?php echo ($admin->country_id); ?>">
                                  <?php echo ($admin->country_name); ?>
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
                              <label for="inputPinCode" class="col-sm-12 col-form-label">Pin Code</label>
                              <div class="col-sm-12">
                                <input type="text" value="<?php echo ($admin->pincode) ?>" class="form-control" name="pincode" id="inputPinCode" placeholder="pincode">
                              </div>
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
            <!-- /.card -->
          </div>
          <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->


    </section>

    </div>


    </div>
    <!-- /.content-wrapper -->
    <?php include('include/footer.php') ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <!-- jQuery -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="./plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="./plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="./plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="./plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="./plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="./plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="./plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="./plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
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