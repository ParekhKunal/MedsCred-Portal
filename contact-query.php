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
    <title>MedsCred | Website Contact Query List</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="dist/fav.png">
    <style>
      .message-container {
        position: relative;
      }

      /* .message-truncated {
        display: block;
      } */

      .message-full {
        display: none;
      }

      .message-toggle {
        color: #007bff;
        /* Example color for the 'more' link */
        cursor: pointer;
        text-decoration: underline;
      }

      .message-toggle:hover {
        text-decoration: none;
      }
    </style>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.message-toggle').forEach(function(toggle) {
          toggle.addEventListener('click', function(event) {
            event.preventDefault();
            const container = this.closest('.message-container');
            const truncated = container.querySelector('.message-truncated');
            const fullMessage = container.querySelector('.message-full');

            if (fullMessage.style.display === 'none') {
              fullMessage.style.display = 'inline';
              truncated.style.display = 'none';
              this.textContent = 'less'; // Change text to 'less' when expanded
            } else {
              fullMessage.style.display = 'none';
              truncated.style.display = 'inline';
              this.textContent = 'more'; // Change text to 'more' when collapsed
            }
          });
        });
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
                <h1>Contact / Query List</h1>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <section class="content" style="margin-bottom: 20px;">
          <div class="row">
            <div class="col-md-12">
              <form method="get">
                <div class="input-group">
                  <input type="text" name="searchdata" class="form-control form-control-lg" placeholder="Type to find by Name/Email/Phone Number here">
                  <div class="input-group-append">
                    <button type="submit" name="search" class="btn btn-lg btn-default">
                      <i class="fa fa-search"></i>
                    </button>
                    <a href="contact-query.php" class="btn btn-lg btn-default">Reload</a>
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
                  <?php $sql = mysqli_query($con, "SELECT COUNT(*) AS total_contact FROM contact_us");
                  $row = mysqli_fetch_assoc($sql);

                  echo ($row['total_contact'])
                  ?> Contact / Queries</span>
              </div>
            </div>
            <div class="card-body p-0">
              <table class="table table-striped projects">
                <thead>
                  <tr>
                    <th style="width: 10%">
                      Sr No.
                    </th>
                    <th style="width: 20%">
                      Name
                    </th>
                    <th style="width: 20%">
                      Email
                    </th>
                    <th style="width: 20%">
                      Phone No.
                    </th>
                    <th style="width: 30%">
                      Message
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
                    $searchCondition = " AND (cu.first_name LIKE '%$search%' OR cu.last_name LIKE '%$search%' OR cu.email LIKE '%$search%' OR cu.phone_number LIKE '%$search%' )";
                  }

                  $sql = mysqli_query(
                    $con,
                    "SELECT 
                    cu.id,
                    cu.first_name,
                    cu.last_name,
                    cu.email,
                    cu.phone_number,
                    cu.message,
                    cu.created_at
                    FROM 
                        contact_us cu
                     $searchCondition"
                  );
                  $cnt = 1;
                  while ($row = mysqli_fetch_array($sql)) {
                  ?>
                    <tr>
                      <td>
                        <?php echo ($cnt) ?>
                      </td>
                      <td>
                        <a href="#">
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
                        <div class="message-container">
                          <span class="message-truncated"><?php echo implode(' ', array_slice(explode(' ', $row['message']), 0, 8)); ?>...</span>
                          <span class="message-full" style="display:none;"><?php echo htmlspecialchars($row['message']); ?></span>
                          <a href="#" class="message-toggle">more</a>
                        </div>
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
  </body>

  </html>
<?php } ?>