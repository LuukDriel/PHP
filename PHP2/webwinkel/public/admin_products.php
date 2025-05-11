<?php
require_once '../src/db.php';
require_once '../src/Product.php';
require_once '../src/User.php';
session_start();

// Controleer of de gebruiker admin is
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo "Geen toegang.";
    exit;
}

// Product toevoegen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['name'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $stock_quantity = intval($_POST['stock_quantity'] ?? 0);
    if ($name && $price > 0 && $stock_quantity >= 0) {
        $stmt = $pdo->prepare("INSERT INTO products (name, price, stock_quantity) VALUES (:name, :price, :stock_quantity)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock_quantity', $stock_quantity);
        $stmt->execute();
    }
    header("Location: admin_products.php");
    exit;
}

// Product verwijderen
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header("Location: admin_products.php");
    exit;
}

// Product bewerken
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $id = intval($_POST['product_id']);
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $stock_quantity = intval($_POST['stock_quantity']);
    $stmt = $pdo->prepare("UPDATE products SET name = :name, price = :price, stock_quantity = :stock_quantity WHERE product_id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':stock_quantity', $stock_quantity);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header("Location: admin_products.php");
    exit;
}

// Haal producten uit de database
$products = [];
$stmt = $pdo->query("SELECT * FROM products");
while ($row = $stmt->fetch()) {
    $products[] = [
        'id' => $row['product_id'],
        'name' => $row['name'],
        'price' => $row['price'],
        'stock_quantity' => $row['stock_quantity']
    ];
}

// Voor bewerken: haal product op
$editProduct = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $pdo->prepare("SELECT * FROM products WHERE product_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $editProduct = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Productbeheer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">Productbeheer</h1>

    <!-- Product toevoegen -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Product toevoegen</h5>
            <form method="post" class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Productnaam" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="Prijs" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="stock_quantity" class="form-control" placeholder="Aantal op voorraad" min="0" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="add_product" class="btn btn-success w-100">Toevoegen</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Product bewerken -->
    <?php if ($editProduct): ?>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Product bewerken</h5>
            <form method="post" class="row g-2">
                <input type="hidden" name="product_id" value="<?php echo $editProduct['product_id']; ?>">
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($editProduct['name']); ?>" required>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($editProduct['price']); ?>" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="stock_quantity" class="form-control" value="<?php echo htmlspecialchars($editProduct['stock_quantity']); ?>" min="0" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="edit_product" class="btn btn-warning w-100">Opslaan</button>
                </div>
                <div class="col-md-2 mt-2">
                    <a href="admin_products.php" class="btn btn-secondary w-100">Annuleren</a>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Producten tabel -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Productnaam</th>
                <th>Prijs</th>
                <th>Voorraad</th>
                <th style="width: 180px;">Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td>€<?php echo number_format($product['price'], 2); ?></td>
                <td><?php echo (int)$product['stock_quantity']; ?></td>
                <td>
                    <a href="admin_products.php?edit=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">Bewerken</a>
                    <a href="admin_products.php?delete=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">Verwijderen</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="products.php" class="btn btn-primary">Terug naar producten</a>
</div>
</body>
</html>