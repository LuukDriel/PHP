<?php
session_start();
include_once 'account_klasse.php';
include_once '../DB_Con.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../Inlog/Inlog.php');
    exit();
}

$account = new Account($pdo);
$userId = $_SESSION['user_id'];
$updateMessage = '';

if (isset($_POST['update_user'])) {
    if ($account->UpdateUserFromPost($userId, $_POST)) {
        $updateMessage = '<div class="alert alert-success mt-2">Gegevens succesvol bijgewerkt.</div>';
    } else {
        $updateMessage = '<div class="alert alert-danger mt-2">Bijwerken mislukt.</div>';
    }
}

$userData = $account->Getuserdata($userId);
$orderData = $account->Getbestellingdata($userId);
$bestellingenMetProducten = $account->GetBestellingenMetProducten($userId);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h2 class="card-title mb-4 text-center">Mijn Account</h2>
                <?php if ($updateMessage) echo $updateMessage; ?>
                <h5>Gebruikersgegevens</h5>
                <form method="post" class="mb-4">
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <label for="name" class="form-label"><strong>Naam:</strong></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($userData['name']); ?>" required>
                        </li>
                        <li class="list-group-item">
                            <label for="email" class="form-label"><strong>Email:</strong></label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
                        </li>
                        <li class="list-group-item">
                            <label for="password" class="form-label"><strong>Nieuw wachtwoord:</strong></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Laat leeg om niet te wijzigen">
                        </li>
                    </ul>
                    <button type="submit" name="update_user" class="btn btn-primary w-100">Gegevens bijwerken</button>
                </form>
                <h5>Bestellingen</h5>
                <?php if ($bestellingenMetProducten && count($bestellingenMetProducten) > 0): ?>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Bestelnummer</th>
                                    <th>Datum</th>
                                    <th>Product</th>
                                    <th>Aantal</th>
                                    <th>Prijs</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $lastOrderId = null;
                                foreach ($bestellingenMetProducten as $bestel): ?>
                                    <tr>
                                        <td><?php echo ($bestel['order_id'] !== $lastOrderId) ? htmlspecialchars($bestel['order_id']) : ''; ?></td>
                                        <td><?php echo ($bestel['order_id'] !== $lastOrderId) ? htmlspecialchars($bestel['order_date']) : ''; ?></td>
                                        <td><?php echo htmlspecialchars($bestel['product_name']); ?></td>
                                        <td><?php echo htmlspecialchars($bestel['quantity']); ?></td>
                                        <td>€<?php echo number_format($bestel['price'], 2, ',', '.'); ?></td>
                                    </tr>
                                <?php $lastOrderId = $bestel['order_id']; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">Geen bestellingen gevonden.</div>
                <?php endif; ?>
                <div class="d-flex justify-content-between mt-4">
                    <a href="../Inlog/Uitloggen.php" class="btn btn-danger">Uitloggen</a>
                    <form method="post" onsubmit="return confirm('Weet je zeker dat je je account wilt verwijderen? Dit kan niet ongedaan worden!');">
                        <button type="submit" name="delete_account" class="btn btn-outline-danger">Verwijder account</button>
                    </form>
                    <a href="../../Index.php" class="btn btn-secondary">Terug naar hoofdpagina</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
if (isset($_POST['delete_account'])) {
    $account->VerwijderUserEnLogout($userId);
}
?>