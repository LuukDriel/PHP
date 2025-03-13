<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../CSS/style.css">
</head>
<body class="container">
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'onjuist_email') {
            echo "<p class='error'>E-mail bestaat niet</p>";
        } elseif ($_GET['error'] == 'onjuist_wachtwoord') {
            echo "<p class='error'>Wachtwoord is onjuist</p>";
        } elseif ($_GET['error'] == 'niet_ingelogt') {
            echo "<p class='error'>Je moet ingelogt zijn</p>";
        }
    }
    ?>
    <form action="verwerk_inlog.php" method="post" class="container mt-5">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="wachtwoord">Wachtwoord</label>
            <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
        </div>
        <button type="submit" class="btn btn-primary">Inloggen</button>
    </form>
    <a href="../../Index.php" class="btn btn-primary">Terug naar home</a>
    <a href="../Registratie/registratie.php" class="btn btn-primary">Registreren</a>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>