<?php
session_start();
include_once 'bestellen_klasse.php';
include_once '../DB_Con.php';

$bestellen = new Bestellen($pdo);
$cart = $_SESSION['cart'] ?? array();
$producten = $bestellen->getProducten();

// Product info ophalen per id en totaal via Bestellen-klasse
$cartResult = $bestellen->getCartItems($cart);
$cartItems = $cartResult['items'];
$totaal = $cartResult['totaal'];

// Verwijderen uit winkelwagen
if (isset($_POST['remove_from_cart'])) {
    $removeId = (int)$_POST['remove_id'];
    if(($key = array_search($removeId, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        header('Location: winkelwagen.php');
        exit();
    }
}
// Winkelwagen legen
if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
    header('Location: winkelwagen.php');
    exit();
}
// Afrekenen knop: plaats bestelling in database en leeg winkelwagen
if (isset($_POST['checkout'])) {
    if (!isset($_SESSION['user_id'])) {
        echo '<div class="alert alert-danger text-center mt-5">Je moet ingelogd zijn om af te rekenen.</div>';
        exit();
    }
    if (empty($cart)) {
        echo '<div class="alert alert-warning text-center mt-5">Je winkelwagen is leeg.</div>';
        exit();
    }
    // Zet cart om naar productId => aantal (ondersteunt dubbele producten)
    $productCounts = array();
    foreach ($cart as $productId) {
        if (!isset($productCounts[$productId])) {
            $productCounts[$productId] = 1;
        } else {
            $productCounts[$productId]++;
        }
    }
    try {
        $bestellen->plaatsBestelling($_SESSION['user_id'], $productCounts);
        $_SESSION['cart'] = [];
        echo '<!DOCTYPE html><html lang="nl"><head><meta charset="UTF-8"><meta http-equiv="refresh" content="2;url=../../Index.php"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><title>Afrekenen</title></head><body class="bg-light"><div class="container py-5"><div class="row justify-content-center"><div class="col-lg-8"><div class="alert alert-success text-center p-5 mt-5">Bedankt voor je bestelling!<br>Je wordt doorgestuurd naar de hoofdpagina...</div></div></div></div></body></html>';
        exit();
    } catch (Exception $e) {
        echo '<div class="alert alert-danger text-center mt-5">Fout bij afrekenen: ' . htmlspecialchars($e->getMessage()) . '</div>';
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkelwagen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cart-table th, .cart-table td { vertical-align: middle; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg p-4">
                    <h1 class="mb-4 text-center text-primary">Winkelwagen</h1>
                    <?php if (empty($cartItems)): ?>
                        <div class="alert alert-info text-center">Je winkelwagen is leeg.</div>
                    <?php else: ?>
                        <form method="post">
                            <table class="table cart-table align-middle">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Prijs</th>
                                        <th>Actie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartItems as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                                            <td>€<?php echo number_format($item['price'], 2, ',', '.'); ?></td>
                                            <td>
                                                <form method="post" style="display:inline;">
                                                    <input type="hidden" name="remove_id" value="<?php echo $item['id']; ?>">
                                                    <button type="submit" name="remove_from_cart" class="btn btn-danger btn-sm">Verwijder</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </form>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Totaal: <span class="text-success">€<?php echo number_format($totaal, 2, ',', '.'); ?></span></h4>
                            <form method="post" class="mb-0">
                                <button type="submit" name="clear_cart" class="btn btn-outline-danger">Winkelwagen legen</button>
                            </form>
                        </div>
                        <div class="text-end">
                            <a href="bestellen.php" class="btn btn-secondary">Verder winkelen</a>
                            <form method="post" style="display:inline;">
                                <button type="submit" name="checkout" class="btn btn-success ms-2">Afrekenen</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
