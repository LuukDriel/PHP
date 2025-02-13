<?php

include("DB_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST["naam"];
    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];
    $wachtwoord_herhaal = $_POST["wachtwoord_herhaal"];

/* controleert als emai al bestaat */
$checkemail = "SELECT * FROM gebruikers WHERE email = ?";
$stmt = $conn->prepare($checkemail);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "E-mail bestaat al";
        exit;
    }
$stmt->close();

/* controleert als wachtwoorden overeenkomen */
    if ($wachtwoord !== $wachtwoord_herhaal) {
        echo "Wachtwoorden komen niet overeen";
    exit;
    }

/* controleert als wachtwoord minimaal 8 tekens lang is */
    if (strlen($wachtwoord) <8 ) {
        echo "Wachtwoord moet minimaal 8 tekens lang zijn";
        exit;
    }

    $hashed_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

    echo "Naam: " . $naam . "<br>";
    echo "E-mail: " . $email . "<br>";
}

/* Voeg de gegevens toe aan de database */
$sql = "INSERT INTO gebruikers (gebruikersnaam, email, wachtwoord) VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param("sss", $naam, $email, $hashed_wachtwoord);

if ($stmt->execute()) {
    echo "Registratie gelukt!";
} else { 
    echo " Fout bij registratie";
}

$stmt->close();
$conn->close();

?>