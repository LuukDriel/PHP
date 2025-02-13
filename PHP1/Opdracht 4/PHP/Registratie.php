<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <form action="Registratie_verwerk.php" method="post" class="container mt-5">
        <div class="form-group">
            <label for="naam">naam:</label>
            <input type="text" class="form-control" name="naam" id="naam" required>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>