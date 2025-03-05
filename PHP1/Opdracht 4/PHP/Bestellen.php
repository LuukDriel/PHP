<?php 
session_start();
include 'DB_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo "Je bent niet ingelogd! Log in om te bestellen";
    exit();    
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
</head>
<body class="container">
    <h2>Bestel Producten</h2>
    <form action="verwerk_bestelling.php" method="post">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (isset($row['product_id']) && isset($row['naam'])) {
                echo "<div class='form-group'>";
                echo "<label for='product" . htmlspecialchars($row['product_id']) . "'>" . htmlspecialchars($row['naam']) . "</label>";
                echo "<input type='hidden' name='product_id[]' value='" . htmlspecialchars($row['product_id']) . "'>";
                echo "<input type='number' name='quantity[]' id='product" . htmlspecialchars($row['product_id']) . "' class='form-control' value='0'>";
                echo "</div>";
            } else {
                echo "Product data niet beschikbaar";
            }
        }
    } else {
        echo "Geen producten gevonden";
    }
    ?>
    <button type="submit" class="btn btn-primary">Bestellen</button>
    </form>
</body>
</html>