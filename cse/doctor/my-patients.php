<?php
session_start();
$email = $_SESSION['email'];
$uname = $_SESSION['user'];
$name = $_SESSION['user'];
include "../dbconfig/db.php";

$query = mysqli_query($conn, "SELECT * FROM doctor WHERE Email='$email'");
$rows = mysqli_fetch_assoc($query);
$num = mysqli_num_rows($query);
if ($num == 1) {
    $name = $rows['Name'];
    $contact = $rows['Contact'];
    $special = $rows['Special'];
    $dp = $rows['Image'];
}

$sql1 = "SELECT * FROM appointments WHERE DoctorMail='$email'";
$result1 = mysqli_query($conn, $sql1);
$num = mysqli_num_rows($result1);
$i = 0;
while ($row1 = mysqli_fetch_array($result1)) {
    $patmail[$i] = $row1['PatientMail'];    
    $i++;
}
$patients = [];
$k = 0;
for ($i = 0; $i < $num; $i++) {
    if (!in_array($patmail[$i], $patients)) {
        $patients[$k] = $patmail[$i];
        $k++;
    }
}

$num = count($patients);

$i = 0;
while ($i < $num) {
    $sql = "SELECT * FROM patient WHERE Email='$patients[$i]'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $pname[$i] = $row['Name'];
        $pcountry[$i] = $row['country'];
        $pcontact[$i] = $row['Contact'];
        $pdob[$i] = $row['dob'];
        $patdp[$i] = $row['Image'];
        $pbg[$i] = $row['bgroup'];        
        $paddress[$i] = $row['address'];
        $pcity[$i] = $row['city'];
        $pstate[$i] = $row['state'];
        $pcountry[$i] = $row['country'];
        $ppcode[$i] = $row['pincode'];    
        $age[$i] = getAge($pdob[$i]);
        $pdob[$i] = monthName($pdob[$i]);
        // Ajout de l'identifiant du patient
        $patient_id[$i] = $row['id'];
    }
    $i++;
}

function monthName($date) {
    list($day, $month, $year) = explode("/", $date);
    $dateObj = DateTime::createFromFormat('!m', $month);
    $monthName = $dateObj->format('F');
    $datewithname = $day . ', ' . $monthName . ' ' . $year;
    return $datewithname;
}

