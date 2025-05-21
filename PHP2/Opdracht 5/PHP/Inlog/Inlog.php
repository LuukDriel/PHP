<?php
$error = '';
if (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; }
        .login-card { max-width: 400px; margin: 0 auto; }
        .login-links a { display: block; margin-top: 8px; }
    </style>
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-lg p-4 login-card mt-5">
                    <h2 class="mb-4 text-center text-primary">Inloggen</h2>
                    <?php if ($error): ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <form action="verwerk_inlog.php" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Gebruikersnaam</label>
                            <input type="text" class="form-control" id="name" name="name" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Wachtwoord</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Inloggen</button>
                    </form>
                    <div class="login-links text-center mt-4">
                        <a href="../../Index.php" class="btn btn-link">Terug naar hoofdpagina</a>
                        <a href="../Registreren/registreren.php" class="btn btn-link">Nog geen account? Registreer hier.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>