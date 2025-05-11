<?php
require_once '../src/db.php';
require_once '../src/User.php';

$melding = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = 'customer';
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $melding = '<div class="alert alert-danger text-center">Vul alle velden in.</div>';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->fetch()) {
            $melding = '<div class="alert alert-danger text-center">Dit e-mailadres is al geregistreerd.</div>';
        } else {
            $user = new User($name, $email, $role, $password);
            try {
                if ($user->register($pdo)) {
                    $melding = '<div class="alert alert-success text-center">Registratie succesvol! Je kunt nu <a href="login.php">inloggen</a>.</div>';
                } else {
                    $melding = '<div class="alert alert-danger text-center">Registratie mislukt. Probeer het opnieuw.</div>';
                }
            } catch (PDOException $e) {
                $melding = '<div class="alert alert-danger text-center">Database fout: ' . htmlspecialchars($e->getMessage()) . '</div>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="card-title mb-4 text-center">Registreren</h1>
                        <?php if (!empty($melding)) echo $melding; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="name" class="form-label">Naam:</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Wachtwoord:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Registreren</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="login.php">Al een account? Inloggen</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>