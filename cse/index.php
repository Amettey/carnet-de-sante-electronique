<?php
session_start();
$error='';

if (isset($_POST['login'])) {
    if (empty($_POST['email']) || empty($_POST['pwd'])) {
        $error = "Username or Password is invalid";
    } else {
        include 'dbconfig/db.php';
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['pwd']);

        // Vérification des informations de connexion
        $query = mysqli_query($conn, "SELECT * FROM patient WHERE Password='$password' AND email='$email'");
        $rows = mysqli_fetch_assoc($query);
        $num = mysqli_num_rows($query);

        if ($num == 1) {
            $_SESSION['email'] = $rows['Email'];
            $_SESSION['user'] = $rows['Name'];

            if ($rows['profile_setup'] == 0) {
                // Si le profil n'est pas encore configuré, redirection vers la page de configuration
                header("Location: profile-settings.php");
                exit(); // Assurez-vous que le script s'arrête après la redirection
            } else {
                // Si le profil est déjà configuré, redirection vers le tableau de bord
                header("Location: patient-dashboard.php");
                exit(); // Assurez-vous que le script s'arrête après la redirection
            }
        } else {
            $error = "Username or Password is invalid";
            echo $error;
        }
        mysqli_close($conn);
    }
}

// Supposons que le formulaire sur profile-settings.php est soumis et que le profil a été configuré
if (isset($_POST['profile_complete'])) {
    include 'dbconfig/db.php';
    $email = $_SESSION['email'];

    // Mise à jour de la colonne profile_setup à 1
    $update_query = "UPDATE patient SET profile_setup = 1 WHERE email = '$email'";
    if (mysqli_query($conn, $update_query)) {
        // Redirection vers le tableau de bord après la mise à jour
        header("Location: patient-dashboard.php");
        exit(); // Assurez-vous que le script s'arrête après la redirection
    } else {
        echo "Erreur lors de la mise à jour: " . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>


<!DOCTYPE html> 
<html lang="en">
	
<head>
		<meta charset="utf-8">
		<title>Connexion</title>
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
				</nav>
			</header>
			<!-- /Header -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					
					<div class="row">
						<div class="col-md-8 offset-md-2">
							
							<!-- Login Tab Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-6 col-lg-6 login-left">
										<img src="assets/img/login-banner.png" class="img-fluid" alt="Patient Login">
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Patient Login <a href="doctor/doc-login.php">Are you a doctor?</a></h3>
										</div>
										<form action="index.php" method="post">
											<div class="form-group form-focus">
												<input type="email" name="email" class="form-control floating">
												<label class="focus-label">Email</label>
											</div>
											<div class="form-group form-focus">
												<input type="password" name="pwd" class="form-control floating">
												<label class="focus-label">Password</label>
											</div>
											<div class="text-middle">
												<input type="submit" name='login' value="Login" class="btn btn-primary btn-block btn-lg login-btn" href="doctor/doctor-dashboard.php">
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
											<div class="text-center dont-have">Don't have an account? <a href="register.php">Register</a></div>
										</form>
									</div>
								</div>
							</div>

							<!-- /Login Tab Content -->
								
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
							
							
								
							</div>
							
							
								<!-- /Footer Widget -->
								
							</div>
							
						</div>
					</div>
				</div>
			
		   
		</div>
		<!-- /Main Wrapper -->
	  <script src="assets/js/removebanner.js"></script>
		<!-- jQuery -->
		<script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>
		
		
	</body>


</html>