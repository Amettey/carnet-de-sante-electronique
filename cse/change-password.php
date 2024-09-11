<?php 
	session_start();
	$email=$_SESSION['email'];
	$user=$_SESSION['user'];
	
	include "dbconfig/db.php";
	$query = mysqli_query($conn,"select * from patient where Email='$email'");
	$rows = mysqli_fetch_assoc($query);
	$num=mysqli_num_rows($query);
	if ($num == 1) {
		$uname=$rows['Name'];
		$contact=$rows['Contact'];	
		$lname=$rows['lname'];
		$dob=$rows['dob'];
		$oldpwd=$rows['Password'];
		$bg=$rows['bgroup'];
		$contact=$rows['Contact'];
		$address=$rows['address'];
		$city=$rows['city'];
		$state=$rows['state'];
		$country=$rows['country'];
		$height=$rows['height'];
		$weight=$rows['weight'];

	}
		if (isset($_POST['login'])){
		$opwd=$_POST['opwd'];
		$newpwd=$_POST['newpwd'];
	
	$cnewpwd=$_POST['cnewpwd'];
	if($newpwd==$cnewpwd){
//	if(1){
		if($oldpwd==$opwd){
			$sql = "UPDATE patient SET Password='".$newpwd."'WHERE Email='$email'";
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
   
        
	
?><!DOCTYPE html> 
<html lang="en">
	
<!-- Docter/change-password.php  30 Nov 2019 04:12:18 GMT -->
<head>
		<meta charset="utf-8">
		<title>Doctor</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		
		<!-- Favicons -->
		<link href="assets/img/favicon.png" rel="icon">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="assets/css/style.css">
		
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
							<img src="assets/img/logo.png" class="img-fluid" alt="Logo" style="width: 100px; height: auto;">
						</a>
					</div>
					<div>
						<span>
							<div class="translate" id="google_translate_element"></div>

							<script type="text/javascript">
								function googleTranslateElementInit() {  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');}
							</script>
							<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
						</span>
					</div>		 
					<ul class="nav header-navbar-rht">
						<li class="nav-item contact-item">
							<div class="header-contact-img">
								<i class="far fa-hospital"></i>							
							</div>
							<div class="header-contact-detail">
								<p class="contact-header">Contact</p>
								<p class="contact-info-header"><?php echo $contact;?></p>
							</div>
						</li>
						
						<!-- User Menu -->
						<li class="nav-item dropdown has-arrow logged-item">
							<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
								<span class="user-img">
									<?php 
										$image = isset($rows['Image']) ? $rows['Image'] : ''; // Assurez-vous que $rows['Image'] n'est pas null
										$encodedImage = base64_encode($image);
											echo '<img class="rounded-circle" src="data:image/jpeg;base64,' . $encodedImage . '" class="img-thumbnail" alt="' . htmlspecialchars($user) . '"/>';
									?>
								</span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<div class="user-header">
									<div class="avatar avatar-sm">
										<?php 
											$image = isset($rows['Image']) ? $rows['Image'] : ''; // Assurez-vous que $rows['Image'] n'est pas null
											$encodedImage = base64_encode($image);
												echo '<img class="rounded-circle" src="data:image/jpeg;base64,' . $encodedImage . '" class="img-thumbnail" alt="' . htmlspecialchars($user) . '"/>';
										?>
									</div>
									<div class="user-text">
										<h6><?php echo $name;?></h6>
										<p class="text-muted mb-0">Patient</p>
									</div>
								</div>
								<a class="dropdown-item" href="patient-dashboard.php">Dashboard</a>
								<a class="dropdown-item" href="profile-settings.php">Profile Settings</a>
								
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
									<li class="breadcrumb-item"><a href="search.php">Home</a></li>
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
						<!-- Profile Sidebar -->
					
							<div class="profile-sidebar">
								<div class="widget-profile pro-widget-content">
									<div class="profile-info-widget">
										<a href="#" class="booking-doc-img">
											<?php 
												$image = isset($rows['Image']) ? $rows['Image'] : ''; // Assurez-vous que $rows['Image'] n'est pas null
												$encodedImage = base64_encode($image);
													echo '<img class="rounded-circle" src="data:image/jpeg;base64,' . $encodedImage . '" class="img-thumbnail" alt="' . htmlspecialchars($user) . '"/>';
											?>
										</a>
										<div class="profile-det-info">
											<h3><?php echo $uname;?></h3>
											<div class="patient-details">
												<h5><i class="fas fa-ruler"></i><?php echo $height;?> cm</h5>
												<h5><i class="fas fa-weight"></i><?php echo $weight;?> kg</h5>
												<h5><i class="fas fa-birthday-cake"></i><?php echo $dob;?></h5>
												<h5 class="mb-0"><i class="fas fa-map-marker-alt"></i><?php echo $address;?>, <?php echo $city;?>, <?php echo $country;?></h5>
											</div>
										</div>
									</div>
								</div>
								<div class="dashboard-widget">
									<nav class="dashboard-menu">
										<ul>
											<li>
													<a href="patient-dashboard.php">
													<i class="fas fa-columns"></i>
													<span>Dashboard</span>
												</a>
											</li>
											<li>
												<a href="search.php">
													<i class="fas fa-bookmark"></i>
													<span>Book Appointment</span>
												</a>
											</li>
											
											<li>
												<a href="profile-settings.php">
													<i class="fas fa-user-cog"></i>
													<span>Profile Settings</span>
												</a>
											</li>
											<li  class="active">
												<a href="change-password.php">
													<i class="fas fa-lock"></i>
													<span>Change Password</span>
												</a>
											</li>
											<li>
												<a href="../index.html">
													<i class="fas fa-sign-out-alt"></i>
													<span>Logout</span>
												</a>
											</li>
										</ul>
									</nav>
								</div>

							</div>
					
						<!-- /Profile Sidebar -->
							<!-- /Profile Sidebar -->
							
						</div>
						
						<div class="col-md-7 col-lg-8 col-xl-9">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col-md-12 col-lg-6">
										
											<!-- Change Password Form -->
											<form method="post" action="change-password.php">
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
					
				</div>
				<!-- /Footer Top -->
				
				<!-- Footer Bottom -->
                
				<!-- /Footer Bottom -->
				
			</footer>
			<!-- /Footer -->
		   
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
	</body>

<!-- Docter/change-password.php  30 Nov 2019 04:12:18 GMT -->
</html>