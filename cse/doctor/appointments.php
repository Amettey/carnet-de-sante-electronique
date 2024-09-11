<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['user'])) {
    // Rediriger l'utilisateur si la session n'est pas valide
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$name = $_SESSION['user'];

include "../dbconfig/db.php";

// Utilisation de requêtes préparées pour éviter les injections SQL
$stmt = $conn->prepare("SELECT * FROM doctor WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_assoc();

if ($rows) {
    $dcontact = htmlspecialchars($rows['Contact']);
    $special = htmlspecialchars($rows['Special']);
    $dp = $rows['Image'];
} 

if (isset($_POST['accept']) || isset($_POST['reject'])) {
    $id = isset($_POST['accept']) ? $_POST['accept'] : $_POST['reject'];
    $status = isset($_POST['accept']) ? 1 : -1;

    $stmt = $conn->prepare("UPDATE appointments SET Status = ? WHERE AppointmentId = ?");
    $stmt->bind_param("ii", $status, $id);
    $stmt->execute();
}

$stmt = $conn->prepare("SELECT * FROM appointments WHERE DoctorMail = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result1 = $stmt->get_result();
$num = $result1->num_rows;
$i = 0;

$appointments = [];
while ($row1 = $result1->fetch_assoc()) {
    $patmail = $row1['PatientMail'];
    $aid = $row1['AppointmentId'];
    $doa = $row1['DateOfAppointment'];
    $status = $row1['Status'];

    $stmt = $conn->prepare("SELECT * FROM patient WHERE Email = ?");
    $stmt->bind_param("s", $patmail);
    $stmt->execute();
    $result2 = $stmt->get_result();
    $row = $result2->fetch_assoc();

    $appointments[$i] = [
        'patmail' => htmlspecialchars($patmail),
        'aid' => htmlspecialchars($aid),
        'doa' => htmlspecialchars($doa),
        'status' => htmlspecialchars($status),
        'patname' => htmlspecialchars($row['Name']),
        'patcountry' => htmlspecialchars($row['country']),
        'contact' => htmlspecialchars($row['Contact']),
        'patdp' => $row['Image'],
    ];

    $i++;
}

?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Appointments</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <script src="../assets/js/removebanner.js"></script>
    <link href="../assets/img/favicon.png" rel="icon">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        button {
            background-color: Transparent;
            border: none;
            cursor: pointer;
            outline: none;
        }
    </style>
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
                    <a href="doctor-dashboard.php" class="navbar-brand logo">
                        <img src="../assets/img/logo.png" class="img-fluid" alt="Logo" style="width: 100px; height: auto;">
                    </a>
                </div>
                <div class="main-menu-wrapper">
						<div class="menu-header">
							
							<a id="menu_close" class="menu-close" href="javascript:void(0);">
								<i class="fas fa-times"></i>
							</a>
						</div>
						<script type="text/javascript">
								function googleTranslateElementInit() {  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');}
							</script>
							<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
						 
					</div>		 
                <div class="main-menu-wrapper">
                    <ul class="nav header-navbar-rht">
                        <li class="nav-item contact-item">
                            <div class="header-contact-img">
                                <i class="far fa-hospital"></i>							
                            </div>
                            <div class="header-contact-detail">
                                <p class="contact-header">Contact</p>
                                <p class="contact-info-header"><?php echo $dcontact;?></p>
                            </div>
                        </li>
                        <li class="nav-item dropdown has-arrow logged-item">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <span class="user-img">
                                    <?php echo '<img class="rounded-circle" src="data:image/jpeg;base64,'.base64_encode($dp).'" alt="'.htmlspecialchars($name).'">';?>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="user-header">
                                    <div class="avatar avatar-sm">
                                        <?php echo '<img class="avatar-img rounded-circle" src="data:image/jpeg;base64,'.base64_encode($dp).'" alt="'.htmlspecialchars($name).'">';?>
                                    </div>
                                    <div class="user-text">
                                        <h6><?php echo htmlspecialchars($name);?></h6>
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
                                    <li class="breadcrumb-item"><a href="doctor-dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Appointments</li>
                                </ol>
                            </nav>
                            <h2 class="breadcrumb-title">Appointments</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                            <div class="profile-sidebar">
                                <div class="widget-profile pro-widget-content">
                                    <div class="profile-info-widget">
                                        <a href="#" class="booking-doc-img">
                                            <?php echo '<img class="rounded-circle" src="data:image/jpeg;base64,'.base64_encode($dp).'" alt="'.htmlspecialchars($name).'">';?>
                                        </a>
                                        <div class="profile-det-info">
                                            <h3><?php echo htmlspecialchars($name);?></h3>
                                            <div class="patient-details">
                                                <h5 class="mb-0"><?php echo htmlspecialchars($special);?></h5>
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
                                            <li class="active">
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
                                            <li>
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
                        </div>

                        <div class="col-md-7 col-lg-8 col-xl-9">
                            <div class="appointments">
                                <form method="POST" action="appointments.php">
                                    <?php foreach ($appointments as $appointment): ?>
                                        <div class="appointment-list">
                                            <div class="profile-info-widget">
                                                <a href="../patient-profile.php" class="booking-doc-img">
                                                    <img class="img-fluid" src="data:image/jpeg;base64,<?php echo base64_encode($appointment['patdp']);?>" alt="<?php echo $appointment['patname'];?>">
                                                </a>
                                                <div class="profile-det-info">
                                                    <h3><?php echo $appointment['patname'];?></h3>
                                                    <div class="patient-details">
                                                        <h5><i class="far fa-clock"></i> <?php echo $appointment['doa'];?></h5>
                                                        <h5><i class="fas fa-map-marker-alt"></i> <?php echo $appointment['patcountry'];?></h5>
                                                        <h5><i class="fas fa-phone"></i> <?php echo $appointment['contact'];?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="appointment-action">
                                                <?php if ($appointment['status'] == 0): ?>
                                                    <button type="submit" name="accept" value="<?php echo $appointment['aid'];?>" title="Accept"><i class="fas fa-check"></i></button>
                                                    <button type="submit" name="reject" value="<?php echo $appointment['aid'];?>" title="Cancel"><i class="fas fa-times"></i></button>
                                                <?php else: ?>
                                                    <button title="<?php echo ($appointment['status'] == 1) ? 'Accepted' : 'Canceled';?>" disabled>
                                                        <i class="fas fa-<?php echo ($appointment['status'] == 1) ? 'check' : 'times';?>"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/script.js"></script>
    </body>
</html>
