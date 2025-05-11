<?php
session_start();
require_once '../src/db.php';
require_once '../src/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Haal gebruiker op uit database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $userData = $stmt->fetch();

    if ($userData && password_verify($password, $userData['password'])) {
        $_SESSION['user_email'] = $userData['email'];
        $_SESSION['user_name'] = $userData['name'];
        $_SESSION['user_role'] = $userData['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Inloggen mislukt. Controleer je e-mailadres en wachtwoord.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="card-title mb-4 text-center">Inloggen</h1>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mailadres:</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Wachtwoord:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Inloggen</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="register.php">Geen account? Registreer hier</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>