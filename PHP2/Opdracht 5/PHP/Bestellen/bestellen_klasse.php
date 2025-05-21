<?php
include_once '../DB_Con.php';
class Bestellen
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Haal alle producten op uit de database
    public function getProducten()
    {
        $query = "SELECT * FROM products";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Voeg een product toe aan de winkelwagen (sessie)
    public function addToCart($productId)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]++;
        } else {
            $_SESSION['cart'][$productId] = 1;
        }
    }

    // Haal producten uit winkelwagen sessie en bereken totaal
    public function getCartItems($sessionCart)
    {
        $producten = $this->getProducten();
        $cartItems = [];
        $totaal = 0;
        foreach ($sessionCart as $productId) {
            foreach ($producten as $product) {
                if ($product['id'] == $productId) {
                    $cartItems[] = $product;
                    $totaal += $product['price'];
                    break;
                }
            }
        }
        return ['items' => $cartItems, 'totaal' => $totaal];
    }

    // Plaats een bestelling
    public function plaatsBestelling($userId, $producten)
    {
        try {
            $this->pdo->beginTransaction();

            // Voeg bestelling toe aan de orders tabel
            $query = "INSERT INTO orders (user_id, order_date) VALUES (:user_id, NOW())";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $orderId = $this->pdo->lastInsertId();

            // Voeg producten toe aan de order_items tabel
            foreach ($producten as $productId => $aantal) {
                $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, (SELECT price FROM products WHERE id = :product_id_sub))";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':quantity', $aantal, PDO::PARAM_INT);
                $stmt->bindParam(':product_id_sub', $productId, PDO::PARAM_INT);
                $stmt->execute();
            }

            $this->pdo->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw new Exception("Fout bij het plaatsen van de bestelling: " . $e->getMessage());
        }
    }
}
?>