<?php
session_start();
//error_reporting(0);
include('include/config.php');
if (strlen($_SESSION['id'] == 0)) {
  header('location:logout.php');
} else {

  date_default_timezone_set('Asia/Kolkata'); // change according timezone
  $currentTime = date('d-m-Y h:i:s A', time());
  if (isset($_POST['submit'])) {
    $cpass = md5($_POST['cpass']);
    $uname = $_SESSION['login'];
    $sql = mysqli_query($con, "SELECT password FROM admin where password='$cpass' && email='$uname'");
    $num = mysqli_fetch_array($sql);
    if ($num > 0) {
      $npass = md5($_POST['npass']);
      $con = mysqli_query($con, "update admin set password='$npass', updated_at='$currentTime' where email='$uname'");
      $_SESSION['msg1'] = "Password Changed Successfully !!";
      header('location:index.php');
    } else {
      $_SESSION['msg1'] = "Old Password not match !!";
    }
  }
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedsCred | Admin - Forgot Password</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">

    <script type="text/javascript">
      function valid() {
        if (document.chngpwd.cpass.value == "") {
          alert("Current Password Filed is Empty !!");
          document.chngpwd.cpass.focus();
          return false;
        } else if (document.chngpwd.npass.value == "") {
          alert("New Password Filed is Empty !!");
          document.chngpwd.npass.focus();
          return false;
        } else if (document.chngpwd.cfpass.value == "") {
          alert("Confirm Password Filed is Empty !!");
          document.chngpwd.cfpass.focus();
          return false;
        } else if (document.chngpwd.npass.value != document.chngpwd.cfpass.value) {
          alert("Password and Confirm Password Field do not match  !!");
          document.chngpwd.cfpass.focus();
          return false;
        }
        return true;
      }
    </script>

  </head>

  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="./dashboard.php" class="h1"><b>MedsCred</b></a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
          <p style="color:red;"><?php echo htmlentities($_SESSION['msg1']); ?>
            <?php echo htmlentities($_SESSION['msg1'] = ""); ?></p>
          <form role="form" name="chngpwd" method="post" onSubmit="return valid();">
            <div class="input-group mb-3">
              <input type="password" name="cpass" class="form-control" placeholder="Enter Current Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="npass" class="form-control" placeholder="New Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="cfpass" class="form-control" placeholder="Confirm Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button type="submit" name="submit" class="btn btn-primary btn-block">Change Password</button>
              </div>
              <!-- /.col -->
            </div>
          </form>
          <p class="mt-3 mb-1">
            <a href="logout.php">Login</a>
          </p>
        </div>
        <!-- /.login-card-body -->
      </div>
    </div>
    <!-- /.login-box -->

    <!-- start: MAIN JAVASCRIPTS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="vendor/autosize/autosize.min.js"></script>
    <script src="vendor/selectFx/classie.js"></script>
    <script src="vendor/selectFx/selectFx.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="assets/js/main.js"></script>

    <!-- jQuery -->
    <script src="./plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./dist/js/adminlte.min.js"></script>

    <script>
      jQuery(document).ready(function() {
        Main.init();
        FormElements.init();
      });
    </script>
  </body>

  </html>
<?php } ?>