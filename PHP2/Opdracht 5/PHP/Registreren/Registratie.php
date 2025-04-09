<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body class="container">
    <section class="message">
        <?php 
        if (isset($_GET['email']) && $_GET['email'] == 'bestaat') {
            echo "<div class='alert alert-danger messages'>E-mail bestaat al</div>";
        }

        if (isset($_GET['wachtwoord']) && $_GET['wachtwoord'] == 'verschil') {
            echo "<div class='alert alert-danger'>Wachtwoorden komen niet overeen</div>";
        }
        
        ?>
    <form action="Registratie_verwerk.php" method="post" class="container mt-5">
        <div class="form-group">
            <label for="naam">gebruikersnaam:</label>
            <input type="text" class="form-control" name="naam" id="naam" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="wachtwoord">Wachtwoord:</label>
            <input type="password" class="form-control" name="wachtwoord" id="wachtwoord" required>
        </div>
        <div class="form-group">
            <label for="wachtwoord_herhaal">Herhaal wachtwoord:</label>
            <input type="password" class="form-control" name="wachtwoord_herhaal" id="wachtwoord_herhaal" required>
        </div>
        <button type="submit" class="btn btn-primary">Registreer</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>