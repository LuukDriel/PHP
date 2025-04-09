<?php

include("../DB_connect.php");
include("../User_klasse.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST["naam"];
    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];
    $wachtwoord_herhaal = $_POST["wachtwoord_herhaal"];

/* controleert als email al bestaat */
$checkemail = "SELECT * FROM users WHERE email = :email";
$stmt = $pdo->prepare($checkemail);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();

    if ($stmt->rowCount() > 0) {
        header("Location: Registratie.php?registratie=error&email=bestaat");
        exit;
    }

/* controleert als wachtwoorden overeenkomen */
    if ($wachtwoord !== $wachtwoord_herhaal) {
    header("Location: Registratie.php?registratie=error&wachtwoord=verschil");
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
User::setPDO($pdo);

$user = new User($naam, $email, 'user', $hashed_wachtwoord);
if ($user->register()) {
    header("Location: ../../index.php?registratie=succes");
    exit();
} else {
    header("Location: ../../index.php?registratie=error");
    exit();
}

?>