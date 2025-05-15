<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoofdpagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container text-center mt-5">
        <h1 class="mb-4">Welkom op de Hoofdpagina</h1>
        <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
            <a href="PHP/Registreren/Registreren.php" class="btn btn-primary btn-lg">Registreren</a>
            <a href="PHP/Inlog/inlog.php" class="btn btn-success btn-lg">Inloggen</a>
            <a href="PHP/Account/account.php" class="btn btn-danger btn-lg">Mijn Account</a>
            <a href="PHP/Bestellen/bestellen.php" class="btn btn-warning btn-lg">Bestellen</a>
            <a href="PHP/Review/review.php" class="btn btn-info btn-lg">Reviews</a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="PHP/Producten_admin/product_beheer.php" class="btn btn-dark btn-lg">Productbeheer</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>