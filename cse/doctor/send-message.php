<?php
session_start();
include "../dbconfig/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $patientEmail = $_POST['patientEmail'];
    $doctorEmail = $_POST['doctorEmail'];
    $messageText = mysqli_real_escape_string($conn, $_POST['messageText']);

    // Assurer que le message et les adresses sont bien fournies
    if (empty($patientEmail) || empty($doctorEmail) || empty($messageText)) {
        echo "Tous les champs sont requis.";
        exit;
    }

    // Préparer le message pour l'envoi par e-mail
    $subject = "Message de votre médecin";
    $message = "Bonjour,\n\nVous avez reçu un nouveau message de votre médecin.\n\n" .
               "Message : \n$messageText\n\n" .
               "Merci,\nVotre Équipe Médicale";
    $headers = "From: $doctorEmail\r\n" .
               "Reply-To: $doctorEmail\r\n" .
               "Content-Type: text/plain; charset=UTF-8";

    // Envoyer l'e-mail
    if (mail($patientEmail, $subject, $message, $headers)) {
        echo "<div class='alert alert-success'>Message envoyé avec succès à $patientEmail.</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de l'envoi du message.</div>";
    }

    // Optionnel : Enregistrer le message dans la base de données
    $query = "INSERT INTO messages (doctorEmail, patientEmail, messageText, dateSent) VALUES ('$doctorEmail', '$patientEmail', '$messageText', NOW())";
    if (mysqli_query($conn, $query)) {
        echo "<div class='alert alert-success'>Message enregistré dans la base de données.</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de l'enregistrement du message.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoyer un Message</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Envoyer un Message</h2>
    <form id="messageForm" action="" method="post">
        <div class="form-group">
            <label for="patientEmail">Email du Patient</label>
            <input type="email" class="form-control" id="patientEmail" name="patientEmail" required>
        </div>
        <div class="form-group">
            <label for="doctorEmail">Votre Email</label>
            <input type="email" class="form-control" id="doctorEmail" name="doctorEmail" required>
        </div>
        <div class="form-group">
            <label for="messageText">Message</label>
            <textarea class="form-control" id="messageText" name="messageText" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    document.getElementById('messageForm').addEventListener('submit', function(event) {
        // Example validation (you can add more complex validation if needed)
        var patientEmail = document.getElementById('patientEmail').value;
        var doctorEmail = document.getElementById('doctorEmail').value;
        var messageText = document.getElementById('messageText').value;

        if (!patientEmail || !doctorEmail || !messageText) {
            alert('Tous les champs sont requis.');
            event.preventDefault(); // Prevent form submission
        }
    });
</script>

</body>
</html>
