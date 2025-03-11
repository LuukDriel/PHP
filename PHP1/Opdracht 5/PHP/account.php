<?php

session_start();

// controleren of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    echo 'U bent niet ingelogd';
    exit();
}

include 'DB_connect.php';

$gebruiker_id = $_SESSION['user_id']; // haal de gebruiker_id uit de sessie
$sql = "SELECT * FROM gebruikers WHERE gebruiker_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $gebruiker_id);
$stmt->execute();
$result = $stmt->get_result();
$gebruiker = $result->fetch_assoc();
$stmt->close();

if ($result->num_rows == 0) {
    echo 'Gebruiker niet gevonden';
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body classs="container">
    <h1>Account</h1>
    <p>Welkom, <?php echo $gebruiker['gebruikersnaam']; ?></p>
    <p>Voornaam: <?php echo $gebruiker['voornaam']; ?></p>
    <p>Achternaam: <?php echo $gebruiker['achternaam']; ?></p>
    <p>Email: <?php echo $gebruiker['email']; ?></p>
    <a href="uitloggen.php" class="button">Uitloggen</a>
    
</body>
</html>