<?php 

session_start();

if (!isset($_SESSION['user_id'])) {
    echo 'U bent niet ingelogd';
    exit();
}

include '../DB_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../CSS/style.css">
</head>
<body class="container mt-5">
    <h1 class="text-center mb-4">Laat een review achter</h1>
    <form action="verwerk_review.php" method="post" class="container mt-5">
        <div class="form-group mb-3">
            <label for="rating" class="form-label">Rating</label>
            <input type="number" class="form-control" id="rating" name="rating" required min="1" max="5">
        </div>
        <div class="form-group mb-3">
            <label for="review" class="form-label">Review</label>
            <textarea name="review" id="review" class="form-control" cols="30" rows="10" required></textarea>
        </div>
        <div class="text-center">
            <input type="submit" value="Verstuur" class="btn btn-primary">
        </div>
    </form>
    <a href="../../Index.php" class="btn btn-primary">Terug naar home</a>

    <h2 class="text-center mt-5">Alle reviews</h2>
    <?php
    $sql = "SELECT reviews.rating, reviews.review_text, gebruikers.gebruikersnaam 
            FROM reviews 
            JOIN gebruikers ON reviews.gebruiker_id = gebruikers.gebruiker_id";
    $result = $conn->query($sql);
    if ($result === false) {
        echo "<p>Er is een fout opgetreden bij het ophalen van de reviews.</p>";
    } elseif ($result->num_rows == 0) {
        echo "<p>Er zijn nog geen reviews</p>";
    } else {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card mt-3'>
                    <div class='card-body'>
                        <h5 class='card-title'>Rating: " . htmlspecialchars($row['rating']) . "</h5>
                        <h6 class='card-subtitle mb-2 text-muted'>Gebruiker: " . htmlspecialchars($row['gebruikersnaam']) . "</h6>
                        <p class='card-text'>" . htmlspecialchars($row['review_text']) . "</p>
                    </div>
                </div>";
        }
    }
    $conn->close();
    ?>
</body>
</html>