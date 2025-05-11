<?php
require_once '../src/Product.php';
require_once '../src/Cart.php';
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = new Cart();
}

// Product toevoegen aan winkelwagen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productName'], $_POST['price'])) {
    $product = new Product($_POST['productName'], floatval($_POST['price']));
    $_SESSION['cart']->addProduct($product);
}

$cart = $_SESSION['cart'];
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Winkelwagen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <h1 class="card-title mb-4 text-center">🛒 Mijn Winkelwagen</h1>
                    <?php if (empty($cart->getProducts())): ?>
                        <div class="alert alert-info text-center">Je winkelwagen is leeg.</div>
                    <?php else: ?>
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Prijs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart->getProducts() as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product->getProductName()); ?></td>
                                        <td>€<?php echo number_format($product->getPrice(), 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="text-end mb-3">
                            <strong>Totaal: €<?php echo number_format($cart->getTotalPrice(), 2); ?></strong>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between">
                        <a href="products.php" class="btn btn-secondary">Verder winkelen</a>
                        <a href="order.php" class="btn btn-success<?php if (empty($cart->products)) echo ' disabled'; ?>">Bestelling plaatsen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>