<?php
session_start();
$email = $_SESSION['email'];
include "../dbconfig/db.php";

// Pour gérer l'insertion d'images
if (isset($_POST["insert"])) {
    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
        $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
        $query = "UPDATE doctor SET Image='$file' WHERE Email='$email'";
        if (mysqli_query($conn, $query)) {
            echo '<script>alert("Image Inserted into Database")</script>';
        } else {
            echo '<script>alert("Error inserting image: ' . mysqli_error($conn) . '")</script>';
        }
    } else {
        echo '<script>alert("No image file selected")</script>';
    }
}

// Pour gérer l'insertion de documents de preuve
if (isset($_POST["insertproof"])) {
    if (is_uploaded_file($_FILES["imaged"]["tmp_name"])) {
        $file = addslashes(file_get_contents($_FILES["imaged"]["tmp_name"]));
        $query = "UPDATE doctor SET Proof='$file' WHERE Email='$email'";
        if (mysqli_query($conn, $query)) {
            echo '<script>alert("Document Inserted into Database")</script>';
        } else {
            echo '<script>alert("Error inserting document: ' . mysqli_error($conn) . '")</script>';
        }
    } else {
        echo '<script>alert("No document file selected")</script>';
    }
}

$query = mysqli_query($conn, "SELECT * FROM doctor WHERE Email='$email'");
$rows = mysqli_fetch_assoc($query);

if ($rows) {
    $name = $rows['Name'];
    $contact = $rows['Contact'];
    $special = $rows['Special'];
    $gender = $rows['Gender'];
    $dob = $rows['DOB'];
    $bio = $rows['BIO'];
    $service = $rows['Service'];
    $clinicName = $rows['ClinicName'];
    $clinicAddress = $rows['ClinicAddress'];
    $city = $rows['City'];
    $state = $rows['State'];
    $country = $rows['Country'];
    $pincode = $rows['Pincode'];
}

// Pour gérer la mise à jour des informations du médecin
if (isset($_POST['save_changes'])) {
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $bio = $_POST['biography'];
    $service = $_POST['services'];
    $special = $_POST['specialist'];
    $clinicName = $_POST['clinic_name'];
    $clinicAddress = $_POST['clinic_address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pincode = $_POST['pincode'];

    $sql = "UPDATE doctor SET Gender=?, DOB=?, BIO=?, Service=?, Special=?, ClinicName=?, ClinicAddress=?, City=?, State=?, Country=?, Pincode=? WHERE Email=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("ssssssssssss", $gender, $dob, $bio, $service, $special, $clinicName, $clinicAddress, $city, $state, $country, $pincode, $email);
    if ($stmt->execute()) {
        echo "Updated";
    } else {
        echo "Error: " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
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
    <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="../assets/plugins/dropzone/dropzone.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    
   <!-- Header -->
       <header class="header" style="height: 100px;">
    <nav class="navbar navbar-expand-lg header-nav" style="height: 100%;">
        <div class="navbar-header" style="height: 100%;">
            <a id="mobile_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <a href="doctor-dashboard.php" class="navbar-brand logo" style="height: 100%;">
                <img src="../assets/img/logo.png" class="img-fluid" alt="Logo" style="width: 100px; height: auto;">
            </a>
        </div>
        <div class="main-menu-wrapper" style="height: 100%;">
            <div class="menu-header">
                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <script type="text/javascript">
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({ pageLanguage: 'en' }, 'google_translate_element');
                }
            </script>
            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        </div>
        <ul class="nav header-navbar-rht" style="height: 100%;">
            <li class="nav-item contact-item" style="height: 100%; display: flex; align-items: center;">
                <div class="header-contact-img">
                    <i class="far fa-hospital"></i>							
                </div>
                <div class="header-contact-detail">
                    <p class="contact-header">Contact</p>
                    <p class="contact-info-header"><?php echo $contact;?></p>
                </div>
            </li>
            
            <!-- User Menu -->
            <li class="nav-item dropdown has-arrow logged-item" style="height: 100%; display: flex; align-items: center;">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                    <span class="user-img">
                        <?php echo '<img class="rounded-circle" src="data:image/jpeg;base64,'.base64_encode($rows['Image'] ).'"  alt="'.$name.'"/>  ';?>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="user-header">
                        <div class="avatar avatar-sm">
                            <?php echo '<img class="avatar-img rounded-circle" src="data:image/jpeg;base64,'.base64_encode($rows['Image'] ).'"  alt="'.$name.'"/>  ';?>
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
        <div class="breadcrumb-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-12 col-12">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="doctor-dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
                            </ol>
                        </nav>
                        <h2 class="breadcrumb-title">Profile Settings</h2>
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
                                        <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($rows['Image']) . '" class="img-thumbnail" />'; ?>
                                    </a>
                                    <div class="profile-det-info">
                                        <h3><?php echo htmlspecialchars($name); ?></h3>
                                        <div class="patient-details">
                                            <h5 class="mb-0"><?php echo htmlspecialchars($special); ?></h5>
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
                                        <li class="active">
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
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Basic Information</h4>
                                <div class="row form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="change-avatar">
                                                <div class="profile-img">
                                                    <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($rows['Image']) . '" class="img-thumbnail" />'; ?>
                                                </div>
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="upload-img">
                                                        <div class="change-photo-btn">
                                                            <span><i class="fa fa-upload"></i> Select Photo</span>
                                                            <input type="file" class="upload" name="image" id="image">
                                                        </div>
                                                        <input type="submit" name="insert" class="btn btn-primary" value="Upload">
                                                    </div>
                                                </form>
                                                <div class="profile-img">
                                                    <?php echo '<img src="data:image/jpeg;base64,' . base64_encode($rows['Proof']) . '" class="img-thumbnail" />'; ?>
                                                </div>
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="upload-img">
                                                        <div class="change-photo-btn">
                                                            <span><i class="fa fa-upload"></i> Select Proof Document</span>
                                                            <input type="file" class="upload" name="imaged" id="imaged">
                                                        </div>
                                                        <input type="submit" name="insertproof" class="btn btn-primary" value="Upload">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Gender</label>
                                            <input type="text" name="gender" class="form-control" value="<?php echo htmlspecialchars($gender); ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Date of Birth</label>
                                            <input type="date" name="dob" class="form-control" value="<?php echo htmlspecialchars($dob); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Specialist</label>
                                            <input type="text" name="specialist" class="form-control" value="<?php echo htmlspecialchars($special); ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Clinic Name</label>
                                            <input type="text" name="clinic_name" class="form-control" value="<?php echo htmlspecialchars($clinicName); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Clinic Address</label>
                                            <input type="text" name="clinic_address" class="form-control" value="<?php echo htmlspecialchars($clinicAddress); ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($city); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>State</label>
                                            <input type="text" name="state" class="form-control" value="<?php echo htmlspecialchars($state); ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Country</label>
                                            <input type="text" name="country" class="form-control" value="<?php echo htmlspecialchars($country); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Pincode</label>
                                            <input type="text" name="pincode" class="form-control" value="<?php echo htmlspecialchars($pincode); ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Services</label>
                                            <input type="text" name="services" class="form-control" value="<?php echo htmlspecialchars($service); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Biography</label>
                                            <textarea name="biography" class="form-control" rows="4" required><?php echo htmlspecialchars($bio); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <input type="submit" name="save_changes" class="btn btn-primary" value="Save Changes">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/moment.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="../assets/plugins/select2/js/select2.min.js"></script>
    <script src="../assets/plugins/dropzone/dropzone.min.js"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>
