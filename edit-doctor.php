<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
  header('location:logout.php');
} else {

  date_default_timezone_set('Asia/Kolkata'); // change according timezone
  $currentTime = date('y-m-d h:i:s A', time());

  $did = intval($_GET['id']); // get hospital id

  $sql = mysqli_query(
    $con,
    "SELECT 
        d.hospital_id,
        d.first_name,
        d.middle_name,
        d.last_name,
        d.date_of_birth,
        d.gender,
        d.email,
        d.phone_number,
        d.qualification,
        d.experience,
        d.is_active,
        d.created_at,
        d.updated_at,
        h.name AS hospital_name,
        h.id AS hospital_id
    FROM doctors d
    JOIN hospitals h ON d.hospital_id = h.id
    WHERE d.id = '$did'"
  );

  $num = mysqli_fetch_assoc($sql);

  $doctor = (object) $num;


  if (isset($_POST['submit'])) {
    $hospital_id = $_POST['hospitalId'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $qualification = $_POST['qualification'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $experience = $_POST['experience'];
    // $password = md5($_POST['npass']);
    $sql_new = mysqli_query($con, "UPDATE `doctors`
            SET 
                `hospital_id` = '$hospital_id',
                `first_name` = '$first_name',
                `middle_name` = '$middle_name',
                `last_name` = '$last_name',
                `date_of_birth` = '$date_of_birth',
                `gender` = '$gender',
                `email` = '$email',
                `phone_number` = '$phone_number',
                `qualification` = '$qualification',
                `experience` = '$experience',
                `updated_at` = '$currentTime'
            WHERE `id` = '$did'");
    if ($sql_new) {
      echo "<script>

         window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Doctor Updated Successfully.'
                });

                setTimeout(function(){
                    window.location.href = 'edit-doctor.php?id=$did';
                }, 3000);
            });
           
        </script>";
    }
  }

  if (isset($_POST['delete-doctor-details'])) {
    $sql = mysqli_query($con, "UPDATE `doctors` SET `is_active`='0',`updated_at`='$currentTime' WHERE id = '$did'");
    if ($sql) {
      echo "<script>alert('Doctor Details Deleted Successfully');</script>";
      echo "<script>window.location.href =`docotrs.php`</script>";
    }
  }

?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedsCred | Doctor Detail</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="./plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="./plugins/toastr/toastr.min.css">

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
                <h1><span style="color:red"><?php echo ($doctor->first_name) ?> <?php echo ($doctor->last_name) ?></span>Doctor from <span style="color:red"><a href="edit-hospital.php?id=<?php echo ($doctor->hospital_id) ?>"><?php echo ($doctor->hospital_name) ?></a></span> Hospital</h1>
              </div>

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
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="country">Select Hospitals</label>
                    <select name="hospitalId" class="form-control select2" required="required">
                      <option value="<?php echo htmlentities($doctor->hospital_id); ?>">
                        <?php echo htmlentities($doctor->hospital_name); ?>
                      </option>
                      <?php $ret = mysqli_query($con, "SELECT id,name FROM hospitals");
                      while ($row = mysqli_fetch_array($ret)) {
                      ?>
                        <option value="<?php echo htmlentities($row['id']); ?>">
                          <?php echo htmlentities($row['name']); ?>
                        </option>
                      <?php } ?>
                    </select>
                  </div>

                </div>
                <div class="form-group row">
                  <div class="col-md-4">
                    <label for="inputFirstName">First Name</label>
                    <input type="text" class="form-control" value="<?php echo ($doctor->first_name); ?>" name="first_name" id="inputFirstName" placeholder="First Name">
                  </div>
                  <div class="col-md-4">
                    <label for="inputMiddleName">Middle Name</label>
                    <input type="text" class="form-control" name="middle_name" value="<?php echo ($doctor->middle_name); ?>" id="inputMiddleName" placeholder="Middle Name">
                  </div>
                  <div class="col-md-4">
                    <label for="inputLastName">Last Name</label>
                    <input type="text" class="form-control" name="last_name" value="<?php echo ($doctor->last_name); ?>" id="inputLastName" placeholder="Last Name">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-4">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Email" value="<?php echo ($doctor->email); ?>">
                  </div>
                  <div class="col-md-4">
                    <label for="inputPhoneNumber">phone_number</label>
                    <input type="text" class="form-control" name="phone_number" id="inputPhoneNumber" placeholder="Phone Number" value="<?php echo ($doctor->phone_number); ?>">
                  </div>
                  <div class="col-md-4">
                    <label for="inputExperience">Experience</label>
                    <input type="text" class="form-control" name="experience" id="inputExperience" placeholder="Experience" value="<?php echo ($doctor->experience); ?>">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-4">
                    <label for="gender">Gender</label>
                    <select class="form-control select2" name="gender" id="inputGender" style="width: 100%;">
                      <option disabled <?php if (!$doctor->gender) echo 'selected="selected"'; ?>>Select Gender</option>
                      <option value="Male" <?php if ($doctor->gender == 'Male') echo 'selected="selected"'; ?>>Male</option>
                      <option value="Female" <?php if ($doctor->gender == 'Female') echo 'selected="selected"'; ?>>Female</option>
                      <option value="Others" <?php if ($doctor->gender == 'Others') echo 'selected="selected"'; ?>>Others</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label for="inputDOB">Date Of Birth</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                      <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="date_of_birth" value="<?php echo ($doctor->date_of_birth) ?>" />
                      <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label for="inputDesignation">Qualification</label>
                    <input type="text" class="form-control" value="<?php echo ($doctor->qualification); ?>" id="inputQualification" name="qualification" placeholder="Qualification">
                  </div>
                </div>


                <div class="form-group row">
                  <div class="col-md-12">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default" style="margin-top: 10px;">
                      Submit
                    </button>
                  </div>
                  <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Add Doctor!</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Are you sure you want to update doctor?</p>
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
            <!-- /.card-body -->
          </div>

        </section>
        <!-- /.content -->
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