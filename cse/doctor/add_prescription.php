<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Prescription</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
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
    <div class="container mt-5">
        <h2>Add Prescription</h2>
        
        <?php
        // Informations de connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "doc";

        // Création de la connexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération des données du formulaire
            $patient_id = $_POST['patient_id'];
            $doctor_id = $_POST['doctor_id'];
            $medication = $_POST['medication'];
            $dosage = $_POST['dosage'];
            $frequency = $_POST['frequency'];
            $duration = $_POST['duration'];

            // Insertion des données dans la table prescription
            $sql = "INSERT INTO prescriptions (patient_id, doctor_id, medication, dosage, frequency, duration)
                    VALUES ('$patient_id', '$doctor_id', '$medication', '$dosage', '$frequency', '$duration')";

            if ($conn->query($sql) === TRUE) {
                echo '<div class="alert alert-success">New prescription created successfully</div>';
            } else {
                echo '<div class="alert alert-danger">Error: ' . $sql . '<br>' . $conn->error . '</div>';
            }
        }

        // Vérification de la présence des paramètres GET
        if (isset($_GET['patient_id']) && isset($_GET['doctor_id'])) {
            $patient_id = htmlspecialchars($_GET['patient_id']);
            $doctor_id = htmlspecialchars($_GET['doctor_id']);
        } else {
            die("");
        }

        $conn->close();
        ?>

        <form action="add_prescription.php" method="post">
            <div class="form-group">
                <label for="patient_id">Patient ID:</label>
                <input type="text" class="form-control" id="patient_id" name="patient_id" value="<?php echo $patient_id; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="doctor_id">Doctor ID:</label>
                <input type="text" class="form-control" id="doctor_id" name="doctor_id" value="<?php echo $doctor_id; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="medication">Medication:</label>
                <input type="text" class="form-control" id="medication" name="medication" required>
            </div>
            <div class="form-group">
                <label for="dosage">Dosage:</label>
                <input type="text" class="form-control" id="dosage" name="dosage" required>
            </div>
            <div class="form-group">
                <label for="frequency">Frequency:</label>
                <input type="text" class="form-control" id="frequency" name="frequency" required>
            </div>
            <div class="form-group">
                <label for="duration">Duration:</label>
                <input type="text" class="form-control" id="duration" name="duration" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
