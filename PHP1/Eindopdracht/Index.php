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
            <a href="PHP/Registratie.php" class="button">Registreren</a>
            <a href="PHP/Inlog.php" class="button">Inloggen</a>
            <a href="PHP/account.php" class="button">Account</a>
            <?php
            session_start();
            if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
                echo '<a href="PHP/beheer_product.php" class="button">Beheer producten</a>';
            }
            ?>
        </div>
    </section>
</body>
</html>