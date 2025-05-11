<?php
require_once '../src/db.php';
require_once '../src/User.php';
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

// Haal gebruiker uit database
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $_SESSION['user_email']);
$stmt->execute();
$userData = $stmt->fetch();
$user = new User($userData['name'], $userData['email'], $userData['role']);

// Profiel bijwerken
$melding = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $newName = trim($_POST['name']);
    $newEmail = trim($_POST['email']);
    $newPassword = $_POST['password'];

    if (empty($newName) || empty($newEmail)) {
        $melding = '<div class="alert alert-danger">Naam en e-mail mogen niet leeg zijn.</div>';
    } else {
        // Controleer of e-mail al bestaat (behalve voor jezelf)
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email AND id != :id");
        $stmt->bindParam(':email', $newEmail);
        $stmt->bindParam(':id', $userData['id']);
        $stmt->execute();
        if ($stmt->fetch()) {
            $melding = '<div class="alert alert-danger">Dit e-mailadres is al in gebruik.</div>';
        } else {
            if (!empty($newPassword)) {
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id");
                $stmt->bindParam(':password', $hashedPassword);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
            }
            $stmt->bindParam(':name', $newName);
            $stmt->bindParam(':email', $newEmail);
            $stmt->bindParam(':id', $userData['id']);
            $stmt->execute();

            // Update sessie
            $_SESSION['user_email'] = $newEmail;
            $_SESSION['user_name'] = $newName;
            $melding = '<div class="alert alert-success">Profiel succesvol bijgewerkt.</div>';
            // Refresh userData
            $userData['name'] = $newName;
            $userData['email'] = $newEmail;
        }
    }
}

// Haal bestellingen van gebruiker op
$orders = [];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY order_date DESC");
$stmt->bindParam(':user_id', $userData['id']);
$stmt->execute();
while ($order = $stmt->fetch()) {
    // Haal producten per bestelling op
    $stmtProd = $pdo->prepare("SELECT p.name, op.price FROM order_products op JOIN products p ON op.product_id = p.product_id WHERE op.order_id = :order_id");
    $stmtProd->bindParam(':order_id', $order['order_id']);
    $stmtProd->execute();
    $products = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
    $orders[] = [
        'order_date' => $order['order_date'],
        'products' => $products
    ];
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Mijn Account</h1>
    <?php if (!empty($melding)) echo $melding; ?>
    <div class="card mb-4">
        <div class="card-body">
            <form method="post" class="row g-3">
                <div class="col-md-4">
                    <label for="name" class="form-label">Naam:</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($userData['name']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="password" class="form-label">Nieuw wachtwoord (optioneel):</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Laat leeg om niet te wijzigen">
                </div>
                <div class="col-12">
                    <button type="submit" name="update_profile" class="btn btn-primary">Profiel bijwerken</button>
                </div>
            </form>
        </div>
    </div>
    <h2 class="mb-3">Mijn Bestellingen</h2>
    <?php if (empty($orders)): ?>
        <div class="alert alert-info">Je hebt nog geen bestellingen geplaatst.</div>
    <?php else: ?>
        <?php foreach ($orders as $order): ?>
            <div class="card mb-3">
                <div class="card-header">
                    Besteld op: <?php echo htmlspecialchars($order['order_date']); ?>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach ($order['products'] as $product): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($product['name']); ?> - €<?php echo number_format($product['price'], 2); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="index.php" class="btn btn-secondary mt-3">Home</a>
</div>
</body>
</html>