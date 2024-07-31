<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
  header('location:logout.php');
} else {

  date_default_timezone_set('Asia/Kolkata'); // change according timezone
  $currentTime = date('d-m-Y h:i:s A', time());

  $hid = intval($_GET['id']); // get hospital id

  $sql = mysqli_query(
    $con,
    "SELECT 
        h.name,
        h.email,
        h.phone_number,
        h.address_line_1,
        h.address_line_2,
        h.city,
        h.state,
        h.country,
        h.pincode,
        h.created_by,
        h.verified_by,
        h.is_active,
        h.created_at,
        h.updated_at,
        a.first_name,
        a.last_name,
        c.country_name,
        c.id AS country_id
    FROM hospitals h
    JOIN countries c ON h.country = c.id
    JOIN admin a ON h.verified_by = a.id
    WHERE h.id = '$hid'"
  );

  $num = mysqli_fetch_assoc($sql);

  $hospital = (object) $num;



  if (isset($_POST['verify-hospital'])) {

    $uname = $_SESSION['login'];

    $get_user_id = mysqli_query($con, "SELECT id FROM admin WHERE email = '$uname'");
    $userID = mysqli_fetch_assoc($get_user_id);

    $admin = (object) $userID;
    $adminID = $admin->id;

    $conn = mysqli_query($con, "UPDATE hospitals SET verified_by='$adminID' WHERE id = '$hid'");

    // $_SESSION['msg1'] = "Hospital Verification Successfull !!";

    // echo "<script>window.location.href ='hospitals.php'</script>";

    if ($conn) {
      echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Hospital Verification successfully.'
                });

                setTimeout(function(){
                    window.location.href = 'edit-hospital.php?id=$hid';
                }, 3000);
            });
           
            
           
        </script>";
    }
    // echo "<script>window.location.href ='hospitals.php'</script>";
  } else {

    $_SESSION['msg1'] = "Something went wrong!";
  }

  if (isset($_POST['update-hospital-details'])) {
    $name = $_POST['hospital_name'];
    $hospital_email = $_POST['hospital_email'];
    $hospital_phone_number = $_POST['hospital_phone_number'];
    $hospital_address_line_1 = $_POST['hospital_address_line_1'];
    $hospital_address_line_2 = $_POST['hospital_address_line_2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pincode = $_POST['pincode'];
    // $password = md5($_POST['npass']);
    $sql = mysqli_query($con, "UPDATE `hospitals` SET `name`='$name',`email`='$hospital_email',`phone_number`='$hospital_phone_number',`address_line_1`='$hospital_address_line_1',`address_line_2`='$hospital_address_line_2',`city`='$city',`state`='$state',`country`='$country',`pincode`='$pincode',`updated_at`='$currentTime' WHERE id = '$hid'");
    if ($sql) {

      echo "<script>

         window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Hospital Info Updated successfully.'
                });

                setTimeout(function(){
                    window.location.href = 'edit-hospital.php?id=$hid';
                }, 4000);
            });
           
            
           
        </script>";

      // echo "<script>window.location.href =`edit-hospital.php?id=$hid`</script>";
    }
  }

  if (isset($_POST['delete-hospital-details'])) {
    $sql = mysqli_query($con, "UPDATE `hospitals` SET `is_active`='0',`updated_at`='$currentTime' WHERE id = '$hid'");
    if ($sql) {
      echo "<script>

         window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'error',
                    title: 'Hospital Deleted successfully.'
                });

                setTimeout(function(){
                    window.location.href = 'hospitals.php';
                }, 3000);
            });
           
            
           
        </script>";
    }
  }


  $sql_doc_stats = mysqli_query(
    $con,
    "SELECT 
    COUNT(*) as doctor_count
    FROM 
        doctors d
    JOIN 
        hospitals h 
    ON 
        d.hospital_id = h.id
    WHERE 
        h.id = '$hid'"
  );
  $num_doc_stats = mysqli_fetch_assoc($sql_doc_stats);
  $doc_stats = (object) $num_doc_stats;


