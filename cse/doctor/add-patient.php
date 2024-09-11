<?php
include "../dbconfig/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $bgroup = mysqli_real_escape_string($conn, $_POST['bgroup']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $weight = mysqli_real_escape_string($conn, $_POST['weight']);
    $height = mysqli_real_escape_string($conn, $_POST['height']);
    $emergencynumber = mysqli_real_escape_string($conn, $_POST['emergencynumber']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    // Gestion de l'upload de l'image
    $image = $_FILES['image']['name'];
    $imagePath = 'images/' . basename($image);
    $imageType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
    $imageSize = $_FILES['image']['size'];
    $uploadOk = 1;

    // Vérifier si le fichier est une image
    if (!empty($image)) {
        $check = getimagesize($_FILES['image']['tmp_name']);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }
    }

    // Vérifier la taille de l'image (par exemple, 2MB maximum)
    if ($imageSize > 2000000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Autoriser certains formats d'image uniquement
    if($imageType != "jpg" && $imageType != "png" && $imageType != "jpeg") {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG sont autorisés.";
        $uploadOk = 0;
    }

    // Si aucune image n'est téléchargée ou s'il y a une erreur, utiliser l'image par défaut
    if ($uploadOk == 0 || empty($image)) {
        $imagePath = 'images/default_image.jpg';
    } else {
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    // Requête SQL avec une requête préparée pour insérer le nouveau patient
    $sql = "INSERT INTO patient (Email, Contact, Image, Password, lname, dob, bgroup, address, city, state, country, pincode, weight, height, emergencynumber, Name)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssssssssssss', $email, $contact, $imagePath, $password, $lname, $dob, $bgroup, $address, $city, $state, $country, $pincode, $weight, $height, $emergencynumber, $name);

    if (mysqli_stmt_execute($stmt)) {
        echo "Patient ajouté avec succès!";
    } else {
        echo "Erreur: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Patient</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        .form-group {
            display: flex;
            justify-content: space-between;
        }
        .form-group > label {
            width: 30%;
        }
        .form-group > input, .form-group > select {
            width: 65%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Ajouter un nouveau patient</h2>
        <form action="add-patient.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nom:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="lname">Prénom:</label>
                <input type="text" class="form-control" id="lname" name="lname" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact:</label>
                <input type="text" class="form-control" id="contact" name="contact" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="dob">Date de naissance:</label>
                <input type="date" class="form-control" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label for="bgroup">Groupe sanguin:</label>
                <select class="form-control" id="bgroup" name="bgroup" required>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Adresse:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="city">Ville:</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="state">État/Région:</label>
                <input type="text" class="form-control" id="state" name="state" required>
            </div>
            <div class="form-group">
                <label for="country">Pays:</label>
                <input type="text" class="form-control" id="country" name="country" value="Côte d'Ivoire" required>
            </div>
            <div class="form-group">
                <label for="pincode">Code Postal:</label>
                <input type="text" class="form-control" id="pincode" name="pincode" required>
            </div>
            <div class="form-group">
                <label for="weight">Poids (kg):</label>
                <input type="number" class="form-control" id="weight" name="weight" required>
            </div>
            <div class="form-group">
                <label for="height">Taille (cm):</label>
                <input type="number" class="form-control" id="height" name="height" required>
            </div>
            <div class="form-group">
                <label for="emergencynumber">Numéro d'urgence:</label>
                <input type="text" class="form-control" id="emergencynumber" name="emergencynumber" required>
            </div>
            <div class="form-group">
                <label for="image">Photo du patient:</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter le patient</button>
        </form>
    </div>
</body>
</html>
