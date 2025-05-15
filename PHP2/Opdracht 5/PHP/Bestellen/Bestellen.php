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
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4 text-center">Producten</h1>
        <?php if (!empty($message)) echo $message; ?>
        <div class="row g-4">
            <?php foreach ($producten as $product): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text mb-1"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="card-text fw-bold mb-2">€<?php echo number_format($product['price'], 2, ',', '.'); ?></p>
                            <form method="post" class="mt-auto">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-primary w-100">Toevoegen aan winkelwagen</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mt-4 text-center">
            <a href="winkelwagen.php" class="btn btn-success">Naar winkelwagen</a>
            <a href="../../Index.php" class="btn btn-secondary ms-2">Terug naar hoofdpagina</a>
        </div>
    </div>
</body>
</html>
