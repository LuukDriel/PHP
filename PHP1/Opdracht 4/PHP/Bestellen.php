<?php
session_start();
include("DB_connect.php");

if (!isset($_SESSION['gebruikers_id'])) {
    echo "Je moet ingelogt zijn om een bestelling te plaatsen";
    exit;
}

$sql = "SELECT * FROM producten";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="container">
    <h2>Bestel producten</h2>
    <form action="Verwerk_bestelling.php" method="post">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='from-group'>";
                echo "<label>" . htmlspecialchars($row['naam']) . " - €" . htmlspecialchars($row['prijs']) . "</label>";
                echo "<input type='number' class=form-control name='product_" . $row['id'] . "' value='0' min='0'>";
                echo "</div>";
            }
        } else {
            echo "Geen producten gevonden";
        }
        ?>
        <button type="submit" class="btn btn-primary">Bestelling Plaatsen</button>
    </form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>