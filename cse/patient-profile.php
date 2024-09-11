<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['user'])) {
    header("Location: login.php"); // Rediriger si l'utilisateur n'est pas connecté
    exit();
}

$email = $_SESSION['email'];
$name = $_SESSION['user'];

include "dbconfig/db.php";

// Vérifiez si l'ID du patient est passé en paramètre
$patient_id = isset($_GET['patient_id']) ? intval($_GET['patient_id']) : null;

if ($patient_id) {
    // Récupérer toutes les informations du patient en utilisant l'ID
    $sql = "SELECT * FROM patient WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $patient_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $patient_info = mysqli_fetch_assoc($result);

    if ($patient_info) {
        // Extraire les informations du patient
        $pname = $patient_info['Name'] ?? 'N/A';
        $selected_patient_email = $patient_info['Email'] ?? 'N/A';
        $pcity = $patient_info['city'] ?? 'N/A';
        $pstate = $patient_info['state'] ?? 'N/A';
        $pcountry = $patient_info['country'] ?? 'N/A';
        $pcontact = $patient_info['Contact'] ?? 'N/A';
        $pbg = $patient_info['bgroup'] ?? 'N/A';
        $pdob = $patient_info['dob'] ?? 'N/A';
        

        // Préparer l'image du patient
        $patdp = $patient_info['Image'] ?? null;
        $imageSrc = $patdp ? "data:image/jpeg;base64," . base64_encode($patdp) : 'path/to/default/image.jpg';
        
        // Récupérer les détails du médecin connecté
        $query = "SELECT * FROM doctor WHERE Email=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_assoc($result);

        $doctor_id = $rows['DoctorID'] ?? 'N/A';
    } else {
        echo "Aucun patient trouvé avec cet ID.";
        exit;
    }
} else {
    echo "ID du patient non spécifié.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Patient Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link href="assets/img/favicon.png" rel="icon">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/html5shiv.min.js"></script>
    <script src="assets/js/respond.min.js"></script>
</head>
<body>
    <div class="main-wrapper">
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
                    <a href="doctor/doctor-dashboard.php" class="navbar-brand logo">
						<img src="assets/img/logo.png" class="img-fluid" alt="Logo" style="width: 100px; height: auto;">
					</a>
                </div>
                <div>
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
                </div>
                <ul class="nav header-navbar-rht">
                    <li class="nav-item dropdown has-arrow logged-item">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <span class="user-img">
                                <?php echo '<img class="rounded-circle" src="data:image/jpeg;base64,'.base64_encode($patdp).'" alt="'.htmlspecialchars($name, ENT_QUOTES, 'UTF-8').'"/>'; ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="user-header">
                                <div class="avatar avatar-sm">
                                    <?php echo '<img class="avatar-img rounded-circle" src="data:image/jpeg;base64,'.base64_encode($patdp).'" alt="'.htmlspecialchars($name, ENT_QUOTES, 'UTF-8').'"/>'; ?>
                                </div>
                                <div class="user-text">
                                    <h6><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></h6>
                                    <p class="text-muted mb-0">Doctor</p>
                                </div>
                            </div>
                            <a class="dropdown-item" href="doctor-dashboard.php">Dashboard</a>
                            <a class="dropdown-item" href="doctor-profile-settings.php">Profile Settings</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </header>

        <div class="breadcrumb-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-12 col-12">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="doctor/doctor-dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>
                        <h2 class="breadcrumb-title">Profile</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card widget-profile pat-widget-profile">
                    <div class="card-body">
                        <div class="pro-widget-content">
                            <div class="profile-info-widget">
                                <a href="../patient-profile.php" class="booking-doc-img">
                                    <img class="img-fluid" src="<?php echo htmlspecialchars($imageSrc, ENT_QUOTES, 'UTF-8'); ?>" class="img-thumbnail" alt="<?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?>"/>
                                </a>
                                <div class="profile-det-info">
                                    <h3><a><?php echo htmlspecialchars($pname, ENT_QUOTES, 'UTF-8'); ?></a></h3>
                                    <div class="patient-details">
                                        <h5><b>Patient Mail :</b> <?php echo htmlspecialchars($selected_patient_email, ENT_QUOTES, 'UTF-8'); ?></h5>
                                        <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($pcity, ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($pstate, ENT_QUOTES, 'UTF-8'); ?>,<br> <?php echo htmlspecialchars($pcountry, ENT_QUOTES, 'UTF-8'); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="patient-info">
                            <ul>
                                <li>Phone <span><?php echo htmlspecialchars($pcontact, ENT_QUOTES, 'UTF-8'); ?></span></li>
                                <li>Age <span><?php echo htmlspecialchars($pdob, ENT_QUOTES, 'UTF-8'); ?></span></li>
                                <li>Blood Group <span><?php echo htmlspecialchars($pbg, ENT_QUOTES, 'UTF-8'); ?></span></li>
                            </ul>
                        </div>
                        <div class="doc-info-right">
                            <div class="clinic-booking">
                                <a class="btn btn-primary mb-3" href="doctor/add_prescription.php?patient_id=<?php echo htmlspecialchars($patient_id, ENT_QUOTES, 'UTF-8'); ?>&doctor_id=<?php echo htmlspecialchars($doctor_id, ENT_QUOTES, 'UTF-8'); ?>">add prescription</a>
                            </div>
                        </div>
                        <div>
                            <a href="doctor/send-message.php" class="btn btn-primary mb-3">Send message</a>
                        </div>
                      
                       
                    </div>
                </div>
            </div>
        </div>
        
        <footer class="footer">
            <div class="footer-bottom">
                <div class="container-fluid">
                    <div class="copyright">
                        <div class="row">
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/moment.min.js"></script>
        <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
        <script src="assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
        <script src="assets/js/script.js"></script>
    </div>
</body>
</html>
