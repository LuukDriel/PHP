<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webwinkel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body class="container">
    <section class="index">
        <div class="buttons">
            <a href="PHP/Registratie/registratie.php" class="button">Registreren</a>
            <a href="PHP/Inlog/inlog.php" class="button">Inloggen</a>
            <a href="PHP/Account/account.php" class="button">Account</a>
            <?php
            session_start();
            if (isset($_SESSION['user_id'])) {
                echo '<a href="PHP/Bestellen.php" class="button">Bestellen</a>';
                echo '<a href="PHP/Review.php" class="button">Review</a>';
            }

            if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
                echo '<a href="PHP/beheer_product.php" class="button">Beheer producten</a>';
            }
            ?>
        </div>
    </section>
</body>
</html>