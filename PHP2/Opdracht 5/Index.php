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
    <style>
        body { min-height: 100vh; }
        .main-card { max-width: 700px; margin: 0 auto; }
        .btn-lg { min-width: 180px; }
    </style>
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="card shadow-lg p-4 main-card mt-5">
                    <h1 class="mb-4 text-center text-primary">Welkom op de Hoofdpagina</h1>
                    <div class="d-flex flex-column flex-md-row flex-wrap justify-content-center gap-3 mb-4">
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
            </div>
        </div>
    </div>
</body>
</html>