<?php
include_once '../DB_Con.php';
class Account
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Haal gebruikersdata op
    public function Getuserdata($userId)
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Haal bestellingsdata op
    public function Getbestellingdata($userId)
    {
        $query = "SELECT * FROM orders WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Haal uitgebreide bestellingsdata op (met producten)
    public function GetBestellingenMetProducten($userId)
    {
        $query = "SELECT o.id as order_id, o.order_date, p.name as product_name, oi.quantity, oi.price
                  FROM orders o
                  JOIN order_items oi ON o.id = oi.order_id
                  JOIN products p ON oi.product_id = p.id
                  WHERE o.user_id = :user_id
                  ORDER BY o.order_date DESC, o.id DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verwijder een gebruiker
    public function VerwijderUser($userId)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Update gebruikersdata
    public function UpdateUser($userId, $data)
    {
        $query = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Update gebruikersdata
    public function UpdateUserFromPost($userId, $postData)
    {
        $user = $this->Getuserdata($userId);
        $updateData = [
            'name' => trim($postData['name']),
            'email' => trim($postData['email']),
            'password' => !empty($postData['password']) ? password_hash($postData['password'], PASSWORD_DEFAULT) : $user['password']
        ];
        return $this->UpdateUser($userId, $updateData);
    }

    // Verwijder een gebruiker en log uit
    public function VerwijderUserEnLogout($userId)
    {
        if ($this->VerwijderUser($userId)) {
            session_unset();
            session_destroy();
            header('Location: ../../Index.php?msg=account_verwijderd');
            exit();
        } else {
            echo '<div class="alert alert-danger mt-2">Account verwijderen mislukt.</div>';
        }
    }
}
?>