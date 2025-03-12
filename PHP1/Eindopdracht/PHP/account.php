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
<body class="container">
    <h1>Account</h1>
    <form action="update_account.php" method="post">
        <div class="form-group">
            <label>Gebruikersnaam</label>
            <input type="text" name="gebruikersnaam" class="form-control" value="<?php echo $gebruiker['gebruikersnaam']; ?>">
        </div>
        <div class="form-group">
            <label>Voornaam</label>
            <input type="text" name="voornaam" class="form-control" value="<?php echo $gebruiker['voornaam']; ?>">
        </div>
        <div class="form-group">
            <label>Achternaam</label>
            <input type="text" name="achternaam" class="form-control" value="<?php echo $gebruiker['achternaam']; ?>">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $gebruiker['email']; ?>">
        <div class="form-group">
            <label>Wachtwoord</label>
            <input type="password" name="wachtwoord" class="form-control">
        </div>
        <div class="form-group">
            <label>Herhaal wachtwoord</label>
            <input type="password" name="wachtwoord_herhaal" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Opslaan</button>
    <form>
    <a href="uitloggen.php" class="btn btn-primary">Uitloggen</a>
    <a href="verwijder_account.php" class="btn btn-danger">Verwijder account</a>
    <a href="../Index.php" class="btn btn-primary">Terug</a>

    <h2 id="bestelling">Mijn bestellingen</h2>
    <?php
    $sql_bestellingen = "SELECT * FROM bestellingen JOIN producten ON bestellingen.product_id = producten.product_id WHERE gebruiker_id = ?";
    $stmt_bestellingen = $conn->prepare($sql_bestellingen);
    $stmt_bestellingen->bind_param("i", $gebruiker_id);
    $stmt_bestellingen->execute();
    $result_bestellingen = $stmt_bestellingen->get_result();
    if ($result_bestellingen->num_rows == 0) {
        echo 'U heeft nog geen bestellingen geplaatst';
    } else {
        echo '<table class="table">';
        echo '<tr><th>Product</th><th>Prijs</th><th>Datum</th></tr>';
        while ($bestelling = $result_bestellingen->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $bestelling['naam'] . '</td>';
            echo '<td>' . $bestelling['prijs'] . '</td>';
            echo '<td>' . $bestelling['besteldatum'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    $stmt_bestellingen->close();
    $conn->close();
    ?>
</body>
</html>