	<?php


	function newUser()
	{   
		include '../dbconfig/db.php';
		$name=$_POST['uname'];   
		$contact=$_POST['contact'];
		$email=$_POST['email'];    
		$password=$_POST['pwd'];
		$prepeat=$_POST['cpwd'];
			$sql = "INSERT INTO doctor (Name,Email,Contact,Password) 
			VALUES ('$name','$email','$contact','$password') ";

		if (mysqli_query($conn, $sql)) 
		{
		//	echo "<h2>Record created successfully!! Redirecting to login page....</h2>";
			header( "Refresh:3; url=doc-login.php");

		} 
		else
		{
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
	function checkusername()
	{
		include '../dbconfig/db.php';
		
		$email=$_POST['email'];
		$contact=$_POST['contact'];
		$sql= "SELECT * FROM doctor WHERE Email = '$email' and Contact='$contact'";
		

		$result=mysqli_query($conn,$sql);

			if(mysqli_num_rows($result)!=0)
			{
				echo"<b><br>User already exists!!";
			}
			else if($_POST['pwd']!=$_POST['cpwd'])
			{
				echo "Passwords dont match";
			}
			else if(isset($_POST['signup']))
			{ 
				newUser();
			}

		
	}
	if(isset($_POST['signup']))
	{
		if(!empty($_POST['uname']) && !empty($_POST['pwd']) &&!empty($_POST['cpwd']) &&!empty($_POST['email']) && !empty($_POST['contact']))
		
				checkusername();
	}
	?>
	<!DOCTYPE html> 
	<html lang="en">
		
	<!-- Docter/doctor-register.php  30 Nov 2019 04:12:15 GMT -->
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
		<body class="account-page">

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
				
				<!-- Page Content -->
				<div class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-8 offset-md-2">
							
								<!-- Account Content -->
								<div class="account-content">
									<div class="row align-items-center justify-content-center">
										<div class="col-md-7 col-lg-6 login-left">
											<img src="../assets/img/login-banner.png" class="img-fluid" alt="Login Banner">	
										</div>
										<div class="col-md-12 col-lg-6 login-right">
											<div class="login-header">
												<h3>Doctor Register <a href="../register.php">Not a Doctor?</a></h3>
											</div>
											
											<!-- Register Form -->
											<form action="doctor-register.php" method="post">
												<div class="form-group form-focus">
						<input type="text" class="form-control floating" name="uname">
						<label class="focus-label">Name</label>
					</div>
					<div class="form-group form-focus">
						<input type="text" class="form-control floating" name="email">
						<label class="focus-label">Email</label>
					</div>
					<div class="form-group form-focus">
						<input type="text" class="form-control floating" name="contact">
						<label class="focus-label">Mobile Number</label>
					</div>
					<div class="form-group form-focus">
						<input type="password" class="form-control floating" name="pwd">
						<label class="focus-label">Create Password</label>
					</div>
					<div class="form-group form-focus">
						<input type="password" class="form-control floating" name="cpwd">
						<label class="focus-label">Confirm Password</label>
					</div>
					<div class="text-right">
						<a class="forgot-link" href="doc-login.php">Already have an account?</a>
					</div>
					<!-- <input type="submit" value="submit"> -->
					<div class="text">
						<input class="btn btn-primary btn-block btn-lg login-btn" name='signup' type="submit"></a>
					</div>
												<div class="login-or">
													<span class="or-line"></span>
													<span class="span-or">or</span>
												</div>
												<div class="row form-row social-login">
													<div class="col-6">
														<a href="#" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f mr-1"></i> Login</a>
													</div>
													<div class="col-6">
														<a href="#" class="btn btn-google btn-block"><i class="fab fa-google mr-1"></i> Login</a>
													</div>
												</div>
											</form>
											<!-- /Register Form -->
											
										</div>
									</div>
								</div>
								<!-- /Account Content -->
									
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
								<div class="col-lg-3 col-md-6">
								
									<!-- Footer Widget -->
									<!-- <div class="footer-widget footer-about">
										<div class="footer-logo">
											<img src="assets/img/footer-logo.png" alt="logo">
										</div>
										<div class="footer-about-content">
											<div class="social-icon">
												<ul>
													<li>
														<a href="#" target="_blank"><i class="fab fa-facebook-f"></i> </a>
													</li>
													<li>
														<a href="#" target="_blank"><i class="fab fa-twitter"></i> </a>
													</li>
													<li>
														<a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
													</li>
													<li>
														<a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
													</li>
													<li>
														<a href="#" target="_blank"><i class="fab fa-dribbble"></i> </a>
													</li>
												</ul>
											</div>
										</div>
									</div> -->
									<!-- /Footer Widget -->
									
								</div>
								
								
									<!-- /Footer Widget -->
									
								</div>
								
							</div>
						</div>
					</div>
					<!-- /Footer Top -->
					
					<!-- Footer Bottom -->
					<div class="footer-bottom">
						<div class="container-fluid">
						
							<!-- Copyright -->
							<div class="copyright">
								<div class="row">
									<div class="col-md-6 col-lg-6">
										<div class="copyright-text">
											<p class="mb-0"><a href="templateshub.net"></a></p>
										</div>
									</div>
									<div class="col-md-6 col-lg-6">
									
										<!-- Copyright Menu -->
										<div class="copyright-menu">
											<ul class="policy-menu">
												<li><a href="term-condition.php">Terms and Conditions</a></li>
												<li><a href="privacy-policy.php">Policy</a></li>
											</ul>
										</div>
										<!-- /Copyright Menu -->
										
									</div>
								</div>
							</div>
							<!-- /Copyright -->
							
						</div>
					</div>
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
			
			<!-- Custom JS -->
			<script src="assets/js/script.js"></script>
			
		</body>

	<!-- Docter/doctor-register.php  30 Nov 2019 04:12:16 GMT -->
	</html>