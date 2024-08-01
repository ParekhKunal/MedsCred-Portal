<?php
session_start();
//error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
  header('location:logout.php');
} else {

  $uname = $_SESSION['login'];

  $conn = mysqli_query($con, "SELECT id, email from admin WHERE email = '$uname'");

  $numId = mysqli_fetch_assoc($conn);

  date_default_timezone_set('Asia/Kolkata'); // change according timezone
  $currentTime = date('Y-m-d h:i:s A', time());

  if (isset($_POST['submit'])) {
    $hospital_types = isset($_POST['hospital_type']) ? $_POST['hospital_type'] : array();
    $name = $_POST['hospital_name'];
    $hospital_email = $_POST['hospital_email'];
    $hospital_phone_number = $_POST['hospital_phone_number'];
    $hospital_address_line_1 = $_POST['hospital_address_line_1'];
    $hospital_address_line_2 = $_POST['hospital_address_line_2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pincode = $_POST['pincode'];
    $account_holder_name = $_POST['account_holder_name'];
    $account_number = $_POST['account_number'];
    $bank_name = $_POST['bank_name'];
    $ifsc_code = $_POST['ifsc_code'];
    $account_type = $_POST['account_type'];
    $reimburse_commission = $_POST['reimburse_commission'];
    $cashless_commission = $_POST['cashless_commission'];
    $asthetic_commission = $_POST['asthetic_commission'];
    $verified_by = $numId['id'];
    // $password = md5($_POST['npass']);

    $hospital_types_string = implode(',', $hospital_types);

    $sql = mysqli_query($con, "INSERT INTO `hospitals`(`hospital_type`,`name`, `email`, `phone_number`, `address_line_1`, `address_line_2`, `city`, `state`, `country`, `pincode`,`account_holder_name`,`account_number`,`bank_name`,`ifsc_code`,`account_type`,`reimburse_commission`,`cashless_commission`,`asthetic_commission`,`verified_by`, `is_active`, `created_at`) VALUES('$hospital_types_string','$name','$hospital_email','$hospital_phone_number','$hospital_address_line_1','$hospital_address_line_2','$city','$state','$country','$pincode','$account_holder_name','$account_number','$bank_name','$ifsc_code','$account_type','$reimburse_commission','$cashless_commission','$asthetic_commission','$verified_by','1','$currentTime')");
    if ($sql) {
      echo "<script>
            window.addEventListener('load', function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Hospital added successfully.'
                });
            });
            setTimeout(function(){
                window.location.href = 'hospitals.php';
            }, 3000);
        </script>";
    }
  }


?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedsCred | Add Hospital</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">

    <link rel="shortcut icon" type="image/x-icon" href="dist/fav.png">

    <!-- Select2 -->
    <link rel="stylesheet" href="./plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="./plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="./plugins/daterangepicker/daterangepicker.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="./plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="./plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="./plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="./plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="./plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

    <!-- dropzonejs -->
    <link rel="stylesheet" href="./plugins/dropzone/min/dropzone.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="./plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="./plugins/toastr/toastr.min.css">


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
      <!-- Navbar -->
      <?php include('include/navbar.php') ?>

      <?php include('include/sidebar.php') ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Add Hospital</h1>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-body">
                  <form method="post">

                    <div class="form-group row">
                      <div class="col-md-3">
                        <label for="hospital_type" class="form-label">Hospital Type</label>
                        <select class="form-control select2" id="hospital_type" name="hospital_type[]" multiple aria-label="Select multiple options">
                          <option value="Reimbursement">Reimbursement</option>
                          <option value="Cashless">Cashless</option>
                          <option value="Asthetic">Asthetic</option>
                        </select>
                      </div>

                      <div class="col-md-3">
                        <label for="inputHospitalName">Hospital Name</label>
                        <input type="text" id="inputHospitalName" placeholder="Hospital Name" name="hospital_name" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label for="inputHospitalEmail">Hospital Email</label>
                        <input type="email" id="inputHospitalEmail" placeholder="Hospital Email" name="hospital_email" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label for="inputHospitalPhoneNumber">Hospital Phone Number</label>
                        <input type="text" id="inputHospitalPhoneNumber" placeholder="Hospital Phone Number" name="hospital_phone_number" class="form-control">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-3">
                        <label for="account_holder_name">Account Holder Name</label>
                        <input type="text" id="account_holder_name" name="account_holder_name" class="form-control">
                      </div>
                      <div class="col-md-3">
                        <label for="account_number">Account Number</label>
                        <input type="text" id="account_number" name="account_number" class="form-control">
                      </div>
                      <div class="col-md-2">
                        <label for="bankName">Bank Name</label>
                        <input type="text" id="bankName" name="bank_name" class="form-control">
                      </div>
                      <div class="col-md-2">
                        <label for="ifsc_code">IFSC Code</label>
                        <input type="text" id="ifsc_code" name="ifsc_code" class="form-control">
                      </div>
                      <div class="col-md-2">
                        <label for="account_type">IFSC Code</label>
                        <input type="text" id="account_type" name="account_type" class="form-control">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-2">
                        <label for="inputHospitalAddress1">Address Line 1</label>
                        <input type="text" id="inputHospitalAddress1" name="hospital_address_line_1" class="form-control">
                      </div>
                      <div class="col-md-2">
                        <label for="inputHospitalAddress2">Address Line 2</label>
                        <input type="text" id="inputHospitalAddress2" name="hospital_address_line_2" class="form-control">
                      </div>
                      <div class="col-md-2">
                        <label for="inputCity">City</label>
                        <input type="text" value="<?php echo ($admin->city) ?>" class="form-control" name="city" id="inputCity" placeholder="City">
                      </div>
                      <div class="col-md-2">
                        <label for="inputState">State</label>
                        <input type="text" value="<?php echo ($admin->state) ?>" class="form-control" name="state" id="inputState" placeholder="State">
                      </div>
                      <div class="col-md-2">
                        <label for="country">Country</label>
                        <select class="form-control select2" name="country" id="inputCountry">
                          <?php $ret = mysqli_query($con, "SELECT id,country_name FROM countries");
                          while ($row = mysqli_fetch_array($ret)) {
                          ?>
                            <option value="<?php echo htmlentities($row['id']); ?>">
                              <?php echo htmlentities($row['country_name']); ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <label for="inputPinCode">Pin Code</label>
                        <input type="text" value="<?php echo ($admin->pincode) ?>" class="form-control" name="pincode" id="inputPinCode" placeholder="pincode">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-4">
                        <label for="reimburse_commission">Reimbursement Commission </label>
                        <input type="text" id="reimburse_commission" name="reimburse_commission" class="form-control">
                      </div>
                      <div class="col-md-4">
                        <label for="cashless_commission">Cashless Commission </label>
                        <input type="text" id="cashless_commission" name="cashless_commission" class="form-control">
                      </div>

                      <div class="col-md-4">
                        <label for="asthetic_commission ">Asthetic Commission </label>
                        <input type="text" id="asthetic_commission" name="asthetic_commission" class="form-control">
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
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
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

    <!-- SweetAlert2 -->
    <script src="./plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="./plugins/toastr/toastr.min.js"></script>


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