<?php 
session_start();
$email=$_SESSION['email'];
$name=$_SESSION['user'];
include "../dbconfig/db.php";
$query = mysqli_query($conn,"select * from doctor where Email='$email'");
$rows = mysqli_fetch_assoc($query);
//$num=mysqli_num_rows($query);
if (mysqli_num_rows($query)) {
	
	$contact=$rows['Contact'];	
	$special=$rows['Special'];
	$oldpwd=$rows['Password'];
	$dp=$rows['Image'];
		
} 
	if (isset($_POST['login'])){
		$opwd=$_POST['opwd'];
		$newpwd=$_POST['newpwd'];
	
	$cnewpwd=$_POST['cnewpwd'];
	if($newpwd==$cnewpwd){
//	if(1){
		if($oldpwd==$opwd){
			$sql = "UPDATE doctor SET Password='".$newpwd."'WHERE Email='$email'";
			if (mysqli_query($conn,$sql)){
                echo "New Password Updated";
                }
			else
			{
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}else{
			echo 'Your current password in incorrect';
		}
	}else{
		echo 'Confirm password does not match';
	}
}
?>
<!DOCTYPE html> 
<html lang="en">
	
<!-- Docter/doctor-change-password.php  30 Nov 2019 04:12:36 GMT -->
<head>
		<meta charset="utf-8">
		<title>Doctor</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		 <script src="../assets/js/removebanner.js"></script>
		<!-- Favicons -->
		<link href="../assets/img/favicon.png" rel="icon">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="../assets/css/style.css">
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	
	</head>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			<!-- Header -->
			<header class="header">
				<nav class="navbar navbar-expand-lg header-nav">
					<div class="navbar-header">
						<a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</a>
						<a href="doctor-dashboard.php" class="navbar-brand logo">
							<img src="../assets/img/logo.png" class="img-fluid" alt="Logo" style="width: 100px; height: auto;">
						</a>
					</div>
					<div>
						<span>
							<div class="translate" id="google_translate_element"></div>
							<script type="text/javascript">
								function googleTranslateElementInit() {  
									new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
								}
							</script>
							<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
						</span>
					</div>

					<div class="main-menu-wrapper">
						<div class="menu-header">
							<a href="doctor-dashboard.php" class="menu-logo">
								<img src="../assets/img/logo.png" class="img-fluid" alt="Logo">
							</a>
							<a id="menu_close" class="menu-close" href="javascript:void(0);">
								<i class="fas fa-times"></i>
							</a>
						</div>	 
					</div>		 
					<ul class="nav header-navbar-rht">
						
						
						<!-- User Menu -->
						<li class="nav-item dropdown has-arrow logged-item">
							<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<span class="user-img">
								<?php echo '<img class="rounded-circle" src="data:image/jpeg;base64,'.base64_encode($dp).'"   alt='.$name.'/>  ';?>
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="user-header">
									<div class="avatar avatar-sm">
										<?php echo '<img class="avatar-img rounded-circle" src="data:image/jpeg;base64,'.base64_encode($dp).'"   alt='.$name.'/>  ';?>
									</div>
									<div class="user-text">
										<h6><?php echo $name;?></h6>
										<p class="text-muted mb-0">Doctor</p>
									</div>
								</div>
								<a class="dropdown-item" href="doctor-dashboard.php">Dashboard</a>
								<a class="dropdown-item" href="doctor-profile-settings.php">Profile Settings</a>
								
							</div>
						</li>
						<!-- /User Menu -->
						
					</ul>
				</nav>
			</header>
			<!-- /Header -->
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="doctor-dashboard.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Change Password</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Change Password</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
						
							<!-- Profile Sidebar -->
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
											<?php echo '<img class="rounded-circle" src="data:image/jpeg;base64,'.base64_encode($dp).'"  alt='.$name.'/>  ';?>
										</a>
										<div class="profile-det-info">
											<h3><?php echo $name;?></h3>
											
											<div class="patient-details">
												<h5 class="mb-0"><?php echo $special;?></h5>
											</div>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li>
												<a href="doctor-dashboard.php">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li>
												<a href="appointments.php">
													<i class="fas fa-calendar-check"></i>
													<span>Appointments</span>
												</a>
											</li>
											<li>
												<a href="my-patients.php">
													<i class="fas fa-user-injured"></i>
													<span>My Patients</span>
												</a>
											</li>
											
											
											<li>
												<a href="doctor-profile-settings.php">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											
											<li class="active">
												<a href="doctor-change-password.php">
													<i class="fas fa-lock"></i>
													<span>Change Password</span>
												</a>
											</li>
											<li>
												<a href="../logout.html">
													<i class="fas fa-sign-out-alt"></i>
													<span>Logout</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>
							</div>
							<!-- /Profile Sidebar -->
							
						</div>
						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-12 col-lg-6">
										
											<!-- Change Password Form -->
											<form method="post" action="doctor-change-password.php">
												<div class="form-group">
													<label>Old Password</label>
													<input type="password" class="form-control" name="opwd">
												</div>
												<div class="form-group">
													<label>New Password</label>
													<input type="password" class="form-control" name="newpwd">
												</div>
												<div class="form-group">
													<label>Confirm Password</label>
													<input type="password" class="form-control" name="cnewpwd">
												</div>
												<div class="submit-section">
													<button type="submit" class="btn btn-primary submit-btn" name="login">Save Changes</button>
												</div>
											</form>
											<!-- /Change Password Form -->
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>		
			<!-- /Page Content -->
   
			<!-- Footer -->
			<footer class="footer">
				
				<!-- Footer Top -->
				<div class="footer-top">
					<div class="container-fluid">
						<div class="row">
						
							
							
								<!-- /Footer Widget -->
								
							</div>
							
						</div>
					</div>
				</div>
				<!-- /Footer Top -->
				
				<!-- Footer Bottom -->
                
				<!-- /Footer Bottom -->
				
			</footer>
			<!-- /Footer -->
		   
		</div>
		<!-- /Main Wrapper -->
	  	  <script src="../assets/js/removebanner.js"></script>
		<!-- jQuery -->
		<script src="../assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="../assets/js/popper.min.js"></script>
		<script src="../assets/js/bootstrap.min.js"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="../assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="../assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Custom JS -->
		<script src="../assets/js/script.js"></script>
		
	</body>

<!-- Docter/doctor-change-password.php  30 Nov 2019 04:12:36 GMT -->
</html>