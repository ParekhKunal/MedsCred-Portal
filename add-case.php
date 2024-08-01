<?php
session_start();
//error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
  header('location:logout.php');
} else {

  $pid = intval($_GET['id']); //get patient id

  $uname = $_SESSION['login'];

  $conn = mysqli_query($con, "SELECT id, email from admin WHERE email = '$uname'");

  $numId = mysqli_fetch_assoc($conn);

  date_default_timezone_set('Asia/Kolkata'); // change according timezone
  $currentTime = date('Y-m-d   h:i:s A', time());

  $today = date('Y-m-d');

  if (isset($_POST['submit'])) {

    $hospital = $_POST['hospital'];
    $patient_id = $pid;
    $doctor = $_POST['doctor'];
    $case_id = $_POST['hospital_case_id'];
    $case_type = $_POST['case_type'];
    $treatment_name = $_POST['treatment_name'];
    $treatment_type = $_POST['treatment_type'];
    $attendant_name = $_POST['attendant_name'];
    $relationship_with_insured = $_POST['relationship'];
    $estimated_amount = $_POST['estimated_amount'];
    $estimated_stay = $_POST['estimated_stay'];
    $patient_admitted = $_POST['patient_admitted'];
    $doa = $_POST['doa'];
    $created_by = $numId["id"];
    $created_at = $currentTime;

    $sql_to_insert_casetype = mysqli_query($con, "UPDATE `patients` SET `loan_type` = '$case_type', `hospital_id` = '$hospital' WHERE id = $pid");

    $sql = mysqli_query($con, "INSERT INTO `patient_cases_info`(`hospital_id`, `patient_id`, `case_id`,`loan_type`, `treatment_name`,`treatment_type`, `doctor_id`, `attendant_name`, `relationship_with_insured`, `estimated_amount`,`estimated_stay`,`patient_admitted`, `expected_doa`, `status`,`created_by`,`inserted_by`,`created_at`) VALUES ('$hospital', '$patient_id', '$case_id','$case_type', '$treatment_name','$treatment_type', '$doctor', '$attendant_name', '$relationship_with_insured','$estimated_amount','$patient_admitted','$estimated_stay', '$doa', '1','$created_by','ADMIN','$created_at')");

    // $sql_status = mysqli_query($con, "INSERT INTO `status_logs`(`patient_id`, `case_id`,`status`, `is_active`,`created_by`,`inserted_by`,`created_at`) VALUES ('$patient_id', '$case_id','1','1','$created_by','ADMIN','$created_at')");


    if ($sql_to_insert_casetype && $sql) {

      $case_id = mysqli_insert_id($con);

      // Insert into status_logs table using the fetched case ID
      $sql_status = mysqli_query($con, "INSERT INTO `status_logs`(`patient_id`, `case_id`, `status`, `is_active`, `created_by`, `inserted_by`, `created_at`) VALUES ('$patient_id', '$case_id', '1', '1', '$created_by', 'ADMIN', '$created_at')");

      echo "<script>
      window.addEventListener('load', function() {
        Toast.fire({
          icon: 'success',
          title: 'Case Added successfully.'
        });

        setTimeout(function() {
          window.location.href = `edit-patient.php?id=$pid`;
        }, 3000);
      });
    </script>";
    }
  }


?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedsCred | Add Case</title>

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
    <link rel="shortcut icon" type="image/x-icon" href="dist/fav.png">
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
                <h1><b>New Case</b></h1>
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
                      <div class="col-md-6" id="hospital_type_container">
                        <label for="hospital">Hospital<span style="color:red">*</span></label>
                        <select class="form-control select2" name="hospital" id="inputHospital">
                          <option value="">Select a hospital</option>
                          <?php
                          $hospitals = mysqli_query($con, "SELECT id, name FROM hospitals");
                          while ($row = mysqli_fetch_array($hospitals)) {
                          ?>
                            <option value="<?php echo htmlentities($row['id']); ?>">
                              <?php echo htmlentities($row['name']); ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <label for="inputhospitalcaseid">Hospital Case ID No.</label>
                        <input type="text" class="form-control" name="hospital_case_id" id="inputhospitalcaseid" placeholder="Hospital Case ID No.">
                      </div>
                      <div class="col-md-2">
                        <label for="case_type">Finance Type<span style="color:red">*</span></label>
                        <select class="form-control select2" name="case_type" id="case_type" style="width: 100%;">
                          <option disabled <?php if (!$case->case_type) echo 'selected="selected"'; ?>>Select is Case Type</option>
                          <option value="1" <?php if ($case->case_type == '1') echo 'selected="selected"'; ?>>Reimbursement</option>
                          <option value="2" <?php if ($case->case_type == '2') echo 'selected="selected"'; ?>>Cashless</option>
                          <option value="3" <?php if ($case->case_type == '3') echo 'selected="selected"'; ?>>Asthetic</option>
                        </select>
                      </div>
                      <div class="col-md-2" id="cash_type_container" style="display: none;">
                        <label for="cash_type">Loan Type<span style="color:red">*</span></label>
                        <select class="form-control select2" name="cash_type" id="cash_type" style="width: 100%;">
                          <!-- Options will be populated by JavaScript -->
                        </select>
                      </div>


                    </div>
                    <div class="form-group row">
                      <div class="col-md-3">
                        <label for="doctor">Treating Doctor Name<span style="color:red">*</span></label>
                        <input type="text" class="form-control" name="doctor" id="inputdcotor" placeholder="Doctor Name">
                      </div>
                      <div class="col-md-3">
                        <label for="inputTreatmentName">Treatment Name<span style="color:red">*</span></label>
                        <input type="text" class="form-control" name="treatment_name" id="inputTreatmentName" placeholder="Treatment Name">
                      </div>
                      <div class="col-md-3">
                        <label for="inputTreatmentName">Treatment Type<span style="color:red">*</span></label>
                        <select class="form-control select2" name="treatment_type" id="treatment_type" style="width: 100%;">
                          <option disabled <?php if (!$case->treatment_type) echo 'selected="selected"'; ?>>Select is Treatment Type</option>
                          <option value="Surgical Management" <?php if ($case->treatment_type == 'Surgical Management') echo 'selected="selected"'; ?>>Surgical Managemen</option>
                          <option value="Medical Management" <?php if ($case->treatment_type == 'Medical Management') echo 'selected="selected"'; ?>>Medical Management</option>

                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="inputRelationship">Relationship With insured</label>
                        <!-- <input type="text" class="form-control" name="relationship" id="inputRelationship" placeholder="Relationship With insured"> -->
                        <select class="form-control select2" name="relationship" id="relationship" style="width: 100%;">
                          <option disabled <?php if (!$case->relationship) echo 'selected="selected"'; ?>>Select is Relationship With insured</option>
                          <option value="SELF" <?php if ($case->relationship == 'SELF') echo 'selected="selected"'; ?>>SELF</option>
                          <option value="DEPENDENT CHILD" <?php if ($case->relationship == 'DEPENDENT CHILD') echo 'selected="selected"'; ?>>DEPENDENT CHILD</option>
                          <option value="SPOUSE" <?php if ($case->relationship == 'SPOUSE') echo 'selected="selected"'; ?>>SPOUSE</option>
                          <option value="MOTHER" <?php if ($case->relationship == 'MOTHER') echo 'selected="selected"'; ?>>MOTHER</option>
                          <option value="FATHER" <?php if ($case->relationship == 'FATHER') echo 'selected="selected"'; ?>>FATHER</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-3">
                        <label for="inputestimatedamoutn">Estimated Amount<span style="color:red">*</span></label>
                        <input type="number" class="form-control" name="estimated_amount" id="inputestimatedamoutn" placeholder="Estimated Amount">
                      </div>
                      <div class="col-md-3">
                        <label for="inputestimatedamoutn">Estimated Stay<span style="color:red">*</span></label>
                        <input type="number" class="form-control" name="estimated_stay" id="inputestimatedamoutn" placeholder="Estimated Stay">
                      </div>
                      <div class="col-md-3">
                        <label for="inputPatientAdmitted">Is Patient Admitted Or Not?<span style="color:red">*</span></label>
                        <select class="form-control select2" name="patient_admitted" id="patient_admitted" style="width: 100%;">
                          <option disabled <?php if (!$case->patient_admitted) echo 'selected="selected"'; ?>>Select is Patient Admitted</option>
                          <option value="SPatient Admitted" <?php if ($case->patient_admitted == 'Patient Admitted') echo 'selected="selected"'; ?>>Patient Admitted</option>
                          <option value="Planned Admission" <?php if ($case->patient_admitted == 'Planned Admission') echo 'selected="selected"'; ?>>Planned Admission</option>

                        </select>
                      </div>
                      <div class="col-md-3">
                        <label for="inputDOA">D.O.A<span style="color:red">*</span></label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          <input type="text" class="form-control datetimepicker-input" placeholder="<?php echo $today; ?>" data-target="#reservationdate" name="doa" />
                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                        </div>
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
                              <h4 class="modal-title">Add Case!</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <p>Are you sure you want to add New Case?</p>
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


    <script>
      $(document).ready(function() {
        // Define options for each case type
        var cashTypeOptions = {
          '1': [{
              value: 'PDC',
              text: 'PDC'
            },
            {
              value: 'Loan',
              text: 'Loan'
            }
          ],
          '2': [
            // Define options for 'Cashless' case type if needed
          ],
          '3': [
            // Define options for 'Asthetic' case type if needed
          ]
        };

        // Function to populate cash type dropdown
        function populateCashTypeOptions(caseType) {
          var cashTypeDropdown = $('#cash_type');
          cashTypeDropdown.empty(); // Clear existing options

          if (cashTypeOptions[caseType]) {
            // Populate with new options
            cashTypeOptions[caseType].forEach(function(option) {
              cashTypeDropdown.append(new Option(option.text, option.value));
            });
          }
        }

        // Function to show/hide cash type container
        function toggleCashTypeContainer(caseType) {
          var cashTypeContainer = $('#cash_type_container');
          var hospitalName = $('#hospital_type_container');
          var hospitalNameId = $('#select2-inputHospital-container');
          if (caseType === '1') {
            cashTypeContainer.show(); // Show if 'Reimbursement' is selected
          } else {
            cashTypeContainer.hide(); // Hide otherwise
          }

        }

        // Event listener for case type dropdown change
        $('#case_type').change(function() {
          var selectedCaseType = $(this).val();
          populateCashTypeOptions(selectedCaseType);
          toggleCashTypeContainer(selectedCaseType);
        });

        // Initialize based on the current case type if available
        var currentCaseType = $('#case_type').val();
        if (currentCaseType) {
          populateCashTypeOptions(currentCaseType);
          toggleCashTypeContainer(currentCaseType);
        }
      });
    </script>

  </body>

  </html>
<?php } ?>