?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedsCred | Hospital Detail</title>

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

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="./plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="./plugins/toastr/toastr.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">



    <!-- Theme style -->


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
      // Toast configuration
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
    <!-- Site wrapper -->
    <div class="wrapper">

      <?php include('include/navbar.php') ?>
      <?php include('include/sidebar.php') ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1><?php echo ($hospital->name) ?> Hospital</h1>
              </div>
              <?php if ($hospital->verified_by) {
              ?>
                <div class="col-sm-6 " style="display: flex;justify-content:end;">
                  <button class="btn btn-primary" disabled>Verified</button><br>
                </div>
              <?php } else { ?>
                <div class="col-sm-6 " style="display: flex;justify-content:end">
                  <form method="post">
                    <button type="submit" name="verify-hospital" class="btn btn-danger">Verify Now</button>
                  </form>
                </div>
              <?php } ?>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Hospital Stats</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                  <div class="row">
                    <div class="col-12 col-md-4 col-sm-4">
                      <div class="info-box bg-light">
                        <div class="info-box-content">
                          <span class="info-box-text text-center text-muted">Total Patients</span>
                          <span class="info-box-number text-center text-muted mb-0">2300</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-4 col-sm-4">
                      <div class="info-box bg-light">
                        <div class="info-box-content">
                          <span class="info-box-text text-center text-muted">Total Cashless Patients</span>
                          <span class="info-box-number text-center text-muted mb-0">2000</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-4 col-sm-4">
                      <div class="info-box bg-light">
                        <div class="info-box-content">
                          <span class="info-box-text text-center text-muted">Total Reimbursement Patients</span>
                          <span class="info-box-number text-center text-muted mb-0">20</span>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-md-4 col-sm-4">
                      <div class="info-box bg-light">
                        <div class="info-box-content">
                          <span class="info-box-text text-center text-muted">Total Doctors</span>
                          <span class="info-box-number text-center text-muted mb-0"><?php echo ($doc_stats->doctor_count) ?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <!-- /.card-body -->
          </div>

          <!-- /.card -->

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">View/Edit Hospital Details</h3>
            </div>
            <div class="card-body">
              <form method="post">
                <div class="form-group">
                  <label for="inputHospitalName">Hospital Name</label>
                  <input type="text" value="<?php echo ($hospital->name) ?>" id="inputHospitalName" name="hospital_name" class="form-control" required>
                </div>
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="inputHospitalEmail">Hospital Email</label>
                    <input type="email" value="<?php echo ($hospital->email) ?>" id="inputHospitalEmail" name="hospital_email" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label for="inputHospitalPhoneNumber">Hospital Phone Number</label>
                    <input type="text" id="inputHospitalPhoneNumber" value="<?php echo ($hospital->phone_number) ?>" name="hospital_phone_number" class="form-control">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="inputHospitalAddress1">Address Line 1</label>
                    <input type="text" id="inputHospitalAddress1" value="<?php echo ($hospital->address_line_1) ?>" name="hospital_address_line_1" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label for="inputHospitalAddress2">Address Line 2</label>
                    <input type="text" id="inputHospitalAddress2" value="<?php echo ($hospital->address_line_2) ?>" name="hospital_address_line_2" class="form-control">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="inputCity">City</label>
                    <input type="text" value="<?php echo ($hospital->city) ?>" class="form-control" name="city" id="inputCity" placeholder="City">
                  </div>
                  <div class="col-md-6">
                    <label for="inputState">State</label>
                    <input type="text" value="<?php echo ($hospital->state) ?>" class="form-control" name="state" id="inputState" placeholder="State">
                  </div>

                </div>

                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="country">Country</label>
                    <select class="form-control select2" name="country" id="inputCountry">
                      <option value="<?php echo ($hospital->country_id); ?>">
                        <?php echo ($hospital->country_name); ?>
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
                  <div class="col-md-6">
                    <label for="inputPinCode">Pin Code</label>
                    <input type="text" value="<?php echo ($hospital->pincode) ?>" class="form-control" name="pincode" id="inputPinCode" placeholder="pincode">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-12" style="display: flex;justify-content:space-between">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default" style="margin-top: 10px;">
                      Submit
                    </button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" style="margin-top: 10px;">
                      Delete
                    </button>
                  </div>
                  <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Hospital Detail Updation!</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Are you sure you want to update hospital details?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          <button type="submit" name="update-hospital-details" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>

                  <div class="modal fade" id="modal-delete">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Hospital Detail Deletion!</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Are you sure you want to delete hospital details?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          <button type="submit" name="delete-hospital-details" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                </div>
              </form>

            </div>
            <!-- /.card-body -->
          </div>

        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
          <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
      </footer>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- SweetAlert2 -->
    <script src="./plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="./plugins/toastr/toastr.min.js"></script>


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