<?php
session_start();
include_once 'product_beheer_klasse.php';
include_once '../DB_Con.php';

// Alleen admins mogen deze pagina zien
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../Index.php');
    exit();
}

$productBeheer = new ProductBeheer($pdo);
$message = '';

// Product toevoegen
if (isset($_POST['add'])) {
    if ($productBeheer->add($_POST)) {
        $message = '<div class="alert alert-success">Product toegevoegd!</div>';
    } else {
        $message = '<div class="alert alert-danger">Toevoegen mislukt.</div>';
    }
}
// Product verwijderen
if (isset($_POST['delete'])) {
    if ($productBeheer->delete($_POST['id'])) {
        $message = '<div class="alert alert-success">Product verwijderd!</div>';
    } else {
        $message = '<div class="alert alert-danger">Verwijderen mislukt.</div>';
    }
}
// Product bewerken
if (isset($_POST['edit'])) {
    $editProduct = $productBeheer->get($_POST['id']);
}
if (isset($_POST['update'])) {
    if ($productBeheer->update($_POST['id'], $_POST)) {
        $message = '<div class="alert alert-success">Product aangepast!</div>';
    } else {
        $message = '<div class="alert alert-danger">Aanpassen mislukt.</div>';
    }
}
$producten = $productBeheer->getAll();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productbeheer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4 text-center">Productbeheer</h1>
    <?php if ($message) echo $message; ?>
    <div class="row">
        <div class="col-md-5">
            <h4><?php echo isset($editProduct) ? 'Product aanpassen' : 'Nieuw product toevoegen'; ?></h4>
            <form method="post" class="card card-body mb-4">
                <input type="hidden" name="id" value="<?php echo $editProduct['id'] ?? ''; ?>">
                <div class="mb-2">
                    <label class="form-label">Naam</label>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($editProduct['name'] ?? ''); ?>" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Beschrijving</label>
                    <textarea name="description" class="form-control" required><?php echo htmlspecialchars($editProduct['description'] ?? ''); ?></textarea>
                </div>
                <div class="mb-2">
                    <label class="form-label">Prijs</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($editProduct['price'] ?? ''); ?>" required>
                </div>
                <div class="mb-2">
                    <label class="form-label">Voorraad</label>
                    <input type="number" name="stock" class="form-control" value="<?php echo htmlspecialchars($editProduct['stock'] ?? ''); ?>" required>
                </div>
                <?php if (isset($editProduct)): ?>
                    <button type="submit" name="update" class="btn btn-warning">Opslaan</button>
                    <a href="product_beheer.php" class="btn btn-secondary ms-2">Annuleren</a>
                <?php else: ?>
                    <button type="submit" name="add" class="btn btn-primary">Toevoegen</button>
                <?php endif; ?>
            </form>
        </div>
        <div class="col-md-7">
            <h4>Alle producten</h4>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naam</th>
                        <th>Beschrijving</th>
                        <th>Prijs</th>
                        <th>Voorraad</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($producten as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['description']); ?></td>
                        <td>€<?php echo number_format($product['price'], 2, ',', '.'); ?></td>
                        <td><?php echo $product['stock']; ?></td>
                        <td>
                            <form method="post" style="display:inline-block">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                <button type="submit" name="edit" class="btn btn-sm btn-warning">Bewerk</button>
                            </form>
                            <form method="post" style="display:inline-block" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                <button type="submit" name="delete" class="btn btn-sm btn-danger">Verwijder</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4 text-center">
        <a href="../../Index.php" class="btn btn-secondary">Terug naar hoofdpagina</a>
    </div>
</div>
</body>
</html>
