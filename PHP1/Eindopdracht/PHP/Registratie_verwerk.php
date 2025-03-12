<?php

include("DB_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST["naam"];
    $voornaam = $_POST["voornaam"];
    $achternaam = $_POST["achternaam"];
    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];
    $wachtwoord_herhaal = $_POST["wachtwoord_herhaal"];

/* controleert als email al bestaat */
$checkemail = "SELECT * FROM gebruikers WHERE email = ?";
$stmt = $conn->prepare($checkemail);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "E-mail bestaat al";
        header("Location: Registratie.php?error=email_bestaat");
        exit;
    }
$stmt->close();

/* controleert als wachtwoorden overeenkomen */
    if ($wachtwoord !== $wachtwoord_herhaal) {
        echo "Wachtwoorden komen niet overeen";
        header("Location: Registratie.php?error=wachtwoord_komt_niet_overeen");
    exit;
    }

/* controleert als wachtwoord minimaal 8 tekens lang is */
    if (strlen($wachtwoord) <8 ) {
        echo "Wachtwoord moet minimaal 8 tekens lang zijn";
        header("Location: Registratie.php?error=wachtwoord_te_kort");
        exit;
    }

    $hashed_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);
}

/* Voeg de gegevens toe aan de database */
$sql = "INSERT INTO gebruikers (gebruikersnaam, voornaam, achternaam, email, wachtwoord) VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param("sssss", $naam, $voornaam, $achternaam, $email, $hashed_wachtwoord);

if ($stmt->execute()) {
    echo "Registratie gelukt!";
} else { 
    echo " Fout bij registratie";
}

$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>registratie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body class="container">
    <div class="echo-text">
        <?php
            echo "Naam: " . $naam . "<br>";
            echo "Voornaam: " . $voornaam . "<br>";
            echo "Achternaam: " . $achternaam . "<br>";
            echo "E-mail: " . $email . "<br>";
        ?>
    </div>
    <br>
    <a href="../Index.php" class="button">Terug naar home</a>
    <a href="Inlog.php" class="button">Inloggen</a>
</body>
</html>