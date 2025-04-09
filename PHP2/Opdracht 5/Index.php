<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webwinkel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body class="container">
    <section class="messages mt-3">
        <?php 
        if (isset($_GET['registratie']) && $_GET['registratie'] == 'succes') {
            echo "<div class='alert alert-success'>Registratie succesvol!</div>";
        }
        if (isset($_GET['registratie']) && $_GET['registratie'] == 'error') {
            echo "<div class='alert alert-danger'>Registratie mislukt. Probeer later opnieuw.</div>";
        }
        ?>
    </section>
    <section class="index">
        <div class="buttons">
            <a href="PHP/Registreren/Registratie.php" class="button">Registreren</a>
            <a href="PHP/Inlog.php" class="button">Inloggen</a>
            <a href="PHP/account.php" class="button">Account</a>
        </div>
    </section>
</body>
</html>