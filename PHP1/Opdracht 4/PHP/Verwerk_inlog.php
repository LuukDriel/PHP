<?php
session_start();
include("DB_connect.php");

if (password_verify($wachtwoord	, $row["wachtwoord"])) {
    $_SESSION['gebruikers_id'] = $row['id'];
    $_SESSION['gebruikers_naam'] = $row['naam'];
    echo "Inloggen gelukt! Welkom, " . htmlspecialchars($row['naam']);
} else {
    echo "Inloggen mislukt!";
}
?>