<?php 
session_start();
include '../DB_connect.php';

// controleert als de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    echo "Je bent niet ingelogd! Log in om te bestellen";
    exit();    
}

// haalt alle producten op
try {
    $sql = "SELECT * FROM producten";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    echo "Er is een fout opgetreden bij het ophalen van de producten: " . htmlspecialchars($e->getMessage());
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestellen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../CSS/style.css">
</head>

<body class="container">
    <h2>Bestel Producten</h2>
    <form action="verwerk_bestelling.php" method="post">
    <div class="row">
    <?php
    // toont alle producten
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (isset($row['product_id']) && isset($row['naam']) && isset($row['prijs']) && isset($row['beschrijving'])) {
                echo "
                <div class='col-md-4'>
                    <div class='card mb-4'>
                        <div class='card-body'>
                            <h5 class='card-title'>" . htmlspecialchars($row['naam']) . "</h5>
                            <p class='card-text'>" . htmlspecialchars($row['beschrijving']) . "</p>
                            <p class='card-text'>€ " . htmlspecialchars($row['prijs']) . "</p>
                            <input type='hidden' name='product_id[]' value='" . htmlspecialchars($row['product_id']) . "'>
                            <div class='form-group'>
                                <label for='product" . htmlspecialchars($row['product_id']) . "'>Aantal</label>
                                <input type='number' name='aantal[]' id='product" . htmlspecialchars($row['product_id']) . "' class='form-control' value='0' min='0'>
                            </div>
                        </div>
                    </div>
                </div>";
            } else {
                echo "<div class='col-md-12'>Product data niet beschikbaar</div>";
            }
        }
    } else {
        echo "<div class='col-md-12'>Geen producten gevonden</div>";
    }
    ?>
    </div>
    <button type="submit" class="btn btn-primary" id="bestel-knop">Bestellen</button>
    </form>
</body>
</html>