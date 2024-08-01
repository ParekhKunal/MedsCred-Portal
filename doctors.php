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
    <title>MedsCred | Doctor List</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="dist/fav.png">
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
                <h1>Doctor List</h1>
              </div>

              <div class="col-sm-6 " style="display: flex;justify-content:end">
                <a href="add-doctor.php" class="btn btn-primary">Add Doctor</a>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <section class="content" style="margin-bottom: 20px;">
          <div class="row">
            <div class="col-md-12">
              <form method="get">
                <div class="input-group">
                  <input type="text" name="searchdata" class="form-control form-control-lg" placeholder="Type to find doctor by First Name/Last Name/Email/Phone Number Or Hospital Name here">
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
                  <?php $sql = mysqli_query($con, "SELECT COUNT(*) AS total_doctors FROM doctors WHERE is_active = 1");
                  $row = mysqli_fetch_assoc($sql);

                  echo ($row['total_doctors'])
                  ?> Patients</span>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table table-striped projects">
                <thead>
                  <tr>
                    <th style="width: 10%">
                      Sr No.
                    </th>
                    <th style="width: 15%">
                      Name
                    </th>
                    <th style="width: 15%">
                      Hospital Name
                    </th>
                    <th style="width: 20%">
                      Email
                    </th>
                    <th style="width: 20%">
                      Phone No.
                    </th>
                    <th style="width: 10%">
                      Gender
                    </th>
                    <th style="width: 10%">
                      Experience
                    </th>
                    <th style="width: 10%">
                      qualification
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
                    $searchCondition = " AND (d.first_name LIKE '%$search%' OR d.last_name LIKE '%$search%' OR d.email LIKE '%$search%' OR d.phone_number LIKE '%$search%' OR h.name LIKE '%$search%')";
                  }

                  $sql = mysqli_query($con, "SELECT d.id,d.hospital_id,d.first_name,d.last_name,d.email,d.phone_number,d.gender,d.qualification,d.experience,d.created_at,h.name FROM `doctors` d JOIN hospitals h ON d.hospital_id = h.id WHERE d.is_active = 1 $searchCondition");
                  $cnt = 1;


                  while ($row = mysqli_fetch_array($sql)) {
                  ?>
                    <tr>
                      <td>
                        <?php echo ($cnt) ?>
                      </td>
                      <td>
                        <a href="edit-doctor.php?id=<?php echo $row['id']; ?>">
                          <?php echo substr($row['first_name'] . ' ' . $row['last_name'], 0, 20); ?>
                        </a>
                        <br />
                        <small>
                          Created <?php echo $row['created_at'] ?>
                        </small>
                      </td>
                      <td>
                        <a href="edit-hospital.php?id=<?php echo $row['hospital_id']; ?>" style="color:#000"><?php echo $row['name'] ?></a>
                      </td>
                      <td>
                        <a href="" style="color:#000"><?php echo $row['email'] ?></a>
                      </td>

                      <td>
                        <a href="" style="color:#000"><?php echo $row['phone_number'] ?></a>
                      </td>
                      <td>
                        <a href="" style="color:#000"><?php echo $row['gender'] ?></a>
                      </td>
                      <td>
                        <a href="" style="color:#000"><?php echo $row['qualification'] ?></a>
                      </td>
                      <td>
                        <a href="" style="color:#000"><?php echo $row['experience'] ?></a>
                      </td>

                      <td class="project-actions text-right">

                        <a class="btn btn-info btn-sm" href="edit-doctor.php?id=<?php echo $row['id']; ?>">
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