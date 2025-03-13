<?php
session_start();
include '../DB_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo "Je bent niet ingelogd! Log in om te bestellen";
    exit();    
}

$gebruiker_id = $_SESSION['user_id'];

//prijs van product ophalen
function product_prijs($conn, $product_id) {
$prijs_query = "SELECT prijs FROM producten WHERE product_id = ?";
$prijs_stmt = $conn->prepare($prijs_query);
$prijs_stmt->bind_param("i", $product_id);
$prijs_stmt->execute();
$resultaat = $prijs_stmt->get_result();
$product = $resultaat->fetch_assoc();
$prijs_stmt->close();
return (double)$product['prijs'];
}

try {
    foreach ($_POST['product_id'] as $key => $product_id) {
        $aantal = $_POST['aantal'][$key];
        if ($aantal > 0) {
            $prijs = product_prijs($conn, $product_id);
            $totaalprijs = $prijs * $aantal; // rekent de totaalprijs uit

            // voegt de bestelling toe aan de database
            $sql = "INSERT INTO bestellingen (gebruiker_id, product_id, aantal, totaalprijs) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("conn_fout" . $conn->error);
            }
        $stmt->bind_param("iiid", $gebruiker_id, $product_id, $aantal, $totaalprijs);
        if ($stmt->execute()) {
            echo "Bestelling geplaatst voor product_id: $product_id<br>";
        } else {
            throw new Exception("stmt_fout" . $stmt->error);
            }
            $stmt->close();

        }
    }
} catch (Exception $e) {
    error_log($e->getMessage(), 3, "error.log");
    echo "Er is een fout opgetreden bij het plaatsen van de bestelling. probeer het later opnieuw";
} finally {
    $conn->close();
}  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../CSS/style.css">
    <title>Bestellen</title>
</head>
<body>
    <a href="bestellen.php" class="btn btn-primary">Terug naar bestellen</a>
    <a href="../../Index.php" class="btn btn-primary">Terug naar home</a>
</body>
</html>