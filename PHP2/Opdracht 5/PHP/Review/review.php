<?php
session_start();
include_once 'review_klasse.php';
include_once '../DB_Con.php';

$review = new Review($pdo);
$message = '';

// Voor algemene website reviews gebruiken we product_id = NULL
$productId = null;

// Review plaatsen
if (isset($_POST['add_review']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $rating = (int)$_POST['rating'];
    $comment = trim($_POST['comment']);
    if ($rating >= 1 && $rating <= 5 && $comment !== '') {
        if ($review->add($userId, $rating, $comment)) {
            $message = '<div class="alert alert-success">Review geplaatst!</div>';
        } else {
            $message = '<div class="alert alert-danger">Fout bij plaatsen van review.</div>';
        }
    } else {
        $message = '<div class="alert alert-warning">Vul een beoordeling (1-5) en een opmerking in.</div>';
    }
}

// Haal alle algemene website reviews op
$stmt = $pdo->prepare("SELECT r.*, u.name as user_name FROM reviews r JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC");
$stmt->execute();
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4 text-center">Reviews over de website</h1>
    <?php if ($message) echo $message; ?>
    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="card mb-4 mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <h5 class="card-title">Plaats een review</h5>
            <form method="post">
                <div class="mb-3">
                    <label for="rating" class="form-label">Beoordeling (1-5):</label>
                    <select name="rating" id="rating" class="form-select" required>
                        <option value="">Kies...</option>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Opmerking:</label>
                    <textarea name="comment" id="comment" class="form-control" required></textarea>
                </div>
                <button type="submit" name="add_review" class="btn btn-primary">Review plaatsen</button>
            </form>
        </div>
    </div>
    <?php else: ?>
        <div class="alert alert-info text-center">Log in om een review te plaatsen.</div>
    <?php endif; ?>

    <h4 class="mb-3">Alle website reviews</h4>
    <?php if ($reviews): ?>
        <?php foreach ($reviews as $r): ?>
            <div class="card mb-2 mx-auto" style="max-width: 500px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong><?php echo htmlspecialchars($r['user_name']); ?></strong>
                        <span class="badge bg-warning text-dark">Beoordeling: <?php echo isset($r['beoordeling']) ? $r['beoordeling'] : '-'; ?>/5</span>
                    </div>
                    <p class="mb-1"><?php echo nl2br(htmlspecialchars(isset($r['tekst']) ? $r['tekst'] : '')); ?></p>
                    <small class="text-muted">Geplaatst op: <?php echo $r['created_at']; ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info">Nog geen reviews voor deze website.</div>
    <?php endif; ?>
    <div class="mt-4 text-center">
        <a href="../../Index.php" class="btn btn-secondary">Terug naar hoofdpagina</a>
    </div>
</div>
</body>
</html>
