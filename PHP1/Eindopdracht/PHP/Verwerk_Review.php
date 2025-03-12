<?php
session_start();

include 'DB_connect.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $gebruiker_id = $_SESSION['user_id'];

    try {
        $sql = "INSERT INTO reviews (rating, review_text, gebruiker_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param("isi", $rating, $review, $gebruiker_id);
        if ($stmt->execute() === false) {
            throw new Exception('Execute failed: ' . $stmt->error);
        }

        $stmt->close();
        $conn->close();
        
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo "Er is een fout opgetreden tijdens het verwerken van uw review. Probeer het later opnieuw.";
    }
}

header("Location: Review.php");

?>