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
    <title>Registreren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; }
        .register-card { max-width: 400px; margin: 0 auto; }
        .register-links a { display: block; margin-top: 8px; }
    </style>
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-lg p-4 register-card mt-5">
                    <h2 class="mb-4 text-center text-primary">Registreren</h2>
                    <?php if ($error): ?>
                        <div class="alert alert-danger text-center" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    <form action="Verwerk_registratie.php" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Naam</label>
                            <input type="text" class="form-control" id="name" name="name" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Wachtwoord</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Registreren</button>
                    </form>
                    <div class="register-links text-center mt-4">
                        <a href="../../Index.php" class="btn btn-link">Terug naar hoofdpagina</a>
                        <a href="../Inlog/inlog.php" class="btn btn-link">Al geregistreerd? Log hier in.</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>