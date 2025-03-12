<?php

session_start();

include 'DB_connect.php';

// Check als beheerer is ingelogt
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Update voorraad
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $product_id = $_POST['product_id'];
    $product_naam = $_POST['product_naam'];
    $product_aantal = $_POST['product_voorraad'];
    $product_prijs = $_POST['product_prijs'];

    $sql = "UPDATE producten SET naam='$product_naam', voorraad='$product_aantal', prijs='$product_prijs' WHERE product_id='$product_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Voorraad bijgewerkt";
    } else {
        echo "Fout bij bijwerken: " . $conn->error;
    }
}

// Verwijdert voorraad
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verwijder'])) {
    $product_id = $_POST['product_id'];

    $sql = "DELETE FROM producten WHERE product_id='$product_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Product verwijderd";
    } else {
        echo "Fout bij verwijderen: " . $conn->error;
    }
}

// Voeg nieuw product toe
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['toevoegen'])) {
    $product_naam = $_POST['product_naam'];
    $product_aantal = $_POST['product_voorraad'];
    $product_prijs = $_POST['product_prijs'];
    $product_categorie = $_POST['product_categorie'];
    $product_bescrijving = $_POST['product_bescrijving'];

    $sql = "INSERT INTO producten (naam, voorraad, prijs, categorie, beschrijving) VALUES ('$product_naam', '$product_aantal', '$product_prijs', '$product_categorie', '$product_bescrijving')";
    if ($conn->query($sql) === TRUE) {
        echo "Nieuw product toegevoegd";
    } else {
        echo "Fout bij toevoegen: " . $conn->error;
    }
}

// Haalt voorraad op
$sql = "SELECT * FROM producten";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beheer producten</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body class="container">
    <h1>Beheer producten</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Voorraad</th>
            <th>Prijs</th>
            <th>Actie</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <form method='POST'>
                        <td>{$row['product_id']}<input type='hidden' name='product_id' value='{$row['product_id']}'></td>
                        <td><input type='text' name='product_naam' value='{$row['naam']}'></td>
                        <td><input type='number' name='product_voorraad' value='{$row['voorraad']}'></td>
                        <td><input type='number' step='0.01' name='product_prijs' value='{$row['prijs']}'></td>
                        <td><input type='submit' name='update' value='Update'>
                        <input type='submit' name='verwijder' value='Verwijder'></td>
                        </form>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Geen producten gevonden</td></tr>";
        }
        ?>
        <tr>
            <form method='POST'>
                <td>Nieuw</td>
                <td><input type='text' name='product_naam' placeholder='Naam'></td>
                <td><input type='number' name='product_voorraad' placeholder='Voorraad'></td>
                <td><input type='number' step='0.01' name='product_prijs' placeholder='Prijs'></td>
                <td><input type="text" name='product_categorie' placeholder="Categorie"></td>
                <td><input type="text" name='product_bescrijving' placeholder='Bescrijving'></td>
                <td colspan='2'><input type='submit' name='toevoegen' value='Toevoegen'></td>
            </form>
        </tr>
    </table>
    <a href="../index.php" class="btn btn-primary">Home</a> 
</body>
</html>

<?php
$conn->close();
?>