function getAge($birthday) {
    list($day, $month, $year) = explode("/", $birthday);
    $year_diff = date("Y") - $year;
    $month_diff = date("m") - $month;
    $day_diff = date("d") - $day;
    if ($day_diff < 0 && $month_diff == 0) $year_diff--;
    if ($day_diff < 0 && $month_diff < 0) $year_diff--;
    return $year_diff;
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Doctor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <script src="../assets/js/removebanner.js"></script>
    <link href="../assets/img/favicon.png" rel="icon">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

    <!--[if lt IE 9]>
    <script src="../assets/js/html5shiv.min.js"></script>
    <script src="../assets/js/respond.min.js"></script>
    <![endif]-->
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
                <ul class="nav header-navbar-rht">
                    <li class="nav-item contact-item">
                        <div class="header-contact-img">
                            <i class="far fa-hospital"></i>                            
                        </div>
                        <div class="header-contact-detail">
                            <p class="contact-header">Contact</p>
                            <p class="contact-info-header"><?php echo $contact; ?></p>
                        </div>
                    </li>
                    <li class="nav-item dropdown has-arrow logged-item">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <span class="user-img">
                            <?php echo '<img class="rounded-circle" src="data:image/jpeg;base64,'.base64_encode($dp).'" alt="'.htmlspecialchars($name, ENT_QUOTES, 'UTF-8').'"/>  '; ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="user-header">
                                <div class="avatar avatar-sm">
                                    <?php echo '<img class="avatar-img rounded-circle" src="data:image/jpeg;base64,'.base64_encode($dp).'" alt="'.htmlspecialchars($name, ENT_QUOTES, 'UTF-8').'"/>  '; ?>
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
                                <li class="breadcrumb-item"><a href="doctor-dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">My Patients</li>
                            </ol>
                        </nav>
                        <h2 class="breadcrumb-title">My Patients</h2>
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
                                    <a href="" class="booking-doc-img">
                                    <?php echo '<img class="rounded-circle" src="data:image/jpeg;base64,'.base64_encode($dp).'" alt="'.htmlspecialchars($name, ENT_QUOTES, 'UTF-8').'"/>  '; ?>
                                    </a>
                                    <div class="profile-det-info">
                                        <h3><?php echo htmlspecialchars($uname, ENT_QUOTES, 'UTF-8'); ?></h3>
                                        <div class="patient-details">
                                            <h5 class="mb-0"><?php echo htmlspecialchars($special, ENT_QUOTES, 'UTF-8'); ?></h5>
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
                                            <a href="patients.php">
                                                <i class="fas fa-users"></i>
                                                <span>My Patients</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="appointments.php">
                                                <i class="fas fa-calendar-check"></i>
                                                <span>Appointments</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="doctor-profile-settings.php">
                                                <i class="fas fa-user-cog"></i>
                                                <span>Profile Settings</span>
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
                        <a href="add-patient.php" class="btn btn-primary mb-3">+ Ajouter un nouveau patient</a>
                        <div class="row row-grid">
                            <?php
                            $i = 0;
                            while ($i < $num) {
                                echo '<div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="card widget-profile pat-widget-profile">
                                        <div class="card-body">
                                            <div class="pro-widget-content">
                                                <div class="profile-info-widget">
                                                    <a href="../patient-profile.php?patient_id=' . htmlspecialchars($patient_id[$i], ENT_QUOTES, 'UTF-8') . '" class="booking-doc-img">
                                                        <img class="img-fluid" src="data:image/jpeg;base64,' . base64_encode($patdp[$i]) . '" class="img-thumbnail" alt="' . htmlspecialchars($pname[$i], ENT_QUOTES, 'UTF-8') . '"/>
                                                    </a>
                                                    <div class="profile-det-info">
                                                        <h3><a>' . htmlspecialchars($pname[$i], ENT_QUOTES, 'UTF-8') . '</a></h3>
                                                        <div class="patient-details">
                                                            <h5><b>Patient Mail :</b>' . htmlspecialchars($patients[$i], ENT_QUOTES, 'UTF-8') . '</h5>
                                                            <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i>' . htmlspecialchars($pcity[$i], ENT_QUOTES, 'UTF-8') . ',' . htmlspecialchars($pstate[$i], ENT_QUOTES, 'UTF-8') . ',<br>' . htmlspecialchars($pcountry[$i], ENT_QUOTES, 'UTF-8') . '</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="patient-info">
                                                <ul>
                                                    <li>Phone <span>' . htmlspecialchars($pcontact[$i], ENT_QUOTES, 'UTF-8') . '</span></li>
                                                    <li>Age <span>' . htmlspecialchars($age[$i], ENT_QUOTES, 'UTF-8') . '</span></li>
                                                    <li>Blood Group <span>' . htmlspecialchars($pbg[$i], ENT_QUOTES, 'UTF-8') . '</span></li>
                                                    <li>Patient ID <span>' . htmlspecialchars($patient_id[$i], ENT_QUOTES, 'UTF-8') . '</span></li>
                                                </ul>
                                               
                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#messageModal' . htmlspecialchars($patient_id[$i], ENT_QUOTES, 'UTF-8') . '">
                                                    <i class="fas fa-envelope"></i> Envoyer un message
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';

                                // Ajout de la modale pour chaque patient
                                echo '
                                <div class="modal fade" id="messageModal' . htmlspecialchars($patient_id[$i], ENT_QUOTES, 'UTF-8') . '" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel' . htmlspecialchars($patient_id[$i], ENT_QUOTES, 'UTF-8') . '" aria-hidden="false">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="messageModalLabel' . htmlspecialchars($patient_id[$i], ENT_QUOTES, 'UTF-8') . '">Envoyer un message à ' . htmlspecialchars($pname[$i], ENT_QUOTES, 'UTF-8') . '</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="send-message.php" method="post">
                                                    <div class="form-group">
                                                        <label for="messageText">Message</label>
                                                        <textarea class="form-control" name="messageText" rows="4" required></textarea>
                                                    </div>
                                                    <input type="hidden" name="patientEmail" value="' . htmlspecialchars($patients[$i], ENT_QUOTES, 'UTF-8') . '">
                                                    <input type="hidden" name="doctorEmail" value="' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-primary">Envoyer</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                $i++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    
                </div>
            </div>
        </footer>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>
</html>
