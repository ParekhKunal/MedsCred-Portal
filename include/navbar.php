 <?php error_reporting(0); ?>
 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         <!-- Navbar Search -->

         <!-- Messages Dropdown Menu -->
         <?php include('messages.php'); ?>

         <li class="nav-item">

             <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                 <i class="fas fa-expand-arrows-alt"></i>
             </a>
         </li>
         <li class="nav-item dropdown">
             <a class="nav-link" data-toggle="dropdown" href="#">
                 <i class="far fa-user"></i>
             </a>
             <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                 <a class="nav-link" role="button" href="profile.php">My Profile</a>
                 <a class="nav-link" role="button" href="change-passwords.php">Change Password</a>
                 <a class="nav-link" role="button" href="logout.php">Log Out</a>
             </div>
         </li>
     </ul>
 </nav>
 <!-- /.navbar -->