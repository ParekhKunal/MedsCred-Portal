<?php
session_start();
error_reporting(0);
include("include/config.php");
if (isset($_POST['submit'])) {
  $uname = $_POST['email'];
  $upassword = md5($_POST['password']);

  $ret = mysqli_query($con, "SELECT * FROM admin WHERE email='$uname' and password='$upassword'");
  $num = mysqli_fetch_array($ret);
  if ($num > 0) {
    $_SESSION['login'] = $_POST['email'];
    $_SESSION['id'] = $num['id'];
    header("location:dashboard.php");
  } else {
    $_SESSION['errmsg'] = "Invalid username or password";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MedsCred | Admin - Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="./index.html" class="h1">Admin | <b>MedsCred</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form class="form-login" method="post">
          <p>
            Please enter your name and password to log in.<br />
            <span style="color:red;"><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg'] = ""); ?></span>
          </p>
          <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control password" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block" name="submit">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>


        <p class="mb-1">
          <a href="forgot-password.html">I forgot my password</a>
        </p>


      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="./plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./dist/js/adminlte.min.js"></script>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="vendor/modernizr/modernizr.js"></script>
  <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
  <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="vendor/switchery/switchery.min.js"></script>
  <script src="vendor/jquery-validation/jquery.validate.min.js"></script>

  <script src="./dist/js/main.js"></script>
  <script src="./dist/js/login.js"></script>
  <script>
    jQuery(document).ready(function() {
      Main.init();
      Login.init();
    });
  </script>
</body>

</html>