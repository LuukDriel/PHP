<?php

// pdo configuratie
try {
    $pdo = new PDO('mysql:host=localhost;dbname=winkel', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Databasefout: " . $e->getMessage() . "<br>");
} catch (Exception $e) {
    die("Fout: " . $e->getMessage() . "<br>");
}

?>