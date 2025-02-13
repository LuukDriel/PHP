<?php

include("DB_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST["naam"];
    $email = $_POST["email"];
    $wachtwoord = $_POST["wachtwoord"];
    $wachtwoord_herhaal = $_POST["wachtwoord_herhaal"];

    if ($wachtwoord !== $wachtwoord_herhaal) {
        echo "Wachtwoorden komen niet overeen";
    exit;
    }

    if (strlen($wachtwoord) <8 ) {
        echo "Wachtwoord moet minimaal 8 tekens lang zijn";
        exit;
    }

    $hashed_wachtwoord = password_hash($wachtwoord, PASSWORD_DEFAULT);

    $registratie = [
        'naam' => $naam,
        'email' => $email,
        'wachtwoord' => $hashed_wachtwoord,
    ];

    echo "Registratie gelukt! <br>";
    echo "Naam: " . $registratie['naam'] . "<br>";
    echo "E-mail: " . $registratie['email'] . "<br>";
}

$sql = "INSERT IGNORE INTO gebruikers (gebruikersnaam, email, wachtwoord) VALUES ('" . $registratie['naam'] . "', '" . $registratie['email'] . "', '" . $registratie['wachtwoord'] . "')";

if ($conn->query($sql) === TRUE) {
    echo "Registratie succesvol";
} else {
    echo "Fout bij registreren: " . $conn->error;
}

$conn->close();

?>