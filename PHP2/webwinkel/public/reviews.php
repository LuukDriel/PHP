<?php
require_once '../src/Review.php';
require_once '../src/User.php';
require_once '../src/Product.php';
session_start();

// Voorbeeldreviews (normaal uit database)
$user = new User("Jan Jansen", "jan@webwinkel.nl", "customer");
$product = new Product("T-shirt", 19.95);
$reviews = [
    new Review($user, $product, "Fijn shirt!"),
    new Review($user, $product, "Goede kwaliteit.")
];
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Productreviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Productreviews</h1>
    <?php foreach ($reviews as $review): ?>
        <div class="card mb-3">
            <div class="card-body">
                <?php echo $review->getReview(); ?>
            </div>
        </div>
    <?php endforeach; ?>
    <a href="products.php" class="btn btn-primary">Terug naar producten</a>
</div>
</body>
</html>