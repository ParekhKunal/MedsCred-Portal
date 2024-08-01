<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
  header('location:logout.php');
} else {

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedsCred | Reimbursement Patients List</title>
    <link rel="shortcut icon" type="image/x-icon" href="dist/fav.png">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
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
                <h1>Reimbursement Patients List</h1>
              </div>

              <div class="col-sm-6 " style="display: flex;justify-content:end">
                <a href="add-patient.php" class="btn btn-primary">Add Patients</a>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <section class="content" style="margin-bottom: 20px;">
          <div class="row">
            <div class="col-md-12">
              <form method="get">
                <div class="input-group">
                  <input type="text" name="searchdata" class="form-control form-control-lg" placeholder="Type to find doctor by Name/Email/Phone Number here">
                  <div class="input-group-append">
                    <button type="submit" name="search" class="btn btn-lg btn-default">
                      <i class="fa fa-search"></i>
                    </button>
                    <a href="reimbursement.php" class="btn btn-lg btn-default">Reload</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </section>

        <section class="content" style="margin-bottom: 20px;">
          <div class="col-md-12 row ">
            <div class="dropdown" style="margin-left: 10px;">
              <a name="status" id="admissionJourney" class="btn btn-secondary" type="button">
                ADMISSION JOURNEY

                <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 1");
                                                                                                                            $row = mysqli_fetch_assoc($sql);
                                                                                                                            echo ($row['status_count'])
                                                                                                                            ?></span>
              </a>

            </div>
            <div class="dropdown" style="margin-left: 10px;">
              <a class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                ADMISSION APPROVAL
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                <a id="ClaimIntimationDone" class="btn btn-secondary dropdown-item" type="button">Claim Intimation Done <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 2");
                                                                                                                                                                                                                                    $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                    echo ($row['status_count'])
                                                                                                                                                                                                                                    ?></span></a>
                <a id="CIBILCheckDONE" class="btn btn-secondary dropdown-item" type="button">CIBIL Check Done <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 3");
                                                                                                                                                                                                                          $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                          echo ($row['status_count'])
                                                                                                                                                                                                                          ?></span></a>
                <a id="CardDecodingDone" class="btn btn-secondary dropdown-item" type="button">Card Decoding Done <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 4");
                                                                                                                                                                                                                              $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                              echo ($row['status_count'])
                                                                                                                                                                                                                              ?></span></a>
              </div>
            </div>
            <div class="dropdown" style="margin-left: 10px;">
              <a class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                DISCHARGE JOURNEY
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                <a id="DischargeInitiated" class="btn btn-secondary dropdown-item" type="button">Discharge Initiated <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 5");
                                                                                                                                                                                                                                $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                echo ($row['status_count'])
                                                                                                                                                                                                                                ?></span></a>
                <a id="DischargeQueryRaised" class="btn btn-secondary dropdown-item" type="button">Discharge Query Raised <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 6");
                                                                                                                                                                                                                                      $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                      echo ($row['status_count'])
                                                                                                                                                                                                                                      ?></span></a>
                <a id="DischargeQueryReplied" class="btn btn-secondary dropdown-item" type="button">Discharge Query Replied <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 7");
                                                                                                                                                                                                                                        $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                        echo ($row['status_count'])
                                                                                                                                                                                                                                        ?></span></a>
                <a id="NMEApprove" class="btn btn-secondary dropdown-item" type="button">NME Approved <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 8");
                                                                                                                                                                                                                  $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                  echo ($row['status_count'])
                                                                                                                                                                                                                  ?></span></a>
                <a id="NMEChallenge" class="btn btn-secondary dropdown-item" type="button">NME Challenged <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 9");
                                                                                                                                                                                                                      $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                      echo ($row['status_count'])
                                                                                                                                                                                                                      ?></span></a>
                <a id="FileDispatchInitiate" class="btn btn-secondary dropdown-item" type="button">File Dispatch - Initiated <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 10");
                                                                                                                                                                                                                                        $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                        echo ($row['status_count'])
                                                                                                                                                                                                                                        ?></span></a>
                <a id="FileDisptachQueryRaised" class="btn btn-secondary dropdown-item" type="button">File Dispatch - Query Raised <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 11");
                                                                                                                                                                                                                                              $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                              echo ($row['status_count'])
                                                                                                                                                                                                                                              ?></span></a>
                <a id="FileDisptachQueryResolve" class="btn btn-secondary dropdown-item" type="button">File Dispatch - Query Resolved <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 12");
                                                                                                                                                                                                                                                  $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                                  echo ($row['status_count'])
                                                                                                                                                                                                                                                  ?></span></a>
                <a id="FileDispatchApprove" class="btn btn-secondary dropdown-item" type="button">File Dispatch - Approved <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 13");
                                                                                                                                                                                                                                      $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                      echo ($row['status_count'])
                                                                                                                                                                                                                                      ?></span></a>
                <a id="PODDetailUpdate" class="btn btn-secondary dropdown-item" type="button">POD Detail Updated <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 14");
                                                                                                                                                                                                                            $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                            echo ($row['status_count'])
                                                                                                                                                                                                                            ?></span></a>
              </div>
            </div>
            <div class="dropdown" style="margin-left: 10px;">
              <a class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                SETTLEMENT JOURNEY
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                <a id="FileSent" class="btn btn-secondary dropdown-item" type="button">File Sent <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 15");
                                                                                                                                                                                                            $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                            echo ($row['status_count'])
                                                                                                                                                                                                            ?></span></a>
                <a id="ClaimUnderProcess" class="btn btn-secondary dropdown-item" type="button">Claim Under Process <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 16");
                                                                                                                                                                                                                                $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                echo ($row['status_count'])
                                                                                                                                                                                                                                ?></span></a>
                <a id="ClaimUnderQuery" class="btn btn-secondary dropdown-item" type="button">Claim Under Query <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 17");
                                                                                                                                                                                                                            $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                            echo ($row['status_count'])
                                                                                                                                                                                                                            ?></span></a>
                <a id="QueryReplyInitiated" class="btn btn-secondary dropdown-item" type="button">Query Reply Initiated <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 18");
                                                                                                                                                                                                                                    $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                    echo ($row['status_count'])
                                                                                                                                                                                                                                    ?></span></a>
                <a id="QueryDispatchQueryRaised" class="btn btn-secondary dropdown-item" type="button">Query Dispatch - Query Raised <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 19");
                                                                                                                                                                                                                                                $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                                echo ($row['status_count'])
                                                                                                                                                                                                                                                ?></span></a>
                <a id="QueryDisptachQueryResolve" class="btn btn-secondary dropdown-item" type="button">Query Dispatch - Query Resolved <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 20");
                                                                                                                                                                                                                                                    $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                                    echo ($row['status_count'])
                                                                                                                                                                                                                                                    ?></span></a>
                <a id="QueryDisptachApprove" class="btn btn-secondary dropdown-item" type="button">Query Dispatch - Approved <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 21");
                                                                                                                                                                                                                                        $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                        echo ($row['status_count'])
                                                                                                                                                                                                                                        ?></span></a>
                <a id="QuerySent" class="btn btn-secondary dropdown-item" type="button">Query Sent <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 22");
                                                                                                                                                                                                              $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                              echo ($row['status_count'])
                                                                                                                                                                                                              ?></span></a>
                <a id="ClaimApprove" class="btn btn-secondary dropdown-item" type="button">Claim Approved <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 23");
                                                                                                                                                                                                                      $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                      echo ($row['status_count'])
                                                                                                                                                                                                                      ?></span></a>
                <a id="ClaimShortSettled" class="btn btn-secondary dropdown-item" type="button">Claim Short Settled <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 24");
                                                                                                                                                                                                                                $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                echo ($row['status_count'])
                                                                                                                                                                                                                                ?></span></a>
                <a id="ClaimSettled" class="btn btn-secondary dropdown-item" type="button">Claim Settled <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 25");
                                                                                                                                                                                                                    $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                    echo ($row['status_count'])
                                                                                                                                                                                                                    ?></span></a>
                <a id="ClaimRejected" class="btn btn-secondary dropdown-item" type="button">Claim Rejected <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 26");
                                                                                                                                                                                                                      $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                      echo ($row['status_count'])
                                                                                                                                                                                                                      ?></span></a>
              </div>
            </div>
            <div class="dropdown" style="margin-left: 10px;">
              <a class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                CLAIMS TAKEN BACK
              </a>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                <a id="RejectAtAdmission" class="btn btn-secondary dropdown-item" type="button">Reject At admission time <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 27");
                                                                                                                                                                                                                                    $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                    echo ($row['status_count'])
                                                                                                                                                                                                                                    ?></span></a>
                <a id="RejectAtDischarge" class="btn btn-secondary dropdown-item" type="button">Rejected At Discharge time <span style="border-radius: 20px;border:1px solid red;padding-left:20px;padding-right:20px;background:red"><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS status_count FROM status_logs ss WHERE is_active = 1 AND ss.status = 28");
                                                                                                                                                                                                                                      $row = mysqli_fetch_assoc($sql);
                                                                                                                                                                                                                                      echo ($row['status_count'])
                                                                                                                                                                                                                                      ?></span></a>
              </div>
            </div>
          </div>


        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="card">
            <div class="card-header">

              <div class="card-tools">
                <span>
                  <?php $sql = mysqli_query($con, "SELECT COUNT(*) AS total_patients 
                    FROM patient_cases_info 
                    WHERE loan_type = 1;");
                  $row = mysqli_fetch_assoc($sql);

                  echo ($row['total_patients'])
                  ?> Patient Cases</span>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table table-striped projects">
                <thead>
                  <tr>
                    <th style="width: 10%">
                      Sr No.
                    </th>
                    <th style="width: 10%">
                      Patient Id
                    </th>
                    <th style="width: 5%">
                      Case Type
                    </th>
                    <th style="width: 10%">
                      Case Id
                    </th>
                    <th style="width: 20%">
                      Treatment Name.
                    </th>
                    <th style="width: 25%">
                      Name
                    </th>
                    <th style="width: 20%">
                      Email
                    </th>
                    <th style="width: 20%">
                      Phone No.
                    </th>

                    <th style="width: 20%">
                      Status
                    </th>
                    <th style="width: 20%">
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Initialize search condition
                  $searchCondition = "";
                  $filter = ''; // Initialize filter variable

                  // Check if search form is submitted
                  if (isset($_GET['search'])) {
                    $search = $_GET['searchdata'];
                    // Add search condition to SQL query
                    $searchCondition = " AND (p.first_name LIKE '%$search%' OR p.last_name LIKE '%$search%' OR p.email LIKE '%$search%' OR p.phone_number LIKE '%$search%' )";
                  }

                  if (isset($_GET['status'])) {
                    $status = $_GET['status'];
                    $filter = " AND ss.status = '$status'"; // Update the filter condition based on your column
                  }

                  $sql = mysqli_query(
                    $con,
                    "SELECT 
                    p.id,
                    p.id AS patient_id,
                    p.first_name,
                    p.middle_name,
                    p.last_name,
                    p.email,
                    p.phone_number,
                    p.tpa,
                    p.created_at,
                    pci.id,
                    pci.loan_type,
                    pci.treatment_name,
                    pci.id AS case_id,
                    ss.status,
                    s.status_name
                    FROM 
                        patients p 
                        LEFT JOIN patient_cases_info pci ON p.id = pci.patient_id
                        LEFT JOIN status_logs ss ON pci.id = ss.case_id
                        LEFT JOIN status s ON ss.status = s.id
                    WHERE 
                        p.is_active = 1 AND pci.loan_type=1 AND ss.is_active = '1' $searchCondition $filter"
                  );
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($sql)) {
                  ?>
                    <tr>
                      <td>
                        <?php echo ($cnt) ?>
                      </td>
                      <td>
                        <a href="edit-patient.php?id=<?php echo $row['patient_id']; ?>" style="color:#000">
                          <?php echo $row['patient_id'] ?>
                        </a>
                      </td>
                      <td>
                        <a href="#" style="color:#000">
                          REIMBURSEMENT
                        </a>
                      </td>
                      <td>
                        <a href="edit-case.php?id=<?php echo $row['case_id']; ?>">
                          <?php echo $row['case_id'] ?>
                        </a>
                      </td>
                      <td>
                        <a href="" style="color:#000"><?php echo $row['treatment_name'] ?></a>
                      </td>
                      <td>
                        <a href="edit-patient.php?id=<?php echo $row['id']; ?>">
                          <?php echo $row['first_name'] ?> <?php echo $row['last_name'] ?>
                        </a>
                        <br />
                        <small>
                          Created <?php echo $row['created_at'] ?>
                        </small>
                      </td>
                      <td>
                        <a href="" style="color:#000"><?php echo $row['email'] ?></a>
                      </td>
                      <td>
                        <a href="" style="color:#000"><?php echo $row['phone_number'] ?></a>
                      </td>

                      <td>
                        <a href="" style="color:#000"><?php echo $row['status_name'] ?></a>
                      </td>
                      <td class="project-actions text-right">

                        <a class="btn btn-info btn-sm" href="edit-patient.php?id=<?php echo $row['id']; ?>">
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

            <!-- /.card-body -->
          </div>
          <!-- /.card -->

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

    <!-- jQuery -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="./dist/js/demo.js"></script>

    <script>
      $(document).ready(function() {
        // Handle click events for dropdown items
        $('#admissionJourney').click(function() {
          window.location.href = '?status=1'; // Set your query parameter for filtering
        });

        $('#ClaimIntimationDone').click(function() {
          window.location.href = '?status=2'; // Update with correct status
        });

        $('#CIBILCheckDONE').click(function() {
          window.location.href = '?status=3'; // Update with correct status
        });

        $('#CardDecodingDone').click(function() {
          window.location.href = '?status=4'; // Update with correct status
        });

        $('#DischargeInitiated').click(function() {
          window.location.href = '?status=5'; // Update with correct status
        });

        $('#DischargeQueryRaised').click(function() {
          window.location.href = '?status=6'; // Update with correct status
        });

        $('#DischargeQueryReplied').click(function() {
          window.location.href = '?status=7'; // Update with correct status
        });

        $('#NMEApprove').click(function() {
          window.location.href = '?status=8'; // Update with correct status
        });

        $('#NMEChallenge').click(function() {
          window.location.href = '?status=9'; // Update with correct status
        });

        $('#FileDispatchInitiate').click(function() {
          window.location.href = '?status=10'; // Update with correct status
        });

        $('#FileDispatchQueryRaised').click(function() {
          window.location.href = '?status=11'; // Update with correct status
        });

        $('#FileDisptachQueryResolve').click(function() {
          window.location.href = '?status=12'; // Update with correct status
        });

        $('#FileDisptachApprove').click(function() {
          window.location.href = '?status=13'; // Update with correct status
        });

        $('#PODDetailUpdate').click(function() {
          window.location.href = '?status=14'; // Update with correct status
        });

        $('#FileSent').click(function() {
          window.location.href = '?status=15'; // Update with correct status
        });

        $('#ClaimUnderProcess').click(function() {
          window.location.href = '?status=16'; // Update with correct status
        });

        $('#ClaimUnderQuery').click(function() {
          window.location.href = '?status=17'; // Update with correct status
        });

        $('#QueryReplyInitiated').click(function() {
          window.location.href = '?status=18'; // Update with correct status
        });

        $('#QueryReplyQueryRaised').click(function() {
          window.location.href = '?status=19'; // Update with correct status
        });

        $('#QueryDisptachQueryResolve').click(function() {
          window.location.href = '?status=20'; // Update with correct status
        });

        $('#QueryDisptachApprove').click(function() {
          window.location.href = '?status=21'; // Update with correct status
        });

        $('#QuerySent').click(function() {
          window.location.href = '?status=22'; // Update with correct status
        });
        $('#ClaimApprove').click(function() {
          window.location.href = '?status=23'; // Update with correct status
        });
        $('#ClaimShortSettled').click(function() {
          window.location.href = '?status=24'; // Update with correct status
        });
        $('#ClaimSettled').click(function() {
          window.location.href = '?status=25'; // Update with correct status
        });
        $('#ClaimRejected').click(function() {
          window.location.href = '?status=26'; // Update with correct status
        });
        $('#RejectAtAdmission').click(function() {
          window.location.href = '?status=27'; // Update with correct status
        });
        $('#RejectAtDischarge').click(function() {
          window.location.href = '?status=28'; // Update with correct status
        });
      });
    </script>
  </body>

  </html>
<?php } ?>