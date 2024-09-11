<?php
session_start();
include "../dbconfig/db.php";

// Check if the patient ID is set in the session
if (!isset($_SESSION['patient_id'])) {
    die("Error: Patient ID not found in session.");
}

// Retrieve the patient ID from the session
$patient_id = $_SESSION['patient_id'];

// Initialize message variable
$message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $description = $_POST['description'];
    $doctor_name = $_POST['doctor_name'];
    $notes = $_POST['notes'];

    // Prepare and execute the SQL query to insert data into the medical_history table
    $stmt = $conn->prepare("INSERT INTO medical_history (patient_id, date, description, doctor_name, notes) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $patient_id, $date, $description, $doctor_name, $notes);

    if ($stmt->execute()) {
        $message = "New medical history record added successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Medical History</title>
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
                    <a href="doctor-dashboard.php" class="navbar-brand logo">
						<img src="../assets/img/logo.png" class="img-fluid" alt="Logo" style="width: 100px; height: auto;">
					</a>
                </div>
                <div class="navbar-collapse">
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
            </nav>
        </header>

        <div class="container mt-5">
            <h1>Add Medical History</h1>
    
            <?php
            if (!empty($message)) {
                echo "<p>$message</p>";
            }
            ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="doctor_name">Doctor Name:</label>
                    <input type="text" id="doctor_name" name="doctor_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="notes">Notes:</label>
                    <textarea id="notes" name="notes" class="form-control" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Add Medical History</button>
            </form>
        </div>

        <footer class="footer">
            <div class="footer-bottom">
                <div class="container-fluid">
                    <div class="copyright">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="copyright-text">
                                    <p class="mb-0"><a href="doctor-dashboard.php">Back to Dashboard</a></p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="social-icon text-right">
                                    <ul>
                                        <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                                    </ul>
                                </div>
                            </div>
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
