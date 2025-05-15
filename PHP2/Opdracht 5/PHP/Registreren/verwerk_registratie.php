<?php
// Verwerk_registratie.php
require_once 'Registreren_Klasse.php';

// Controleer of het formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Kijk of alles is ingevuld
    if (empty($name) || empty($email) || empty($password)) {
        header('Location: Registreren.php?melding=Vul alle velden in.');
        exit;
    } else {
        // Maak een Registreren-object aan
        $registreren = new Registreren($pdo);
        $melding = $registreren->registerUser($name, $password, $email);
    }
} else {
    $melding = 'Ongeldige aanvraag.';
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registratie resultaat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="alert alert-info">
            <?php echo htmlspecialchars($melding); ?>
        </div>
        <a href="../../Index.php" class="btn btn-secondary">Terug naar home</a>
        <a href="../Inloggen/Inloggen.php" class="btn btn-primary">Naar inloggen</a>
    </div>
</body>
</html>
