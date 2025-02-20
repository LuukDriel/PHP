<?php

include 'DB_conenect.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    $sql = "SELECT * FROM gebruikers WHERE email= $email";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $naam, $email, $wachtwoord_hash);
        $stmt->fetch();
        if (password_verify($wachtwoord, $wachtwoord_hash)) {
            echo "Welkom " . $naam;
        } else {
            echo "Wachtwoord is onjuist";
        }
    } else {
        echo "E-mail bestaat niet";
    }
    $stmt->close();
    $conn->close();

}
?>
