<?php
session_start();
include "../dbconfig/db.php";

// Vérifiez si l'email du médecin est passé en paramètre
if (isset($_GET['email'])) {
    $docEmail = mysqli_real_escape_string($conn, $_GET['email']);

    // Récupérez les informations du médecin
    $query = "SELECT * FROM doctor WHERE Email='$docEmail'";
    $result = mysqli_query($conn, $query);
    $doctor = mysqli_fetch_assoc($result);

    if (!$doctor) {
        echo "Médecin non trouvé.";
        exit;
    }
} else {
    echo "Aucun médecin sélectionné.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Doctor Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
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
        <!-- (Inclure le header comme dans `search.php`) -->

		<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-md-12 col-12">
							<nav aria-label="breadcrumb" class="page-breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="../search.php">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Doctor profil</li>
								</ol>
							</nav>
							<h2 class="breadcrumb-title">Doctor profil</h2>
						</div>
					</div>
				</div>
			</div>
			<!-- /Breadcrumb -->

        <!-- Page Content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Doctor Profile -->
                        <div class="card">
                            <div class="card-body">
                                <div class="doctor-widget">
                                    <div class="doc-info-left">
                                        <div class="doctor-img">
                                            <img class="img-fluid" src="data:image/jpeg;base64,<?php echo base64_encode($doctor['Image']); ?>" alt=""/>
                                        </div>
                                        <div class="doc-info-cont">
                                            <h4 class="doc-name"><?php echo htmlspecialchars($doctor['Name']); ?></h4>
                                            <p class="doc-speciality"><?php echo htmlspecialchars($doctor['Special']); ?></p>
                                            <div class="clinic-details">
                                                <p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($doctor['City']); ?></p>
                                            </div>
                                            <div class="doc-contact">
                                                <p class="doc-contact-info"><i class="fas fa-phone-alt"></i> <?php echo htmlspecialchars($doctor['Contact']); ?></p>
                                                <p class="doc-contact-info"><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($doctor['Email']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="doc-info-right">
                                        <!-- Ajouter des actions supplémentaires, comme prendre rendez-vous -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Doctor Profile -->
                    </div>
                </div>
            </div>
        </div>        
        <!-- /Page Content -->

        <!-- Footer -->
		  <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>&copy; <?php echo date('Y'); ?> <a href="index.php">Medical Dashboard</a>. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- (Inclure le footer comme dans `search.php`) -->
    </div>
    <!-- /Main Wrapper -->
    
    <!-- jQuery -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/script.js"></script>
    
</body>
</html>
