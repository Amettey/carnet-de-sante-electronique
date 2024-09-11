<?php
include "dbconfig/db.php";
if(isset($_GET['dmail'])){
	$dmail=$_GET['dmail'];
	$dmail = str_replace("'", "", $dmail);
	$query = mysqli_query($conn,"select * from doctor where Email='$dmail'");
	$rows = mysqli_fetch_assoc($query);
	$num=mysqli_num_rows($query);
	if ($num == 1) {
		$name=$rows['Name'];
		$contact=$rows['Contact'];
		$country=$rows['Country'];
		$specialist=$rows['Special'];
		$dp=$rows['Image'];
	} 
}

session_start();
$email=$_SESSION['email'];





?>
<!DOCTYPE html> 
<html lang="en">
	
<head>

		<meta charset="utf-8">
		<title>Patient</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		
		<!-- Favicons -->
		<link href="assets/img/favicon.png" rel="icon">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

		
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
			<!-- Main CSS -->
		<link rel="stylesheet" href="assets/css/style.css">
		
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="/resources/demos/style.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script>
		$( function() {
			$( "#datepicker1" ).datepicker();
		} );
		</script>
	
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
								function googleTranslateElementInit() {  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');}
							</script>
							<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
						</span>
					</div>
					
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
									<li class="breadcrumb-item"><a href="patient-dashboard.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Booking</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Booking</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container">
				
					<div class="row">
						<div class="col-12">
						
							<div class="card">
								<div class="card-body">
									<div class="booking-doc-info">
										<a href="doctor-profile.html" class="booking-doc-img">
											<?php echo '<img class="rounded-circle" src="data:image/jpeg;base64,'.base64_encode($dp).'"  alt='.$name.'/>  ';?>
										</a>
										<div class="booking-info">
											<h4><a href="doctor-profile.html"><?php echo $name;?></a></h4>
											<p class="doc-speciality"><?php echo $specialist;?></p>
											<p class="text-muted mb-0"><i class="fas fa-map-marker-alt"></i> ,<?php echo $country;?></p>
										</div>
									</div>
								</div>
							</div>
							<form method="post" action="book.php">
							<!-- Schedule Widget -->
							<div class="card booking-schedule schedule-widget">
									<h6>Select Date for Appointment</h6>
									<div class="cal-icon">
						<input type="text" class="form-control datetimepicker"  name="doa">
													</div>
													<br>
													Select Time
						<input type="time" class= "form-control timepicker" name="time" placeholder="time">
								
							</div>
							
							<!-- /Schedule Widget -->
							
							<!-- Submit Section -->
							<div class="submit-section proceed-btn text-right">
								<input class="btn btn-primary submit-btn" type="submit" name="login" value="Book Now">
							</div>
					<input type="hidden" value="<?php echo $dmail;?>" name="dmail">
					<input type="hidden" value="<?php echo $country;?>" name="country">
					<input type="hidden" value="<?php echo $contact;?>" name="contact">
					<input type="hidden" value="<?php echo $name;?>" name="name">

	</form>
							<!-- /Submit Section -->
							
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
						
					
				<!-- /Footer Bottom -->
				
			</footer>
			<!-- /Footer -->
		   
		</div>
		<!-- /Main Wrapper -->
	  <script src="assets/js/removebanner.js"></script>
		<script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js"></script>
		
		<!-- Datetimepicker JS -->
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		
		<!-- Sticky Sidebar JS -->
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
	</body>

</html>