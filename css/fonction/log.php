<?php
session_start();  // Starting Session

include "connexion.php";
$email = $_POST["email"];
$motdepasse = password_hash($_POST["motdepasse"], PASSWORD_DEFAULT);

$sql = "SELECT * FROM utilisateurs WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // output data of each row
    $row = $result->fetch_assoc();
    $_SESSION['IdUsers']=$row['IdUsers'];
        echo "Bienvenue";
    
} else {
    echo "0 results";
}
$conn->close();
