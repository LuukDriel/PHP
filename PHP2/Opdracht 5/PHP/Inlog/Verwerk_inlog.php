<?php
include_once 'inlog_klasse.php';
include_once '../DB_Con.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';

    $inlog = new Inlog($pdo);
    if ($inlog->login($name, $password)) {
        header('Location: ../../Index.php');
        exit();
    } else {
        $error = 'Ongeldige gebruikersnaam of wachtwoord.';
        header('Location: Inlog.php?error=' . urlencode($error));
        exit();
    }
} else {
    header('Location: Inlog.php');
    exit();
}
?>
