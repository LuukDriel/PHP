<?php
session_start();

include 'DB_connect.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    
    $sql = "SELECT gebruiker_id, gebruikersnaam, wachtwoord FROM gebruikers WHERE email= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $gebruikersnaam, $wachtwoord_hash);
        $stmt->fetch();
        
        if (password_verify($wachtwoord, $wachtwoord_hash)) {
            echo "<p class='success'>Inloggen succesvol Welkom, " . $gebruikersnaam . "</p>";
            $_SESSION['gebruiker_id'] = $id;
            $_SESSION['gebruiker_naam'] = $gebruikersnaam;
        } else {
            echo "<p class='error'>Wachtwoord is onjuist</p>";
        }
    } else {
        echo "<p class='error'>E-mail bestaat niet</p>";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlog</title>
    <link rel="stylesheet" href="../CSS/style.CSS">
</head>
<body>
    
</body>
</html>