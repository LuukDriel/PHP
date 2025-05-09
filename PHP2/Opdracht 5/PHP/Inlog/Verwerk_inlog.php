<?php
session_start();

include '../User_klasse.php';
include '../DB_connect.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    
    // Controleer als het wachtwoord klopt
    if (User::login($email, $wachtwoord)) {
        $_SESSION['user_id'] = User::getUserId($email);
        header("Location: ../Bestellen/Bestellen.php");
        exit();
    } else {
        header("Location: Inlog.php?error=onjuist_email");
        exit();
    }
}
?>