<?php
// Uitloggen via Account-klasse (voor consistentie)
session_start();
include_once '../Account/account_klasse.php';
include_once '../DB_Con.php';

if (isset($_SESSION['user_id'])) {
    $account = new Account($pdo);
    // Alleen sessie vernietigen, niet verwijderen
    session_unset();
    session_destroy();
}
header('Location: ../../Index.php?msg=uitgelogd');
exit();
