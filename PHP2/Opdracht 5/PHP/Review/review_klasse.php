<?php 
include_once '../DB_Con.php';
class Review
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Plaats een review
    public function add($userId, $rating, $comment)
    {
        $stmt = $this->pdo->prepare("INSERT INTO reviews (user_id, beoordeling, tekst, created_at) VALUES (:user_id, :beoordeling, :tekst, NOW())");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':beoordeling', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':tekst', $comment);
        return $stmt->execute();
    }

    // Haal alle reviews op voor een product
    public function getByProduct($productId)
    {
        $stmt = $this->pdo->prepare("SELECT r.*, u.name as user_name FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = :product_id ORDER BY r.created_at DESC");
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal alle reviews van een gebruiker op
    public function getByUser($userId)
    {
        $stmt = $this->pdo->prepare("SELECT r.*, p.name as product_name FROM reviews r JOIN products p ON r.product_id = p.id WHERE r.user_id = :user_id ORDER BY r.created_at DESC");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>