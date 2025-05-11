<?php
require_once '../src/db.php';
require_once '../src/User.php';

session_start();

$requestUri = $_SERVER['REQUEST_URI'];

if ($requestUri === '/login.php') {
    require 'login.php';
} elseif ($requestUri === '/register.php') {
    require 'register.php';
} elseif ($requestUri === '/products.php') {
    require 'products.php';
} elseif ($requestUri === '/cart.php') {
    require 'cart.php';
} elseif ($requestUri === '/order.php') {
    require 'order.php';
} elseif ($requestUri === '/account.php') {
    require 'account.php';
} elseif ($requestUri === '/admin_products.php') {
    require 'admin_products.php';
} elseif ($requestUri === '/reviews.php') {
    require 'reviews.php';
} else {
    $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    ?>
    <!DOCTYPE html>
    <html lang="nl">
    <head>
        <meta charset="UTF-8">
        <title>Webwinkel Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="card shadow">
                        <div class="card-body">
                            <h1 class="card-title mb-4">Welkom bij de Webwinkel!</h1>
                            <p class="mb-4">Log in, registreer of bekijk onze producten.</p>
                            <a href="login.php" class="btn btn-primary me-2">Login</a>
                            <a href="register.php" class="btn btn-success me-2">Register</a>
                            <a href="products.php" class="btn btn-outline-secondary me-2">Producten</a>
                            <a href="cart.php" class="btn btn-outline-primary me-2">Winkelwagen</a>
                            <a href="account.php" class="btn btn-outline-dark me-2">Account</a>
                            <a href="reviews.php" class="btn btn-outline-info me-2">Reviews</a>
                            <?php if ($isAdmin): ?>
                                <a href="admin_products.php" class="btn btn-warning">Productbeheer</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
}
?>