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
    <title>MedsCred | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    <link rel="shortcut icon" type="image/x-icon" href="dist/fav.png">
  </head>

  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

      <!-- Preloader -->
      <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="dist/img/logo.png" alt="MedsCred" width="260">
      </div>

      <?php include('include/navbar.php'); ?>

      <?php include('include/sidebar.php'); ?>


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS total_hospitals FROM hospitals WHERE is_active = 1");
                        $row = mysqli_fetch_assoc($sql);

                        echo ($row['total_hospitals'])
                        ?></h3>
                    <p>Manage Hospitals</p>
                  </div>
                  <a href="hospitals.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <!-- <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS total_doctors FROM doctors WHERE is_active = 1");
                        $row = mysqli_fetch_assoc($sql);

                        echo ($row['total_doctors'])
                        ?></h3>
                    </h3>
                    <p>Manage Doctors</p>
                  </div>
                  <a href="doctors.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div> -->

              <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS total_reimburse FROM patient_cases_info WHERE loan_type = 1");
                        $row = mysqli_fetch_assoc($sql);

                        echo ($row['total_reimburse'])
                        ?></h3>
                    </h3>
                    <p>Manage Reimburse Patient</p>
                  </div>
                  <a href="reimbursement.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS total_cashless FROM patient_cases_info WHERE loan_type = 2");
                        $row = mysqli_fetch_assoc($sql);

                        echo ($row['total_cashless'])
                        ?></h3>
                    </h3>
                    <p>Manage Cashless Patient</p>
                  </div>
                  <a href="cashless.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?php $sql = mysqli_query($con, "SELECT COUNT(*) AS total_asthetic FROM patient_cases_info WHERE loan_type = 3");
                        $row = mysqli_fetch_assoc($sql);

                        echo ($row['total_asthetic'])
                        ?></h3>
                    </h3>
                    <p>Manage Asthetic Patient</p>
                  </div>
                  <a href="asthetic.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>


            </div>
            <div class="row">
              <section class="col-lg-5 connectedSortable">
                <div class="card bg-gradient-primary d-none">
                  <div class="card-header border-0">
                    <h3 class="card-title">
                      <i class="fas fa-map-marker-alt mr-1"></i>
                      Visitors
                    </h3>
                    <!-- card tools -->
                    <div class="card-tools">
                      <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                        <i class="far fa-calendar-alt"></i>
                      </button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                
                  <!-- /.card-body-->
                  <div class="card-footer bg-transparent">
                    <div class="row">
                      <div class="col-4 text-center">
                        <div id="sparkline-1"></div>
                        <div class="text-white">Visitors</div>
                      </div>
                      <!-- ./col -->
                      <div class="col-4 text-center">
                        <div id="sparkline-2"></div>
                        <div class="text-white">Online</div>
                      </div>
                      <!-- ./col -->
                      <div class="col-4 text-center">
                        <div id="sparkline-3"></div>
                        <div class="text-white">Sales</div>
                      </div>
                      <!-- ./col -->
                    </div>
                    <!-- /.row -->
                  </div>
                </div>
                <div class="card bg-gradient-success">
                  <div class="card-header border-0">

                    <h3 class="card-title">
                      <i class="far fa-calendar-alt"></i>
                      Calendar
                    </h3>
                    <!-- tools card -->
                    <div class="card-tools">
                      <!-- button with a dropdown -->
                      <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                          <i class="fas fa-bars"></i>
                        </button>
                        <div class="dropdown-menu" role="menu">
                          <a href="#" class="dropdown-item">Add new event</a>
                          <a href="#" class="dropdown-item">Clear events</a>
                          <div class="dropdown-divider"></div>
                          <a href="#" class="dropdown-item">View calendar</a>
                        </div>
                      </div>
                      <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                    <!-- /. tools -->
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body pt-0">
                    <!--The calendar -->
                    <div id="calendar" style="width: 100%"></div>
                  </div>
                  <!-- /.card-body -->
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
      <?php include('include/footer.php'); ?>

      <aside class="control-sidebar control-sidebar-dark">
      </aside>
    </div>


    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="plugins/sparklines/sparkline.js"></script>
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="dist/js/adminlte.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard.js"></script>
  </body>

  </html>
<?php } ?>