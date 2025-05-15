<?php
$error = '';
if (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Inlog</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Inloggen</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form action="verwerk_inlog.php" method="POST" class="card p-4 shadow-sm mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="name" class="form-label">Gebruikersnaam</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Wachtwoord</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Inloggen</button>
            <div class="mt-3 text-center"></div>
            <a href="../../Index.php">Terug naar hoofdpagina.<br></a>
            <a href="../Registreren/Registreren.php">Nog geen account? Registreer hier.</a>
        </div>
    </div>
        </form>
</body>
</html>