<?php
require_once '../src/db.php';
require_once '../src/Product.php';
require_once '../src/Cart.php';
require_once '../src/Order.php';
require_once '../src/User.php';
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

// Haal gebruiker uit database
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $_SESSION['user_email']);
$stmt->execute();
$userData = $stmt->fetch();
$user = new User($userData['name'], $userData['email'], $userData['role']);

// Haal cart uit sessie
$cart = $_SESSION['cart'] ?? new Cart();
$order = new Order($user);

// Order opslaan in de database
if (!empty($cart->products)) {
    // Voeg order toe aan orders-tabel met user_id
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, order_date) VALUES (:user_id, NOW())");
    $stmt->bindParam(':user_id', $userData['id']);
    $stmt->execute();
    $orderId = $pdo->lastInsertId();

    // Voeg producten toe aan order_products-tabel
    foreach ($cart->products as $product) {
        $order->addProduct($product);

        // Haal product_id op uit de database
        $stmtProd = $pdo->prepare("SELECT product_id FROM products WHERE name = :name LIMIT 1");
        $stmtProd->bindParam(':name', $product->getProductName());
        $stmtProd->execute();
        $prodRow = $stmtProd->fetch();
        $productId = $prodRow ? $prodRow['product_id'] : null;

        if ($productId) {
            $stmtOrderProd = $pdo->prepare("INSERT INTO order_products (order_id, product_id, price) VALUES (:order_id, :product_id, :price)");
            $stmtOrderProd->bindParam(':order_id', $orderId);
            $stmtOrderProd->bindParam(':product_id', $productId);
            $stmtOrderProd->bindParam(':price', $product->getPrice());
            $stmtOrderProd->execute();

            // Voorraad verminderen
            $stmtUpdate = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - 1 WHERE product_id = :product_id AND stock_quantity > 0");
            $stmtUpdate->bindParam(':product_id', $productId);
            $stmtUpdate->execute();
        }
    }
}

// Leeg de winkelwagen na bestelling
unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bestelling geplaatst</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Bestelling geplaatst!</h1>
    <?php echo $order->getOrderDetails(); ?>
    <a href="index.php" class="btn btn-secondary mt-3 me-2">Home</a>
    <a href="products.php" class="btn btn-primary mt-3">Verder winkelen</a>
</div>
</body>
</html>