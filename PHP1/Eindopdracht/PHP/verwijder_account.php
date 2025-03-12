<?php
session_start();

include 'DB_connect.php';

if (isset($_SESSION['user_id'])) {
    $gebruiker_id = $_SESSION['user_id'];

    // verwijdert de bestellingen van de gebruiker
    $sql_bestellingen = "DELETE FROM bestellingen WHERE gebruiker_id = ?";
    $stmt_bestellingen = $conn->prepare($sql_bestellingen);
    $stmt_bestellingen->bind_param("i", $gebruiker_id);
    $stmt_bestellingen->execute();
    $stmt_bestellingen->close();

    // verwijdert de gebruiker
    $sql_gebruikers = "DELETE FROM gebruikers WHERE gebruiker_id = ?";
    $stmt_gebruikers = $conn->prepare($sql_gebruikers);
    $stmt_gebruikers->bind_param("i", $gebruiker_id);
    $stmt_gebruikers->execute();
    $stmt_gebruikers->close();

    $conn->close();
    session_destroy();
    header("Location: ../Index.php");
} else {
    echo 'U bent niet ingelogd';
    exit();
}
?>