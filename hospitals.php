<?php
session_start();
error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
  header('location:logout.php');
} else {

  // if (isset($_POST['delete-hospital-details'])) {
  //   $sql = mysqli_query($con, "UPDATE `hospitals` SET `is_active`='0',`updated_at`='$currentTime' WHERE id = '$did'");
  //   if ($sql) {
  //     echo "<script>alert('Hospital Details Deleted Successfully');</script>";
  //     echo "<script>window.location.href =`hospitals.php`</script>";
  //   }
  // }

?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedsCred | Hospital List</title>

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
                <h1>Hospital List</h1>
              </div>

              <div class="col-sm-6 " style="display: flex;justify-content:end">
                <a href="add-hospital.php" class="btn btn-primary">Add Hospitals</a>
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
                  </div>
                </div>
              </form>
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
                  <?php $sql = mysqli_query($con, "SELECT COUNT(*) AS total_hospitals FROM hospitals WHERE is_active = 1");
                  $row = mysqli_fetch_assoc($sql);

                  echo ($row['total_hospitals'])
                  ?> Hospitals</span>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table table-striped projects">
                <thead>
                  <tr>
                    <th style="width: 10%">
                      Sr No.
                    </th>
                    <th style="width: 25%">
                      Name
                    </th>
                    <th style="width: 25%">
                      Email
                    </th>
                    <th>
                      Phone No.
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
                  // Initialize search condition
                  $searchCondition = "";

                  // Check if search form is submitted
                  if (isset($_GET['search'])) {
                    $search = $_GET['searchdata'];
                    // Add search condition to SQL query
                    $searchCondition = " AND (h.name LIKE '%$search%' OR h.email LIKE '%$search%' OR h.phone_number LIKE '%$search%' )";
                  }

                  $sql = mysqli_query($con, "SELECT * FROM `hospitals` h WHERE is_active = 1 $searchCondition");
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($sql)) {
                  ?>
                    <tr>
                      <td>
                        <?php echo ($cnt) ?>
                      </td>
                      <td>
                        <a href="edit-hospital.php?id=<?php echo $row['id']; ?>">
                          <?php echo $row['name'] ?>
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
                      <td class="project-state">
                        <?php
                        if ($row['verified_by']) {
                          echo '<span class="badge badge-success">Verified</span>';
                        } else {
                          echo '<span class="badge badge-danger">Unverified</span>';
                        }
                        ?>
                      </td>
                      <td class="project-actions text-right">

                        <a class="btn btn-info btn-sm" href="edit-hospital.php?id=<?php echo $row['id']; ?>">
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
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="./dist/js/demo.js"></script>
  </body>

  </html>
<?php } ?>