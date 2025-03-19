<?php
session_start();

include '../DB_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo 'U bent niet ingelogd';
    exit();
}

$gebruiker_id = $_SESSION['user_id'];

// haalt de gegevens uit de form
$naam = $_POST['gebruikersnaam'];
$voornaam = $_POST['voornaam'];
$achternaam = $_POST['achternaam'];
$email = $_POST['email'];
$wachtwoord = $_POST['wachtwoord'];
$wachtwoord_herhaal = $_POST['wachtwoord_herhaal'];

// controleert of de wachtwoorden kloppen
if ($wachtwoord != $wachtwoord_herhaal) {
    header('Location: account.php?error=wachtwoord_heraal');
    exit();
}

if (strlen($wachtwoord) < 8) {;
    header('Location: account.php?error=wachtwoord_lengte');
    exit;
}

// hashed het wachtwoord
$hashed_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

// update de gegevens in de database
$sql = "UPDATE gebruikers SET gebruikersnaam = ?, voornaam = ?, achternaam = ?, email = ?, wachtwoord = ? WHERE gebruiker_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "Fout bij voorbereiden van de query: " . $conn->error;
    exit();
}

$stmt->bind_param("sssssi", $naam, $voornaam, $achternaam, $email, $hashed_wachtwoord, $gebruiker_id);

if ($stmt->execute()) {
    echo "Account bijgewerkt";
    header('Location: account.php');
    exit();
} else {
    echo "Fout bij bijwerken account: " . $stmt->error;
}

$stmt->close();
$conn->close();