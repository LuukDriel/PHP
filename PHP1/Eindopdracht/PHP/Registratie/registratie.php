<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body class="container">
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'email_bestaat') {
            echo "<p class='error'>E-mail bestaat al</p>";
        } elseif ($_GET['error'] == 'wachtwoord_komt_niet_overeen') {
            echo "<p class='error'>Wachtwoorden komen niet overeen</p>";
        } elseif ($_GET['error'] == 'wachtwoord_te_kort') {
            echo "<p class='error'>Wachtwoord moet minimaal 8 tekens lang zijn</p>";
        }
    }
    ?>
    <form action="verwerk_registratie.php" method="post" class="container mt-5">
        <div class="form-group">
            <label for="naam">gebruikersnaam:</label>
            <input type="text" class="form-control" name="naam" id="naam" required>
        </div>
        <div class="form-group">
            <label for="adres">Voornaam:</label>
            <input type="text" class="form-control" name="voornaam" id="voornaam" required>
        </div>
        <div class="form-group">
            <label for="adres">Achternaam:</label>
            <input type="text" class="form-control" name="achternaam" id="achternaam" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="wachtwoord">Wachtwoord:</label>
            <input type="password" class="form-control" name="wachtwoord" id="wachtwoord" required>
            <div class="invalid-feedback">
                Wachtwoord moet minimaal 8 tekens lang zijn
            </div>
        </div>
        <div class="form-group">
            <label for="wachtwoord_herhaal">Herhaal wachtwoord:</label>
            <input type="password" class="form-control" name="wachtwoord_herhaal" id="wachtwoord_herhaal" required>
        </div>
        <button type="submit" class="btn btn-primary">Registreer</button>
    </form>
    <a href="Inlog.php" class="btn btn-primary">Inloggen</a>
    <a href="../Index.php" class="btn btn-primary">Terug naar home</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>