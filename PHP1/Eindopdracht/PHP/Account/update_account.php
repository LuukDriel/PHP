<?php
session_start();

include 'DB_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo 'U bent niet ingelogd';
    exit();
}

$gebruiker_id = $_SESSION['user_id'];

$naam = $_POST['gebruikersnaam'];
$voornaam = $_POST['voornaam'];
$achternaam = $_POST['achternaam'];
$email = $_POST['email'];
$wachtwoord = $_POST['wachtwoord'];
$wachtwoord_herhaal = $_POST['wachtwoord_herhaal'];

if ($wachtwoord != $wachtwoord_herhaal) {
    echo 'Wachtwoorden komen niet overeen';
    exit();
}

if (strlen($wachtwoord) <8 ) {
    echo "Wachtwoord moet minimaal 8 tekens lang zijn";
    exit;
}

$hashed_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

$sql = "UPDATE gebruikers SET gebruikersnaam = ?, voornaam = ?, achternaam = ?, email = ?, wachtwoord = ? WHERE gebruiker_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $naam, $voornaam, $achternaam, $email, $hashed_wachtwoord, $gebruiker_id);
$stmt->execute();
$stmt->close();

if ($conn->query($sql) === TRUE) {
    echo "Account bijgewerkt";
    header('Location: account.php');
} else {
    echo "Fout bij bijwerken account: " . $conn->error;
}

$conn->close();