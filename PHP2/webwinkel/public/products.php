<?php
require_once '../src/db.php';
require_once '../src/Product.php';
session_start();

// Haal producten uit de database
$products = [];
$stmt = $pdo->query("SELECT * FROM products");
while ($row = $stmt->fetch()) {
    $products[] = [
        'id' => $row['product_id'],
        'name' => $row['name'],
        'price' => $row['price'],
        'stock_quantity' => $row['stock_quantity']
    ];
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Producten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Producten</h1>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                        <p class="card-text">Prijs: €<?php echo number_format($product['price'], 2); ?></p>
                        <p class="card-text">Voorraad: <?php echo (int)$product['stock_quantity']; ?></p>
                        <form method="post" action="cart.php">
                            <input type="hidden" name="productName" value="<?php echo htmlspecialchars($product['name']); ?>">
                            <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                            <button type="submit" class="btn btn-primary" <?php if ($product['stock_quantity'] <= 0) echo 'disabled'; ?>>
                                Toevoegen aan winkelwagen
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="cart.php" class="btn btn-success mt-3 me-2">Naar winkelwagen</a>
    <a href="index.php" class="btn btn-secondary mt-3">Home</a>
</div>
</body>
</html>