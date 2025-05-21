<?php
session_start();
include_once 'bestellen_klasse.php';
include_once '../DB_Con.php';

$bestellen = new Bestellen($pdo);
$producten = $bestellen->getProducten();

// Winkelwagen toevoegen
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (isset($_POST['add_to_cart'])) {
    $productId = (int)$_POST['product_id'];
    $bestellen->addToCart($productId);
    $message = '<div class="alert alert-success text-center">Product toegevoegd aan winkelwagen!</div>';
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; }
        .product-card { min-height: 350px; }
        .product-title { min-height: 3rem; }
        .cart-btn { font-size: 1.1rem; font-weight: 500; }
        .winkelwagen-btn { font-size: 1.2rem; font-weight: 600; padding: 0.75rem 2.5rem; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8">
                <div class="card shadow-lg p-4">
                    <h1 class="mb-4 text-center text-primary">Producten</h1>
                    <?php if (!empty($message)) echo $message; ?>
                    <div class="row g-4">
                        <?php foreach ($producten as $product): ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card h-100 shadow-sm product-card">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title product-title text-center text-dark fw-bold"><?php echo htmlspecialchars($product['name']); ?></h5>
                                        <p class="card-text mb-1 text-secondary text-center"><?php echo htmlspecialchars($product['description']); ?></p>
                                        <p class="card-text fw-bold mb-2 text-center text-success" style="font-size:1.2rem;">€<?php echo number_format($product['price'], 2, ',', '.'); ?></p>
                                        <form method="post" class="mt-auto">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" name="add_to_cart" class="btn btn-primary w-100 cart-btn">Toevoegen aan winkelwagen</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-5 text-center">
                        <a href="winkelwagen.php" class="btn btn-success winkelwagen-btn me-2"><i class="bi bi-cart"></i> Naar winkelwagen</a>
                        <a href="../../Index.php" class="btn btn-secondary winkelwagen-btn">Terug naar hoofdpagina</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</body>
</html>
