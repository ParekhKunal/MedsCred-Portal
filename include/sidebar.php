 <?php
	session_start();
	//error_reporting(0);
	include('include/config.php');
	if (strlen($_SESSION['id'] == 0)) {
		header('location:logout.php');
	} else {
		$uname = $_SESSION['login'];
		$sql = mysqli_query($con, "SELECT first_name,last_name FROM admin where email='$uname'");
		$num = mysqli_fetch_assoc($sql);

		$firstName = $num['first_name'];
		$lastName = $num['last_name'];
	?>

 	<aside class="main-sidebar sidebar-primary elevation-4">
 		<!-- Brand Logo -->
 		<div style="width: 100%;display:flex;justify-content:center;margin-top:10px;margin-bottom:20px;">
 			<img src="dist/img/logo.png" alt="MedsCred" class="brand-image" width="150px">
 		</div>


 		<!-- Sidebar -->
 		<div class="sidebar">
 			<!-- Sidebar user panel (optional) -->
 			<div class="user-panel mt-3 pb-3 mb-3 d-flex">
 				<div class="image">
 					<img src="dist/img/user4-128x128.jpg" class="img-circle elevation-2" alt="User Image">
 				</div>
 				<div class="info">
 					<a href="profile.php" class="d-block"><?php echo ($firstName) ?> <?php echo ($lastName) ?></a>
 				</div>
 			</div>


 			<!-- Sidebar Menu -->
 			<nav class="mt-2">
 				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
 					<li class="nav-item ">
 						<a href="dashboard.php" class="nav-link">
 							<i class="nav-icon fas fa-home"></i>
 							<p>
 								Dashboard
 							</p>
 						</a>
 					</li>
 					<!-- hospital -->
 					<li class="nav-item">
 						<a href="hospitals.php" class="nav-link">
 							<i class="nav-icon fas fa-hospital"></i>
 							<p>
 								Hospitals
 								<i class="fas fa-angle-left right"></i>
 							</p>
 						</a>
 						<ul class="nav nav-treeview">
 							<li class="nav-item">
 								<a href="add-hospital.php" class="nav-link">
 									<i class="far fa-circle nav-icon"></i>
 									<p>Add Hospital</p>
 								</a>
 							</li>
 							<li class="nav-item">
 								<a href="hospitals.php" class="nav-link">
 									<i class="far fa-circle nav-icon"></i>
 									<p>Manage Hospital</p>
 								</a>
 							</li>
 						</ul>
 					</li>

 					<!-- Doctors -->
 					<li class="nav-item">
 						<a href="doctors.php" class="nav-link">
 							<i class="nav-icon fas fa-users"></i>
 							<p>
 								Doctors
 								<i class="fas fa-angle-left right"></i>
 							</p>
 						</a>
 						<ul class="nav nav-treeview">
 							<li class="nav-item">
 								<a href="add-doctor.php" class="nav-link">
 									<i class="far fa-circle nav-icon"></i>
 									<p>Add Doctor</p>
 								</a>
 							</li>
 							<li class="nav-item">
 								<a href="doctors.php" class="nav-link">
 									<i class="far fa-circle nav-icon"></i>
 									<p>Manage Doctor</p>
 								</a>
 							</li>
 						</ul>
 					</li>

 					<!-- patients -->
 					<li class="nav-item">
 						<a href="patients.php" class="nav-link">
 							<i class="nav-icon fas fa-user"></i>
 							<p>
 								Patients
 								<i class="fas fa-angle-left right"></i>
 							</p>
 						</a>
 						<ul class="nav nav-treeview">
 							<li class="nav-item">
 								<a href="add-patient.php" class="nav-link">
 									<i class="far fa-circle nav-icon"></i>
 									<p>Add Patients</p>
 								</a>
 							</li>
 							<li class="nav-item">
 								<a href="patients.php" class="nav-link">
 									<i class="far fa-circle nav-icon"></i>
 									<p>Manage Patients</p>
 								</a>
 							</li>
 						</ul>
 					</li>

 					<li class="nav-item">
 						<a href="all-case.php" class="nav-link">
 							<i class="nav-icon fas fa-edit"></i>
 							<p>
 								All Case
 							</p>
 						</a>
 					</li>
 					<li class="nav-item">
 						<a href="reimbursement.php" class="nav-link">
 							<i class="nav-icon fas fa-edit"></i>
 							<p>
 								Reimbursement Case
 							</p>
 						</a>
 					</li>
 					<li class="nav-item">
 						<a href="cashless.php" class="nav-link">
 							<i class="nav-icon fas fa-edit"></i>
 							<p>
 								Cashless Case
 							</p>
 						</a>
 					</li>

 					<li class="nav-item">
 						<a href="asthetic.php" class="nav-link">
 							<i class="nav-icon fas fa-edit"></i>
 							<p>
 								Asthetic Case
 							</p>
 						</a>
 					</li>
 					<li class="nav-item">
 						<a href="contact-query.php" class="nav-link">
 							<i class="nav-icon fas fa-edit"></i>
 							<p>
 								Website Contact / Queries
 							</p>
 						</a>
 					</li>



 				</ul>
 			</nav>
 			<!-- /.sidebar-menu -->
 		</div>
 		<!-- /.sidebar -->
 	</aside>
 <?php } ?>